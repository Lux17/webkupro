<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Analisa;
use App\Models\Aturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Session;

class GejalaController extends Controller
{

    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //hitung gejala
            $hitung_gejala = Gejala::count();

            //menampilkan gejala
            $gejala = Gejala::orderBy('id_gejala', 'asc')->get();

            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            //menampilkan data penyakit
            $penyakit = Penyakit::all();
            return view('gejala', ['gejala' => $gejala,'penyakit' => $penyakit,'hitung_gejala' => $hitung_gejala]);
    

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function search_gejala(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //cari kata dari input
            $keyword = $request->search;

            //hitung gejala
            $hitung_gejala = Gejala::count();

            //menampilkan data penyakit
            $penyakit = Penyakit::all();

            Session::forget('danger');
            session()->flash('success', 'Data gejala berhasil ditemukan.');
            //cari data dari database
            $gejala = Gejala::where('nama_gejala', 'like', "%".$keyword."%")->get();

            return view('gejala', ['gejala' => $gejala,'penyakit' => $penyakit,'hitung_gejala' => $hitung_gejala]);
    

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
                'kode_gejala' => ['required', 'min:1'],
                'nama_gejala' => ['required', 'min:1'],
                'jenis' => ['required', 'min:1'],
                'type' => ['required', 'min:1']
            ]);
            
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('gejala')->withErrors($validator)->withInput();
            }
            
            $hitung_gejala = Gejala::count();
            //nilai untuk id
            $idnext = $hitung_gejala + 1;
            Gejala::insert([
                'id_gejala' => $idnext,
                'kode_gejala' => $request->kode_gejala,
                'nama_gejala' => $request->nama_gejala,
                'jenis' => $request->jenis,
                'type' => $request->type,
            ]);

            //menampilkan data
            $gejala = Gejala::orderBy('id_gejala', 'asc')->get();
            $penyakit = Penyakit::all();
            Session::forget('danger');
            session()->flash('success', 'Data gejala berhasil disimpan.');
            return view('gejala', ['gejala' => $gejala,'penyakit' => $penyakit,'hitung_gejala' => $hitung_gejala]);
    
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

  }
    
    public function update_gejala(Request $request, $id_gejala)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'kode_gejala' => ['required', 'min:1'],
                'nama_gejala' => ['required', 'min:1'],
                'jenis' => ['required', 'min:1'],
                'type' => ['required', 'min:1'],
            ]);
    
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('gejala')->withErrors($validator)->withInput();
            }
            //update data
            $preferences = Gejala::where('id_gejala', $id_gejala)
                ->update([
                    'kode_gejala' => request()->kode_gejala,
                    'nama_gejala' => request()->nama_gejala,
                    'jenis' => request()->jenis,
                    'type' => request()->type
                ]);
    
            $hitung_gejala = Gejala::count();
            //menampilkan data
            $gejala = Gejala::orderBy('id_gejala', 'asc')->get();
            $penyakit = Penyakit::all();
            Session::forget('danger');
            session()->flash('success', 'Data gejala berhasil diubah.');
            return view('gejala', ['gejala' => $gejala,'penyakit' => $penyakit,'hitung_gejala' => $hitung_gejala]);
      
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

  }


    public function hapus_gejala($id_gejala)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            //hapus data
            $cari_penyakit = Gejala::where('id_gejala', $id_gejala)->pluck('jenis');
            $id_penyakit = Penyakit::where('nama_penyakit', $cari_penyakit)->pluck('id_penyakit');
            $hapus_aturan = Aturan::where('idpenyakit', $id_penyakit)->delete();
            $hapus_analisa = Analisa::where('gejala', $id_gejala)->delete();
            $hapus_gejala = Gejala::where('id_gejala', $id_gejala)->delete();
            $hitung_gejala = Gejala::count();
            //menampilkan data
            $gejala = Gejala::orderBy('id_gejala', 'asc')->get();
            $penyakit = Penyakit::all();
            Session::forget('success');
            session()->flash('danger', 'Data gejala berhasil dihapus.');
            return view('gejala', ['gejala' => $gejala,'penyakit' => $penyakit,'hitung_gejala' => $hitung_gejala]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }
}
