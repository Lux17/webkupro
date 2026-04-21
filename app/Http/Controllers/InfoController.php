<?php

namespace App\Http\Controllers;

// use App\Models\Produk;
// use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    
    public function index()
    {
        
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            return redirect('/dashboard');
        }elseif(auth()->user()->rolename === 'pengguna'){

            return view('pengguna.info');

            
        }else{
            return redirect('/');
        }

    }

}
