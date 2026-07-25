<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Mapel;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Session;
use App\Support\HtmlSanitizer;
use App\Support\ImageUploader;
use RuntimeException;

class EpisodeController extends Controller
{

    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //hitung episode
            $hitung_episode = Episode::count();

            //menampilkan episode
            $episode = Episode::orderBy('id_episode', 'asc')->get();

            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('episode', ['episode' => $episode,'hitung_episode' => $hitung_episode]);
    
        }elseif(auth()->user()->rolename === 'guru'){
            $hitung_episode = Episode::count();

            //menampilkan episode
            $episode = Episode::orderBy('id_episode', 'asc')->get();

            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('guru.episode_guru', ['episode' => $episode,'hitung_episode' => $hitung_episode]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function search_episode(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //cari kata dari input
            $keyword = $request->search;

            //hitung episode
            $hitung_episode = episode::count();

            Session::forget('danger');
            session()->flash('success', 'Data episode berhasil ditemukan.');
            //cari data dari database
            $episode = episode::where('title', 'like', "%".$keyword."%")->get();

            return view('Episode', ['episode' => $episode,'hitung_episode' => $hitung_episode]);
        }elseif(auth()->user()->rolename === 'guru'){
            //cari kata dari input
            $keyword = $request->search;

            //hitung episode
            $hitung_episode = Episode::count();

            Session::forget('danger');
            session()->flash('success', 'Data episode berhasil ditemukan.');
            //cari data dari database
            $episode = Episode::where('title', 'like', "%".$keyword."%")->get();

            return view('guru.episode_guru', ['episode' => $episode,'hitung_episode' => $hitung_episode]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function simpan(Request $request)
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

    public function hapus_episode($id_eps)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            //hapus data
            $hapus_episode = Episode::where('id_eps', $id_eps)->delete();
            $episode = Episode::orderBy('id_eps', 'asc')->get();
            $hitung_materi = Materi::count();

            //menampilkan materi
            $materi = Materi::orderBy('id_materi', 'asc')->get();
            Session::forget('success');
            session()->flash('danger', 'Data episode berhasil dihapus.');
           return view('materi', ['episode' => $episode,'materi' => $materi,'hitung_materi' => $hitung_materi]);
        }elseif(auth()->user()->rolename === 'guru'){
            
            session()->start();
            //hapus data
            $hapus_episode = Episode::where('id_eps', $id_eps)->delete();
            $episode = Episode::orderBy('id_eps', 'asc')->get();
            $hitung_materi = Materi::count();

            //menampilkan materi
            $materi = Materi::orderBy('id_materi', 'asc')->get();
            Session::forget('success');
            session()->flash('danger', 'Data episode berhasil dihapus.');
            return view('guru.materi_guru', ['episode' => $episode,'materi' => $materi,'hitung_materi' => $hitung_materi]);


        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function tambah_episode(Request $request, $id_materi)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            $mapel = Mapel::with('kelas')->get();
            return view('tambah-episode',['mapel' => $mapel,'id_materi' => $id_materi]);
        }elseif(auth()->user()->rolename === 'guru'){
            session()->start();

            $mapel = Mapel::with('kelas')->get();
            return view('guru.tambah-episode',['mapel' => $mapel,'id_materi' => $id_materi]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function ubah_episode(Request $request, $id_eps)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            $episode = Episode::where('id_eps', $id_eps)->first();
            $mapel = Mapel::with('kelas')->get();
            return view('ubah-episode',['mapel' => $mapel, 'episode' => $episode]);
        }elseif(auth()->user()->rolename === 'guru'){
             session()->start();
            $episode = Episode::where('id_eps', $id_eps)->first();
            $mapel = Mapel::with('kelas')->get();
            return view('guru.ubah-episode',['mapel' => $mapel, 'episode' => $episode]);
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function tampil_episode(Request $request, $id_eps)
    {
        if (auth()->user() === null) {
            return redirect('/');
        }

        $role = auth()->user()->rolename;

        if (! in_array($role, ['admin', 'guru', 'pengguna'], true)) {
            return redirect('/');
        }

        session()->start();

        $episode = Episode::where('id_eps', $id_eps)->firstOrFail();
        $materi = Materi::where('id_materi', $episode->id_materi)->first();

        $tampil = $episode->isi_eps;
        $content = HtmlSanitizer::clean($tampil);
        $uploadUrl = rtrim(asset('upload'), '/') . '/';
        $content = str_replace(
            ['src="/upload/', "src='/upload/", 'src="upload/', "src='upload/"],
            ['src="' . $uploadUrl, "src='" . $uploadUrl, 'src="' . $uploadUrl, "src='" . $uploadUrl],
            $content
        );

        // Navigasi episode sebelumnya / berikutnya (urut type lalu id)
        $siblings = Episode::where('id_materi', $episode->id_materi)
            ->orderByRaw('CAST(type AS UNSIGNED) ASC')
            ->orderBy('id_eps', 'asc')
            ->get(['id_eps', 'nama_eps', 'type']);

        $currentIndex = $siblings->search(fn ($item) => (int) $item->id_eps === (int) $episode->id_eps);
        $prevEpisode = $currentIndex !== false && $currentIndex > 0
            ? $siblings[$currentIndex - 1]
            : null;
        $nextEpisode = $currentIndex !== false && $currentIndex < $siblings->count() - 1
            ? $siblings[$currentIndex + 1]
            : null;

        $data = [
            'episode' => $episode,
            'materi' => $materi,
            'content' => $content,
            'prevEpisode' => $prevEpisode,
            'nextEpisode' => $nextEpisode,
            'episodeIndex' => $currentIndex !== false ? $currentIndex + 1 : 1,
            'episodeTotal' => $siblings->count(),
            'hitung_episode' => $siblings->count(),
        ];

        if ($role === 'admin') {
            return view('tampil-episode', $data);
        }

        if ($role === 'guru') {
            return view('guru.tampil-episode', $data);
        }

        return view('pengguna.tampil-episode', $data);
    }
}
