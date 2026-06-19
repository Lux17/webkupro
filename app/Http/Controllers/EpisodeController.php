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
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            // Validasi
            $validator = Validator::make($request->all(), [
                'nama_eps'   => 'required|string|max:255',
                'isi_eps'    => 'required',
                'id_materi'  => 'required',
                'tgl'        => 'required|date',
                'type'       => 'required',
                'img'        => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('danger', 'Data tidak dapat disimpan, cek kembali.');
            }

            // Upload gambar
            $file = $request->file('img');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('upload'), $fileName);

            $filePath = 'upload/' . $fileName;

            // Simpan data
            Episode::create([
                'nama_eps'  => $request->nama_eps,
                'isi_eps'   => $request->isi_eps,
                'tgl'       => $request->tgl,
                'id_materi' => $request->id_materi,
                'type'      => $request->type,
                'img'       => $filePath,
            ]);


            //menampilkan data
            $episode = Episode::orderBy('id_eps', 'asc')->get();
            $hitung_materi = Materi::count();

            //menampilkan materi
            $materi = Materi::orderBy('id_materi', 'asc')->get();
            Session::forget('danger');
            session()->flash('success', 'Data episode berhasil disimpan.');
            return view('materi', ['episode' => $episode,'materi' => $materi,'hitung_materi' => $hitung_materi]);
        }elseif(auth()->user()->rolename === 'guru'){

            // Validasi
            $validator = Validator::make($request->all(), [
                'nama_eps'   => 'required|string|max:255',
                'isi_eps'    => 'required',
                'id_materi'  => 'required',
                'tgl'        => 'required|date',
                'type'       => 'required',
                'img'        => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('danger', 'Data tidak dapat disimpan, cek kembali.');
            }

            // Upload gambar
            $file = $request->file('img');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('upload'), $fileName);

            $filePath = 'upload/' . $fileName;

            // Simpan data
            Episode::create([
                'nama_eps'  => $request->nama_eps,
                'isi_eps'   => $request->isi_eps,
                'tgl'       => $request->tgl,
                'id_materi' => $request->id_materi,
                'type'      => $request->type,
                'img'       => $filePath,
            ]);
            //menampilkan data
            $episode = Episode::orderBy('id_eps', 'asc')->get();
            $hitung_materi = Materi::count();

            //menampilkan materi
            $materi = Materi::orderBy('id_materi', 'asc')->get();
            Session::forget('danger');
            session()->flash('success', 'Data episode berhasil disimpan.');
            return view('guru.materi_guru', ['episode' => $episode,'materi' => $materi,'hitung_materi' => $hitung_materi]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

  }
    
    public function update_episode(Request $request, $id_eps)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
        // Validasi
        

            $file = $request->file('img');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('upload'), $fileName);

            $filePath = 'upload/' . $fileName;
    

        Episode::where('id_eps', $id_eps)->Update([
                'nama_eps'  => $request->nama_eps,
                'isi_eps'   => $request->isi_eps,
                'tgl'       => $request->tgl,
                'id_materi' => $request->id_materi,
                'type'      => $request->type,
                'img'       => $filePath,
            ]);

        // Menampilkan data
        $episode = Episode::orderBy('id_eps', 'asc')->get();
        $materi = Materi::orderBy('id_materi', 'asc')->get();
        $hitung_materi = Materi::count();

        Session::forget('danger');
        session()->flash('success', 'Data episode berhasil diubah.');
            
        return view('materi', ['episode' => $episode,'hitung_materi' => $hitung_materi, 'materi' => $materi]);

        }elseif(auth()->user()->rolename === 'guru'){
        session()->start();


            $file = $request->file('img');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('upload'), $fileName);

            $filePath = 'upload/' . $fileName;
    

        Episode::where('id_eps', $id_eps)->Update([
                'nama_eps'  => $request->nama_eps,
                'isi_eps'   => $request->isi_eps,
                'tgl'       => $request->tgl,
                'id_materi' => $request->id_materi,
                'type'      => $request->type,
                'img'       => $filePath,
            ]);

        // Menampilkan data
        $episode = Episode::orderBy('id_eps', 'asc')->get();
        $materi = Materi::orderBy('id_materi', 'asc')->get();
        $hitung_materi = Materi::count();

        Session::forget('danger');
        session()->flash('success', 'Data episode berhasil diubah.');
            
        return view('guru.materi_guru', ['episode' => $episode,'hitung_materi' => $hitung_materi, 'materi' => $materi]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

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
            return view('tambah-episode',['mapel' => $mapel]);
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
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            $episode = Episode::where('id_eps', $id_eps)->first();
            $tampil = $episode->isi_eps;
            $content = str_replace('src="upload/', 'src="'.asset('upload/').'/', $tampil); 
            $mapel = Mapel::with('kelas')->get();
            return view('tampil-episode',['mapel' => $mapel, 'episode' => $episode, 'content' => $content]);
        }elseif(auth()->user()->rolename === 'guru'){
            session()->start();
            $episode = Episode::where('id_eps', $id_eps)->first();
           
            $tampil = $episode->isi_eps;
           
            $content = str_replace('src="upload/', 'src="'.asset('upload/').'/', $tampil); 
            $mapel = Mapel::with('kelas')->get();

            $hitung_episode = Episode::where('id_eps', $id_eps)->count();
            return view('guru.tampil-episode',['mapel' => $mapel, 'hitung_episode' => $hitung_episode,'episode' => $episode,'content' => $content]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            session()->start();
            $episode = Episode::where('id_eps', $id_eps)->first();
           
            $tampil = $episode->isi_eps;
           
            $content = str_replace('src="upload/', 'src="'.asset('upload/').'/', $tampil); 
            $mapel = Mapel::with('kelas')->get();

            $hitung_episode = Episode::where('id_eps', $id_eps)->count();
            return view('pengguna.tampil-episode',['mapel' => $mapel, 'hitung_episode' => $hitung_episode,'episode' => $episode,'content' => $content]);
        }else{
            return redirect('/');
        }

    }
}
