<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
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

class PenyakitController extends Controller
{
    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            

            //hitung jumlah penyakit
            $hitung_penyakit = Penyakit::all()->count();

            //tampil dan urutkan
            $penyakit = Penyakit::orderBy('kode_penyakit', 'asc')->get();
            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('penyakit', ['penyakit' => $penyakit,'hitung_penyakit' => $hitung_penyakit]);
    

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function search_penyakit(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //ambil data dari input
            $keyword = $request->search;

            //hitung jumlah penyakit
            $hitung_penyakit = Penyakit::all()->count();

            //cari data dari database
            $penyakit = Penyakit::where('nama_penyakit', 'like', "%".$keyword."%")->paginate();
            Session::forget('danger');
            session()->flash('success', 'Data Penyakit berhasil ditemukan.');
            return view('penyakit', ['penyakit' => $penyakit,'hitung_penyakit' => $hitung_penyakit]);
        
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
                'kode_penyakit' => ['required', 'unique:penyakit'],
                'nama_penyakit' => ['required', 'unique:penyakit'],
                'images' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                'solusi' => ['required', 'min:1'],
            ]);

            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('penyakit')->withErrors($validator)->withInput();
            }

            $hitung_penyakit = Penyakit::all()->count();

            //Cek ada file images ada engga
            if($request->hasFile('images')) { 
                //Memberi nama pada images    
                $imageName = time().'.'.$request->images->extension();
                //memindahkan imgade ke folder
                $uploadedImage = $request->images->move(public_path('images'), $imageName);
                    
                $imagePath = 'images/' . $imageName;
                $idnext = $hitung_penyakit + 1;

                //input ke database
                Penyakit::insert([
                    'id_penyakit' => $idnext,
                    'kode_penyakit' => $request->kode_penyakit,
                    'nama_penyakit' => $request->nama_penyakit,
                    'images' => $request->images = $imagePath,
                    'solusi' => $request->solusi,
                ]);

                //menampilkan ke view
                $hitung_penyakit = Penyakit::all()->count();
                $penyakit = Penyakit::orderBy('kode_penyakit', 'asc')->get();
                //menampilkan pesan 
                Session::forget('danger');
                session()->flash('success', 'Data penyakit berhasil disimpan.');
                return view('penyakit', ['penyakit' => $penyakit,'hitung_penyakit' => $hitung_penyakit]);
            }else{

                $idnext = $hitung_penyakit + 1;
                //input ke database
                Penyakit::insert([
                    'id_penyakit' => $idnext,
                    'kode_penyakit' => $request->kode_penyakit,
                    'nama_penyakit' => $request->nama_penyakit,
                    'solusi' => $request->solusi,
                ]);
            
                $hitung_penyakit = Penyakit::all()->count();
                $penyakit = Penyakit::orderBy('kode_penyakit', 'asc')->get();
                //menampilkan pesan 
                Session::forget('danger');
                session()->flash('success', 'Data penyakit berhasil disimpan.');
                return view('penyakit', ['penyakit' => $penyakit,'hitung_penyakit' => $hitung_penyakit]);
            }

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

        
    }
    
    public function update_penyakit(Request $request, $id_penyakit)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'kode_penyakit' => ['required', 'min:1'],
                'nama_penyakit' => ['required', 'max:100'],
                'images' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                'solusi' => ['required', 'min:1'],
            ]);
            
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('penyakit')->withErrors($validator)->withInput();
            }
    
            //cek ada filenya ngga
            if($request->hasFile('images')) { 
            $imageName = time().'.'.$request->images->extension();
            $uploadedImage = $request->images->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
    
            //update 
            $preferences = Penyakit::where('id_penyakit', $id_penyakit)
                ->update([
                    'kode_penyakit' => request()->kode_penyakit,
                    'nama_penyakit' => request()->nama_penyakit,
                    'images' => $request->images = $imagePath,
                    'solusi' => request()->solusi,
    
                ]);
    
            $hitung_penyakit = Penyakit::all()->count();
            //menampilkan da mengurutkan
            $penyakit = Penyakit::orderBy('kode_penyakit', 'asc')->get();
            Session::forget('danger');
            session()->flash('success', 'Data penyakit berhasil diubah.');
            return view('penyakit', ['penyakit' => $penyakit,'hitung_penyakit' => $hitung_penyakit]);
        }else {
            //update data 
            $preferences = Penyakit::where('id_penyakit', $id_penyakit)
                     ->update([
                    'kode_penyakit' => request()->kode_penyakit,
                    'nama_penyakit' => request()->nama_penyakit,
                    'solusi' => request()->solusi,
            
                ]);
            
            $hitung_penyakit = Penyakit::all()->count();
            //menampilkan dan mengurutkan data
            $penyakit = Penyakit::orderBy('kode_penyakit', 'asc')->get();
            Session::forget('danger');
            session()->flash('success', 'Data penyakit berhasil diubah.');
            return view('penyakit', ['penyakit' => $penyakit,'hitung_penyakit' => $hitung_penyakit]);
        }
            
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }


    }


    public function hapus_penyakit($id_penyakit)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){

            session()->start();
            //menghapus data penyakit
            $cari_namapenyakit = Penyakit::where('id_penyakit', $id_penyakit)->pluck('nama_penyakit');
            $hapus_gejala = Gejala::where('jenis', $cari_namapenyakit)->delete();
            $hapus_aturan = Aturan::where('idpenyakit', $id_penyakit)->delete();
            $hapus_penyakit = Penyakit::where('id_penyakit', $id_penyakit)->delete();
            $hitung_penyakit = Penyakit::all()->count();
            //menampilkan
            $penyakit = Penyakit::orderBy('kode_penyakit', 'asc')->get();
            Session::forget('success');
            session()->flash('danger', 'Data penyakit berhasil dihapus.');
            return view('penyakit', ['penyakit' => $penyakit,'hitung_penyakit' => $hitung_penyakit]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
    }
}
