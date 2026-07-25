from pathlib import Path

path = Path(r"D:\ngoding\webku\app\Http\Controllers\EpisodeController.php")
text = path.read_text(encoding="utf-8")

# Ensure imports
if "use App\\Support\\ImageUploader;" not in text:
    text = text.replace(
        "use App\\Support\\HtmlSanitizer;",
        "use App\\Support\\HtmlSanitizer;\nuse App\\Support\\ImageUploader;\nuse RuntimeException;"
    )

start = text.index("    public function simpan(Request $request)")
end = text.index("    public function hapus_episode($id_eps)")

new = r'''    public function simpan(Request $request)
    {
        if (auth()->user() === null) {
            return redirect('/');
        }

        $role = auth()->user()->rolename;
        if (! in_array($role, ['admin', 'guru'], true)) {
            return $role === 'pengguna' ? redirect('/info') : redirect('/');
        }

        $validator = Validator::make($request->all(), [
            'nama_eps'  => ['required', 'string', 'max:255'],
            'isi_eps'   => ['required'],
            'id_materi' => ['required'],
            'tgl'       => ['required', 'date'],
            'type'      => ['required'],
            'img'       => ImageUploader::requiredRules(),
        ], [
            'img.required' => 'Cover episode wajib diunggah.',
            'img.image' => 'File cover harus berupa gambar.',
            'img.mimes' => 'Format cover harus JPG, JPEG, PNG, GIF, WEBP, atau BMP.',
            'img.max' => 'Ukuran cover maksimal 10 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('danger', $validator->errors()->first() ?: 'Data tidak dapat disimpan, cek kembali.');
        }

        try {
            $filePath = ImageUploader::storeCover($request->file('img'));
        } catch (RuntimeException $e) {
            return redirect()->back()->withInput()->with('danger', $e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Episode cover upload failed', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('danger', 'Gagal mengunggah cover. Coba foto lain atau ulangi.');
        }

        Episode::create([
            'nama_eps'  => $request->nama_eps,
            'isi_eps'   => HtmlSanitizer::clean($request->isi_eps),
            'tgl'       => $request->tgl,
            'id_materi' => $request->id_materi,
            'type'      => $request->type,
            'img'       => $filePath,
        ]);

        Session::forget('danger');
        session()->flash('success', 'Data episode berhasil disimpan.');

        return redirect()->route('tampil-materi', $request->id_materi);
    }

    public function update_episode(Request $request, $id_eps)
    {
        if (auth()->user() === null) {
            return redirect('/');
        }

        $role = auth()->user()->rolename;
        if (! in_array($role, ['admin', 'guru'], true)) {
            return $role === 'pengguna' ? redirect('/info') : redirect('/');
        }

        $episode = Episode::where('id_eps', $id_eps)->first();
        if (! $episode) {
            return redirect()->route('materi')->with('danger', 'Data episode tidak ditemukan.');
        }

        $validator = Validator::make($request->all(), [
            'nama_eps'  => ['required', 'string', 'max:255'],
            'isi_eps'   => ['required'],
            'id_materi' => ['required'],
            'tgl'       => ['required', 'date'],
            'type'      => ['required'],
            'img'       => ImageUploader::optionalRules(),
        ], [
            'img.image' => 'File cover harus berupa gambar.',
            'img.mimes' => 'Format cover harus JPG, JPEG, PNG, GIF, WEBP, atau BMP.',
            'img.max' => 'Ukuran cover maksimal 10 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('danger', $validator->errors()->first() ?: 'Data tidak dapat disimpan, cek kembali.');
        }

        $data = [
            'nama_eps'  => $request->nama_eps,
            'isi_eps'   => HtmlSanitizer::clean($request->isi_eps),
            'tgl'       => $request->tgl,
            'id_materi' => $request->id_materi,
            'type'      => $request->type,
        ];

        if ($request->hasFile('img')) {
            try {
                $data['img'] = ImageUploader::storeCover($request->file('img'));
            } catch (RuntimeException $e) {
                return redirect()->back()->withInput()->with('danger', $e->getMessage());
            } catch (\Throwable $e) {
                Log::error('Episode cover update failed', ['message' => $e->getMessage()]);
                return redirect()->back()->withInput()->with('danger', 'Gagal mengunggah cover. Coba foto lain atau ulangi.');
            }
        }

        Episode::where('id_eps', $id_eps)->update($data);

        Session::forget('danger');
        session()->flash('success', 'Data episode berhasil diubah.');

        return redirect()->route('tampil-materi', $request->id_materi ?: $episode->id_materi);
    }

'''

path.write_text(text[:start] + new + text[end:], encoding="utf-8")
print("EpisodeController updated OK")
