<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Mapel;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
             //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'min:1'],
                'deskripsi' => ['required', 'min:1'],
                'id_mapel' => ['required', 'min:1'],
                'tgl' => ['required', 'min:1']
            ]);
            
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('materi')->withErrors($validator)->withInput();
            }

            $file = $request->file('img');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('upload'), $fileName);

            $filePath = 'upload/' . $fileName;
    

            
            $hitung_materi = Materi::count();
            //nilai untuk id
          
            Materi::insert([
                'title' => $request->title,
                'deskripsi' => $request->deskripsi,
                'tgl' => $request->tgl,
                'img' => $filePath,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
            ]);

            //menampilkan data
            $materi = Materi::with('mapel')
                    ->orderBy('id_materi')
                    ->get();
            Session::forget('danger');
            session()->flash('success', 'Data materi berhasil disimpan.');
            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
        }elseif(auth()->user()->rolename === 'guru'){

             //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'min:1'],
                'deskripsi' => ['required', 'min:1'],
                'id_mapel' => ['required', 'min:1'],
                'tgl' => ['required', 'min:1']
            ]);
            
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('materi')->withErrors($validator)->withInput();
            }

            $file = $request->file('img');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('upload'), $fileName);

            $filePath = '/upload/' . $fileName;
    

            
            $hitung_materi = Materi::count();
            //nilai untuk id
          
            Materi::insert([
                'title' => $request->title,
                'deskripsi' => $request->deskripsi,
                'tgl' => $request->tgl,
                'img' => $filePath,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
            ]);

            //menampilkan data
             $materi = Materi::with('mapel')
                    ->orderBy('id_materi')
                    ->get();
            Session::forget('danger');
            session()->flash('success', 'Data materi berhasil disimpan.');
            return view('guru.materi_guru', ['materi' => $materi,'hitung_materi' => $hitung_materi]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

  }
    
    public function update_materi(Request $request, $id_materi)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'min:1'],
                'deskripsi' => ['required', 'min:1'],
                'id_mapel' => ['required', 'min:1'],
                'tgl' => ['required', 'min:1']
            ]);
    
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('materi')->withErrors($validator)->withInput();
            }
            //update data

            $file = $request->file('img');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('upload'), $fileName);

            $filePath = '/upload/' . $fileName;
    

            
            $preferences = Materi::where('id_materi', $id_materi)
                ->update([
                'title' => $request->title,
                'deskripsi' => $request->deskripsi,
                'tgl' => $request->tgl,
                'img' => $filePath,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
                ]);
    
            $hitung_materi = Materi::count();
            //menampilkan data
             $materi = Materi::with('mapel')
                    ->orderBy('id_materi')
                    ->get();
            Session::forget('danger');
            session()->flash('success', 'Data materi berhasil diubah.');
            
            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
        }elseif(auth()->user()->rolename === 'guru'){
            session()->start();

            //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'min:1'],
                'deskripsi' => ['required', 'min:1'],
                'id_mapel' => ['required', 'min:1'],
                'tgl' => ['required', 'min:1']
            ]);
    
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('materi')->withErrors($validator)->withInput();
            }
            //update data

            $file = $request->file('img');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('upload'), $fileName);

            $filePath = 'upload/' . $fileName;
    

            
            $preferences = Materi::where('id_materi', $id_materi)
                ->update([
                'title' => $request->title,
                'deskripsi' => $request->deskripsi,
                'tgl' => $request->tgl,
                'img' => $filePath,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
                ]);
    
    
            $hitung_materi = Materi::count();
            //menampilkan data
            $materi = Materi::orderBy('id_materi', 'asc')->get();
            Session::forget('danger');
            session()->flash('success', 'Data materi berhasil diubah.');
            
            return view('guru.materi_guru', ['materi' => $materi,'hitung_materi' => $hitung_materi]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

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
            $materi = Materi::where('id_materi', $id_materi)->first();
            $tampil = $materi->content;
            $content = str_replace('src="upload/', 'src="'.asset('upload/').'/', $tampil); 
            $mapel = Mapel::with('kelas')->get();
            $episode = Episode::where('id_materi', $id_materi)->get();
            $hitung_episode = Episode::where('id_materi', $id_materi)->count();
            return view('tampil-materi',['mapel' => $mapel, 'hitung_episode' => $hitung_episode,'episode' => $episode,'materi' => $materi, 'content' => $content]);
        }elseif(auth()->user()->rolename === 'guru'){
            session()->start();
            $materi = Materi::where('id_materi', $id_materi)->first();
            $tampil = $materi->content;
            $content = str_replace('src="upload/', 'src="'.asset('upload/').'/', $tampil); 
            $mapel = Mapel::with('kelas')->get();
            $episode = Episode::where('id_materi', $id_materi)->get();
            $hitung_episode = Episode::where('id_materi', $id_materi)->count();
            return view('guru.tampil-materi',['mapel' => $mapel, 'hitung_episode' => $hitung_episode,'episode' => $episode,'materi' => $materi, 'content' => $content]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }
}
