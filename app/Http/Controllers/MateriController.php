<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
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
            $materi = Materi::orderBy('id_materi', 'asc')->get();

            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
    

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
            $materi = materi::where('nama_materi', 'like', "%".$keyword."%")->get();

            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
    

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
                'content' => ['required', 'min:1'],
                'id_mapel' => ['required', 'min:1'],
                'id_guru' => ['required', 'min:1'],
                'tgl' => ['required', 'min:1']
            ]);
            
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('materi')->withErrors($validator)->withInput();
            }
            
            $hitung_materi = materi::count();
            //nilai untuk id
            $idnext = $hitung_materi + 1;
            Materi::insert([
                'id_materi' => $idnext,
                'title' => $request->title,
                'content' => $request->content,
                'tgl' => $request->tgl,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
            ]);

            //menampilkan data
            $materi = Materi::orderBy('id_materi', 'asc')->get();
            Session::forget('danger');
            session()->flash('success', 'Data materi berhasil disimpan.');
            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
    
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
                'content' => ['required', 'min:1'],
                'id_mapel' => ['required', 'min:1'],
                'id_guru' => ['required', 'min:1'],
                'tgl' => ['required', 'min:1']
            ]);
    
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('materi')->withErrors($validator)->withInput();
            }
            //update data
            $preferences = Materi::where('id_materi', $id_materi)
                ->update([
                'title' => $request->title,
                'content' => $request->content,
                'tgl' => $request->tgl,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
                ]);
    
            $hitung_materi = Materi::count();
            //menampilkan data
            $materi = Materi::orderBy('id_materi', 'asc')->get();
            Session::forget('danger');
            session()->flash('success', 'Data materi berhasil diubah.');
            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
      
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
            //menampilkan data
            $materi = Materi::orderBy('id_materi', 'asc')->get();
            Session::forget('success');
            session()->flash('danger', 'Data materi berhasil dihapus.');
            return view('materi', ['materi' => $materi,'hitung_materi' => $hitung_materi]);
        
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




            return view('tambah-materi');
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }
}
