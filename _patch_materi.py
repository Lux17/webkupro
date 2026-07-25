from pathlib import Path

path = Path(r"D:\ngoding\webku\app\Http\Controllers\MateriController.php")
text = path.read_text(encoding="utf-8")
start = text.index("    public function simpan(Request $request)")
end = text.index("    public function hapus_materi($id_materi)")

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
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:1'],
            'id_mapel' => ['required'],
            'tgl' => ['required'],
            'img' => ImageUploader::requiredRules(),
        ], [
            'img.required' => 'Cover wajib diunggah.',
            'img.image' => 'File cover harus berupa gambar.',
            'img.mimes' => 'Format cover harus JPG, JPEG, PNG, GIF, WEBP, atau BMP.',
            'img.max' => 'Ukuran cover maksimal 10 MB.',
            'title.required' => 'Judul materi wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'id_mapel.required' => 'Mata pelajaran wajib dipilih.',
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
            return redirect()->back()
                ->withInput()
                ->with('danger', $e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Materi cover upload failed', ['message' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Gagal mengunggah cover. Coba foto lain atau ulangi.');
        }

        Materi::insert([
            'title' => $request->title,
            'deskripsi' => $request->deskripsi,
            'tgl' => $request->tgl,
            'img' => $filePath,
            'id_mapel' => $request->id_mapel,
            'id_guru' => $request->id_guru ?: (auth()->user()->rolename === 'guru' ? auth()->id() : null),
        ]);

        Session::forget('danger');
        session()->flash('success', 'Data materi berhasil disimpan.');

        return redirect()->route('materi');
    }

    public function update_materi(Request $request, $id_materi)
    {
        if (auth()->user() === null) {
            return redirect('/');
        }

        $role = auth()->user()->rolename;
        if (! in_array($role, ['admin', 'guru'], true)) {
            return $role === 'pengguna' ? redirect('/info') : redirect('/');
        }

        $materi = Materi::where('id_materi', $id_materi)->first();
        if (! $materi) {
            return redirect()->route('materi')->with('danger', 'Data materi tidak ditemukan.');
        }

        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:1'],
            'id_mapel' => ['required'],
            'tgl' => ['required'],
            'img' => ImageUploader::optionalRules(),
        ], [
            'img.image' => 'File cover harus berupa gambar.',
            'img.mimes' => 'Format cover harus JPG, JPEG, PNG, GIF, WEBP, atau BMP.',
            'img.max' => 'Ukuran cover maksimal 10 MB.',
            'title.required' => 'Judul materi wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'id_mapel.required' => 'Mata pelajaran wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('danger', $validator->errors()->first() ?: 'Data tidak dapat disimpan, cek kembali.');
        }

        $data = [
            'title' => $request->title,
            'deskripsi' => $request->deskripsi,
            'tgl' => $request->tgl,
            'id_mapel' => $request->id_mapel,
            'id_guru' => $request->id_guru ?: $materi->id_guru,
        ];

        // Cover opsional saat ubah — jika tidak diganti, cover lama dipertahankan.
        if ($request->hasFile('img')) {
            try {
                $data['img'] = ImageUploader::storeCover($request->file('img'));
            } catch (RuntimeException $e) {
                return redirect()->back()
                    ->withInput()
                    ->with('danger', $e->getMessage());
            } catch (\Throwable $e) {
                Log::error('Materi cover update failed', ['message' => $e->getMessage()]);
                return redirect()->back()
                    ->withInput()
                    ->with('danger', 'Gagal mengunggah cover. Coba foto lain atau ulangi.');
            }
        }

        Materi::where('id_materi', $id_materi)->update($data);

        Session::forget('danger');
        session()->flash('success', 'Data materi berhasil diubah.');

        return redirect()->route('materi');
    }

'''

path.write_text(text[:start] + new + text[end:], encoding="utf-8")
print("MateriController updated OK")
