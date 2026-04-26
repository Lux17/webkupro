<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){

            //memanggil fungsi auth user
            $user = Auth::user();
            //hitung
            $hitung_kuis = Kuis::count();
            $hitung_kelas = Kelas::count();
            $hitung_users =  User::where('rolename', 'like', 'pengguna')->get()->count();
            $hitung_guru =  User::where('rolename', 'like', 'guru')->get()->count();


            return view('dashboard', ['user' => $user,'hitung_kuis' => $hitung_kuis,'hitung_kelas' => $hitung_kelas,'hitung_guru' => $hitung_guru, 'hitung_users' => $hitung_users]);
            
            
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }


    }

}
