<?php

namespace App\Http\Controllers;

use App\Models\Hasil;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Session;

class LaporanController extends Controller
{
    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //tampil data hasil diagnosis
            $hasil_diagnosis = Hasil::paginate(10);

            //menghapus session notif
            Session::forget('danger');
            Session::forget('success');

            return view('laporan', ['hasil_diagnosis' => $hasil_diagnosis]);
        

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function search_hasil(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //ambil data dari input cari
            $keyword = $request->search;

            //menghapus session notif
            Session::forget('danger');
            session()->flash('success', 'Data hasil diagnosis berhasil ditemukan.');

            //cari data dan tampilkan data hasil
            $hasil_diagnosis = Hasil::where('idpengguna', 'like', "%".$keyword."%")->paginate(10);
            return view('laporan', ['hasil_diagnosis' => $hasil_diagnosis]);


        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }


    }

    
    public function hapus_laporan($id_hasil)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            //hapus data hasil diagnosis
            $hasil_diagnosis = Hasil::where('id_hasil', $id_hasil)->delete();
    
            //tampilkan data hasil
            $hasil_diagnosis = Hasil::paginate(10);
            session()->flash('danger', 'Data Hasil Diagnosis berhasil dihapus.');
            return view('laporan', ['hasil_diagnosis' => $hasil_diagnosis]);
       
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }
}
