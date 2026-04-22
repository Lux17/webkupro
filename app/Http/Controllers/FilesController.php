<?php

namespace App\Http\Controllers;

use App\Models\Files;
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

class FilesController extends Controller
{
    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            

            //hitung jumlah files
            $hitung_files = Files::all()->count();

            //tampil dan urutkan
            $files = Files::orderBy('nama_files', 'asc')->get();
            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('files', ['files' => $files,'hitung_files' => $hitung_files]);
    

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function search_files(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //ambil data dari input
            $keyword = $request->search;

            //hitung jumlah files
            $hitung_files = Files::all()->count();

            //cari data dari database
            $files = Files::where('nama_files', 'like', "%".$keyword."%")->paginate();
            Session::forget('danger');
            session()->flash('success', 'Data files berhasil ditemukan.');
            return view('files', ['files' => $files,'hitung_files' => $hitung_files]);
        
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
                'nama_files' => ['required', 'unique:files'],
                'file' => ['required', 'file', 'max:10240'],
                'tgl' => ['required', 'min:1'],
            ]);

            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('files')->withErrors($validator)->withInput();
            }

            $hitung_files = Files::all()->count();

                $file = $request->file('file');

                $fileName = time().'_'.$file->getClientOriginalName();

                $file->move(public_path('upload'), $fileName);

                $filePath = 'upload/'.$fileName;
                $idnext = $hitung_files + 1;

                //input ke database
                files::insert([
                    'nama_files' => $request->nama_files,
                    'id_user' => auth()->id(),
                    'file' => $filePath,
                    'tgl' => $request->tgl,
                ]);

                //menampilkan ke view
                $hitung_files = Files::all()->count();
                $files = Files::orderBy('id_files', 'asc')->get();
                //menampilkan pesan 
                Session::forget('danger');
                session()->flash('success', 'Data files berhasil disimpan.');
                return view('files', ['files' => $files,'hitung_files' => $hitung_files]);


        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

        
    }
    
    public function update_files(Request $request, $id_files)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'nama_files' => ['required', 'unique:files'],
                'file' => ['required', 'file', 'max:10240'],
                'tgl' => ['required', 'min:1'],
            ]);
            
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('files')->withErrors($validator)->withInput();
            }
    

            $file = $request->file('file');

            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('upload'), $fileName);

            $filePath = 'upload/'.$fileName;

            //update 
            $preferences = Files::where('id_files', $id_files)
                ->update([
                    'nama_files' => $request->nama_files,
                    'id_user' => auth()->id(),
                    'file' => $filePath,
                    'tgl' => $request->tgl,
    
                ]);
    
            $hitung_files = Files::all()->count();
            //menampilkan da mengurutkan
            $files = Files::orderBy('id_files', 'asc')->get();
            Session::forget('danger');
            session()->flash('success', 'Data files berhasil diubah.');
            return view('files', ['files' => $files,'hitung_files' => $hitung_files]);
 

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }


    }


    public function hapus_files($id_files)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){

            session()->start();

            // cari data file
            $file = Files::where('id_files', $id_files)->first();

            if($file){
                $path = public_path($file->nama_files);

                // cek jika file ada lalu hapus
                if(file_exists($path)){
                    unlink($path);
                }

                // hapus dari database
                $file->delete();
            }

            $hitung_files = Files::count();
            $files = Files::orderBy('id_files', 'asc')->get();

            Session::forget('success');
            session()->flash('danger', 'Data files berhasil dihapus.');

            return view('files', [
                'files' => $files,
                'hitung_files' => $hitung_files
            ]);
        
            }elseif(auth()->user()->rolename === 'pengguna'){
                return redirect('/info');
            }else{
                return redirect('/');
            }
        }
}
