<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Mapel;
use App\Models\Episode;
use App\Support\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

use Session;

class MateriController extends Controller
{

    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //hitung materi
            $hitung_materi = Materi::count();

            //menampilkan materi
            $materi = Materi::with('mapel')
                    ->orderBy('id_materi')
                    ->get();

            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
    
        }elseif(auth()->user()->rolename === 'guru'){
            
            $hitung_materi = Materi::count();

            //menampilkan materi
            $materi = Materi::with('mapel')
                    ->orderBy('id_materi')
                    ->get();

            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('guru.materi_guru', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function search_materi(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //cari kata dari input
            $keyword = $request->search;

            //hitung materi
            $hitung_materi = Materi::count();

            Session::forget('danger');
            session()->flash('success', 'Data materi berhasil ditemukan.');
            //cari data dari database

            $materi = Materi::with('mapel')->where('title', 'like', "%".$keyword."%")->get();

            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
        }elseif(auth()->user()->rolename === 'guru'){
            //cari kata dari input
            $keyword = $request->search;

            //hitung materi
            $hitung_materi = Materi::count();

            Session::forget('danger');
            session()->flash('success', 'Data materi berhasil ditemukan.');
            //cari data dari database
            $materi = materi::with('mapel')->where('title', 'like', "%".$keyword."%")->get();

            return view('guru.materi_guru', ['materi' => $materi,'hitung_materi' => $hitung_materi]);

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

    public function hapus_materi($id_materi)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            //hapus data
            $hapus_materi = Materi::where('id_materi', $id_materi)->delete();
            $hitung_materi = Materi::count();
            //menampilkan data
            $materi = Materi::with('mapel')
                    ->orderBy('id_materi')
                    ->get();
            Session::forget('success');
            session()->flash('danger', 'Data materi berhasil dihapus.');
            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi,'hapus_materi' => $hapus_materi]);
        }elseif(auth()->user()->rolename === 'guru'){
            
            session()->start();
            //hapus data
            $hapus_materi = Materi::where('id_materi', $id_materi)->delete();
            $hitung_materi = Materi::count();
            //menampilkan data
            $materi = Materi::with('mapel')
                    ->orderBy('id_materi')
                    ->get();
            Session::forget('success');
            session()->flash('danger', 'Data materi berhasil dihapus.');
            return view('guru.materi_guru', ['materi' => $materi,'hitung_materi' => $hitung_materi,'hapus_materi' => $hapus_materi]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function tambah_materi()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            $mapel = Mapel::with(['kelas','guru'])->get();
            return view('tambah-materi',['mapel' => $mapel]);
        }elseif(auth()->user()->rolename === 'guru'){
            session()->start();

            $mapel = Mapel::with(['kelas','guru'])->where('id_guru', Auth::id())->orderBy('id_mapel', 'asc')->get();
            return view('guru.tambah-materi',['mapel' => $mapel]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function ubah_materi(Request $request, $id_materi)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            $materi = Materi::where('id_materi', $id_materi)->first();
            $mapel = Mapel::with(['kelas','guru'])->get();
            return view('ubah-materi',['mapel' => $mapel, 'materi' => $materi]);
        }elseif(auth()->user()->rolename === 'guru'){
             session()->start();
             $mapel = Mapel::with(['kelas','guru'])->where('id_guru', Auth::id())->orderBy('id_mapel', 'asc')->get();
            $materi = Materi::where('id_materi', $id_materi)->first();
            return view('guru.ubah-materi',['mapel' => $mapel, 'materi' => $materi]);
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

        public function tampil_materi(Request $request, $id_materi)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            session()->start();
            $materi = Materi::with(['mapel', 'guru'])->where('id_materi', $id_materi)->first();
            $tampil = $materi->content;
            $content = str_replace('src="upload/', 'src="'.asset('upload/').'/', $tampil); 
            $mapel = Mapel::with('kelas')->get();
            $episode = Episode::where('id_materi', $id_materi)->orderBy('type')->get();
            $hitung_episode = $episode->count();
            return view('tampil-materi',['mapel' => $mapel, 'hitung_episode' => $hitung_episode,'episode' => $episode,'materi' => $materi, 'content' => $content]);
        }elseif(auth()->user()->rolename === 'guru'){
            session()->start();
            $materi = Materi::with(['mapel', 'guru'])->where('id_materi', $id_materi)->first();
            $tampil = $materi->content;
            $content = str_replace('src="upload/', 'src="'.asset('upload/').'/', $tampil); 
            $mapel = Mapel::with('kelas')->get();
            $episode = Episode::where('id_materi', $id_materi)->orderBy('type')->get();
            $hitung_episode = $episode->count();
            return view('guru.tampil-materi',['mapel' => $mapel, 'hitung_episode' => $hitung_episode,'episode' => $episode,'materi' => $materi, 'content' => $content]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }
}
