<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Kuis;
use App\Models\Materi;
use App\Models\User;
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
            $id_kelas = auth()->user()->id_kelas;

            $mapel = Mapel::with(['kelas', 'guru', 'kuis'])->where('id_kelas', $id_kelas)->get();
          
            return view('pengguna.info', compact('mapel'));

            
        }else{
            return redirect('/');
        }

    }

}
