<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Hasil;
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
            $hitung_gejala = Gejala::count();
            $hitung_penyakit = Penyakit::count();
            $hitung_diagnosis = Hasil::count();
            $hitung_users =  User::where('rolename', 'like', 'pengguna')->get()->count();

            //tampil data
            $penyakit = Penyakit::all();
            $gejala = Gejala::all();
            return view('dashboard', ['penyakit' => $penyakit,'user' => $user,'hitung_penyakit' => $hitung_penyakit,'gejala' => $gejala,'hitung_gejala' => $hitung_gejala,'hitung_diagnosis' => $hitung_diagnosis, 'hitung_users' => $hitung_users]);
            
            
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }


    }

}
