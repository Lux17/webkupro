<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Session;

class AdminController extends Controller
{
    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            $check = Auth::user();
            //hitung jumlah data admin
            $hitung_admin = User::where('rolename', 'like', 'admin')->get()->count();

            //tampil data admin
            $admin = User::where('rolename', 'like', 'admin')->get();

            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');
            return view('admin', ['admin' => $admin, 'check' => $check,'hitung_admin' => $hitung_admin]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function search_admin(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //ambil data dari input cari
            $keyword = $request->search;
            $check = Auth::user();

            //hittung jumlah data admin
            $hitung_admin = User::where('rolename', 'like', 'admin')->get()->count();
            
            //hapus notif/session
            Session::forget('danger');
            session()->flash('success', 'Data Admin berhasil ditemukan.');
            //cari data admin untuk tampil
            $admin = User::where('rolename', 'admin')->where('name', 'like', "%".$keyword."%")->get();
            return view('admin', ['admin' => $admin,'check' => $check,'hitung_admin' => $hitung_admin]);
            

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
            
            session()->start();

            //validasi input
            $validator = Validator::make($request->all(), [
                'name' => ['required','string', 'min:1'],
                'email' => ['required', 'unique:users'],
                'password' => ['required', 'min:8'],
                'rolename' => ['required', 'max:15'],
                'no_hp' => ['required','string', 'max:20'],
            ]);
            $check = Auth::user();
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('admin')->withErrors($validator)->withInput();
            }
    
            //insert data admin
            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rolename' => $request->rolename,
                'no_hp' => $request->no_hp,
            ]);
    
            //hitung admin
            $hitung_admin = User::where('rolename', 'like', 'admin')->get()->count();
    
            Session::forget('danger');
            //tampil data admin
            $admin = User::where('rolename', 'like', 'admin')->get();
            session()->flash('success', 'Data Admin berhasil disimpan.');
            return view('admin', ['admin' => $admin,'check' => $check,'hitung_admin' => $hitung_admin]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }
    
    public function update_admin(Request $request, $id)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            $check = Auth::user();
            //validasi input
           $validator = Validator::make($request->all(), [
               'name' => ['required','string', 'min:1'],
               'email' => ['required', 'min:1'],
               'password' => ['required', 'min:8'],
               'rolename' => ['required', 'max:15'],
               'no_hp' => ['required','string', 'max:20'],
           ]);
           
           //menampilkan pesan eror validasi
           if ($validator->fails()) {
               session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
               return redirect('admin')->withErrors($validator)->withInput();
           }
   
           //update data admin
           $preferences = User::where('id', $id)
               ->update([
                   'name' => $request->name,
                   'email' => $request->email,
                   'password' => Hash::make($request->password),
                   'rolename' => $request->rolename,
                   'no_hp' => $request->no_hp,
   
               ]);
   
           //hitung data admin
           $hitung_admin = User::where('rolename', 'like', 'admin')->get()->count();
              
           //cari data admin untuk tampil
           $admin = User::where('rolename', 'like', 'admin')->get();
           Session::forget('danger');
           session()->flash('success', 'Data Admin berhasil diubah.');
           return view('admin', ['admin' => $admin,'check' => $check,'hitung_admin' => $hitung_admin]);


        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }


    public function hapus_admin($id)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            $check = Auth::user();
            //hapus data admin
            $cari_email = Hasil::where('idpengguna', $id)->pluck('email');
            $hapus_token  = DB::table('password_reset_tokens')->where('email', $cari_email)->delete();
            $hapus_sesi = DB::table('sessions')->where('user_id', $id)->delete();
            $admin = User::where('id', $id)->delete();
    
            //hitung jumlah data admin
            $hitung_admin = User::where('rolename', 'like', 'admin')->get()->count();
    
            //cari data admin untuk tampil
            $admin = User::where('rolename', 'like', 'admin')->get();
            Session::forget('success');
            session()->flash('danger', 'Data Admin berhasil dihapus.');
            return view('admin', ['admin' => $admin,'check' => $check,'hitung_admin' => $hitung_admin]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }


    }
}
