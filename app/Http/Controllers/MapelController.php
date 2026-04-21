<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\User;
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

class MapelController extends Controller
{
    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            

            //hitung jumlah mapel
            $hitung_mapel = Mapel::all()->count();

            //tampil dan urutkan
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $mapel2 = Mapel::with(['kelas','guru'])->get();
            $kelas = Kelas::all();
            $guru = User::with('mapel')->where('rolename', 'like', 'guru')->get();
            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('mapel', ['mapel' => $mapel, 'guru' => $guru,'mapel2' => $mapel2,'kelas' => $kelas,'hitung_mapel' => $hitung_mapel]);
    

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function search_mapel(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //ambil data dari input
            $keyword = $request->search;

            //hitung jumlah mapel
            $hitung_mapel = Mapel::all()->count();

            $kelas = Kelas::all();

           $guru = User::with('mapel')->where('rolename', 'like', 'guru')->get();

            //cari data dari database
        $mapel2 = Mapel::with('kelas')
        ->where('nama_mapel', 'like', "%".$keyword."%")
        ->paginate(10);
            Session::forget('danger');
            session()->flash('success', 'Data mapel berhasil ditemukan.');
            return view('mapel', ['mapel2' => $mapel2,'guru' => $guru,'kelas' => $kelas,'hitung_mapel' => $hitung_mapel]);
        
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
            // $validator = Validator::make($request->all(), [
            //     'nama_mapel' => ['required', 'unique:mapel'],
            //     'id_kelas' => ['required', 'unique:mapel'],
            // ]);

            // if ($validator->fails()) {
            //     session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
            //     return redirect('mapel')->withErrors($validator)->withInput();
            // }

            $hitung_mapel = Mapel::all()->count();

            $kelas = Kelas::all();

            $guru = User::with('mapel')->where('rolename', 'like', 'guru')->get();


                $idnext = $hitung_mapel + 1;
                //input ke database
                Mapel::insert([
                    'id_mapel' => $idnext,
                    'nama_mapel' => $request->nama_mapel,
                    'id_kelas' => $request->id_kelas,
                    'id_guru' => $request->id_guru,

                ]);
            
                $hitung_mapel = Mapel::all()->count();
                $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
                $mapel2 = Mapel::with('kelas')->get();
                //menampilkan pesan 
                Session::forget('danger');
                session()->flash('success', 'Data mapel berhasil disimpan.');
                return view('mapel', ['mapel' => $mapel,'guru' => $guru,'mapel2' => $mapel2,'kelas' => $kelas, 'hitung_mapel' => $hitung_mapel]);
            

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

        
    }
    
    public function update_mapel(Request $request, $id_mapel)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'id_mapel' => ['required', 'min:1'],
                'nama_mapel' => ['required', 'max:100'],
                'id_guru' => ['required', 'min:1'],
            ]);
            
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('mapel')->withErrors($validator)->withInput();
            }
    

            //update data 
            $preferences = Mapel::where('id_mapel', $id_mapel)
                     ->update([
                    'id_mapel' => request()->id_mapel,
                    'nama_mapel' => request()->nama_mapel,
                    'id_guru' => $request->id_guru,

            
                ]);
            
            $hitung_mapel = Mapel::all()->count();
            $kelas = Kelas::all();

           $guru = User::with('mapel')->where('rolename', 'like', 'guru')->get();
            //menampilkan dan mengurutkan data
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $mapel2 = Mapel::with('kelas')->get();
            Session::forget('danger');
            session()->flash('success', 'Data mapel berhasil diubah.');
            return view('mapel', ['mapel' => $mapel, 'guru' => $guru,'mapel2' => $mapel2, 'kelas' => $kelas,'hitung_mapel' => $hitung_mapel]);
        
            
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }


    }


    public function hapus_mapel($id_mapel)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){

            session()->start();
            //menghapus data mapel
            $cari_namamapel = Mapel::where('id_mapel', $id_mapel)->pluck('nama_mapel');
            $hapus_mapel = Mapel::where('id_mapel', $id_mapel)->delete();
            $hitung_mapel = Mapel::all()->count();
            //menampilkan
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $mapel2 = Mapel::with('kelas')->get();

            $kelas = Kelas::all();
            $guru = User::with('mapel')->where('rolename', 'like', 'guru')->get();
            Session::forget('success');
            session()->flash('danger', 'Data mapel berhasil dihapus.');
            return view('mapel', ['mapel' => $mapel, 'guru' => $guru,'mapel2' => $mapel2, 'kelas' => $kelas,'hitung_mapel' => $hitung_mapel]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
    }
}
