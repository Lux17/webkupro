<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Hasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Session;

class GuruController extends Controller
{
    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            $check = Auth::user();
            //hitung jumlah pengguna
            $hitung_users = User::where('rolename', 'like', 'guru')->get()->count();
            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            //tampil data pengguna
        
            $users = User::with('kelas')->where('rolename', 'like', 'guru')->get();
            $kelas = Kelas::all();
            return view('guru', ['users' => $users,'kelas' => $kelas,'check' => $check,'hitung_users' => $hitung_users]);
            


        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function search_guru(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //ambil data dari input cari
            $keyword = $request->search;
            $check = Auth::user();
            //hitung data pengguna
            $hitung_users = User::where('rolename', 'like', 'guru')->get()->count();
            
            //cari data pengguna
            Session::forget('danger');
            session()->flash('success', 'Data Guru berhasil ditemukan.');
            $kelas = Kelas::all();
            $users =  User::with('kelas')->where('rolename', 'guru')->where('name', 'like', "%".$keyword."%")->get();
            return view('guru', ['users' => $users,'check' => $check,'kelas' => $kelas,'hitung_users' => $hitung_users]);
            
            
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
            $check = Auth::user();
            $validator = Validator::make($request->all(), [
                'name' => ['required','string', 'min:1'],
                'email' => ['required', 'unique:users'],
                'password' => ['required', 'min:8'],
                'rolename' => ['required', 'max:15'],
                'alamat' => ['required', 'min:1'],
                'jenis_kelamin' => ['required', 'max:20'],
                'tgl_lahir' => ['required', 'date'],
                'no_hp' => ['required', 'min:8'],
                'nip' => ['required', 'min:1'],
            ]);
            
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('guru')->withErrors($validator)->withInput();
            }
    
            //insert data penyakit
            User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rolename' => $request->rolename,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tgl_lahir' => $request->tgl_lahir,
                'no_hp' => $request->no_hp,
                'nip' => $request->nip,

            ]);
            //hitung data pengguna
            $hitung_users = User::where('rolename', 'like', 'guru')->get()->count();
            //tampil data
            $users =  User::with('kelas')->where('rolename', 'like', 'guru')->get();
            $kelas = Kelas::all();
            Session::forget('danger');
            session()->flash('success', 'Data Guru berhasil disimpan.');
            return view('guru', ['users' => $users,'kelas' => $kelas,'check' => $check,'hitung_users' => $hitung_users]);

            
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

 
    }
    
    public function update_guru(Request $request, $id)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            $check = Auth::user();
            $validator = Validator::make($request->all(), [
                'name' => ['required','string', 'min:1'],
                'email' => 'required|unique:users,email,' . $id,
                'password' => ['required', 'min:8'],
                'rolename' => ['required', 'max:15'],
                'alamat' => ['required', 'min:1'],
                'no_hp' => ['required', 'min:8'],
                'jenis_kelamin' => ['required', 'max:20'],
                'tgl_lahir' => ['required', 'date'],
                'nip' => ['required', 'min:1'],
            ]);
            
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('guru')->withErrors($validator)->withInput();
            }
    
            //update data pengguna
            $preferences = User::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'rolename' => $request->rolename,
                    'alamat' => $request->alamat,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tgl_lahir' => $request->tgl_lahir,
                    'no_hp' => $request->no_hp,
                    'nip' => $request->nip,
    
                ]);
    
                //hitung pengguna
                $hitung_users = User::where('rolename', 'like', 'guru')->get()->count();
                //tampil data pengguna
                $users =  User::with('kelas')->where('rolename', 'like', 'guru')->get();
                $kelas = Kelas::all();
                Session::forget('danger');
                session()->flash('success', 'Data Guru berhasil diubah.');
                return view('guru', ['users' => $users,'kelas' => $kelas,'check' => $check,'hitung_users' => $hitung_users]);
            
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }


    }


    public function hapus_guru($id)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            $check = Auth::user();

            $hapus_users = User::where('id', $id)->delete();
            //hitung fdata pengguna
            $hitung_users = User::where('rolename', 'like', 'guru')->get()->count();
            //menampilkan data
            $users =  User::with('kelas')->where('rolename', 'like', 'guru')->get();
            $kelas = Kelas::all();
            Session::forget('success');
            session()->flash('danger', 'Data Guru berhasil dihapus.');
            return view('guru', ['users' => $users,'kelas' => $kelas,'check' => $check,'hitung_users' => $hitung_users]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }
}
