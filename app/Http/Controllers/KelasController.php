<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Aturan;
use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;
use File;
use Session;

class KelasController extends Controller
{
    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            

            //hitung jumlah kelas
            $hitung_kelas = Kelas::all()->count();

            //tampil dan urutkan
            $kelas = Kelas::orderBy('id_kelas', 'asc')->get();
            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('kelas', ['kelas' => $kelas,'hitung_kelas' => $hitung_kelas]);
    

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function search_kelas(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //ambil data dari input
            $keyword = $request->search;

            //hitung jumlah kelas
            $hitung_kelas = Kelas::all()->count();

            //cari data dari database
            $kelas = Kelas::where('nama_kelas', 'like', "%".$keyword."%")->paginate();
            Session::forget('danger');
            session()->flash('success', 'Data kelas berhasil ditemukan.');
            return view('kelas', ['kelas' => $kelas,'hitung_kelas' => $hitung_kelas]);
        
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
                'nama_kelas' => ['required', 'unique:Kelas'],
            ]);

            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('kelas')->withErrors($validator)->withInput();
            }

            $hitung_kelas = Kelas::all()->count();


                $idnext = $hitung_kelas + 1;
                //input ke database
                Kelas::insert([
                    'id_kelas' => $idnext,
                  
                    'nama_kelas' => $request->nama_kelas,
                ]);
            
                $hitung_kelas = kelas::all()->count();
                $kelas = Kelas::orderBy('id_kelas', 'asc')->get();
                //menampilkan pesan 
                Session::forget('danger');
                session()->flash('success', 'Data kelas berhasil disimpan.');
                return view('kelas', ['kelas' => $kelas,'hitung_kelas' => $hitung_kelas]);
            

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

        
    }
    
    public function update_kelas(Request $request, $id_kelas)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'id_kelas' => ['required', 'min:1'],
                'nama_kelas' => ['required', 'max:100'],
            ]);
            
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('kelas')->withErrors($validator)->withInput();
            }
    

            //update data 
            $preferences = Kelas::where('id_kelas', $id_kelas)
                     ->update([
                    'id_kelas' => request()->id_kelas,
                    'nama_kelas' => request()->nama_kelas,

            
                ]);
            
            $hitung_kelas = Kelas::all()->count();
            //menampilkan dan mengurutkan data
            $kelas = Kelas::orderBy('id_kelas', 'asc')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kelas berhasil diubah.');
            return view('kelas', ['kelas' => $kelas,'hitung_kelas' => $hitung_kelas]);
        
            
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }


    }


    public function hapus_kelas($id_kelas)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){

            session()->start();
            //menghapus data kelas
            $cari_namakelas = Kelas::where('id_kelas', $id_kelas)->pluck('nama_kelas');
            $hapus_kelas = Kelas::where('id_kelas', $id_kelas)->delete();
            $hitung_kelas = Kelas::all()->count();
            //menampilkan
            $kelas = Kelas::orderBy('id_kelas', 'asc')->get();
            Session::forget('success');
            session()->flash('danger', 'Data kelas berhasil dihapus.');
            return view('kelas', ['kelas' => $kelas,'hitung_kelas' => $hitung_kelas]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
    }
}
