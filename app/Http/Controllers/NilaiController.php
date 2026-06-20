<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\Jawaban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Session;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
          $kuis = Kuis::orderBy('id_mapel', 'asc')->get();
          $hitung_jawaban = Jawaban::get()->count();
      
          return view('hasil-kuis',['kuis' => $kuis]);

        }elseif(auth()->user()->rolename === 'guru'){
          $kuis = Kuis::where('id_guru', Auth::id())
            ->orderBy('id_mapel', 'asc')
            ->get();
          $hitung_jawaban = Jawaban::get()->count();
      
            return view('guru.hasil-kuis',['kuis' => $kuis]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }
    

    public function search_nilai(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            $request->validate([
                'keyword' => 'required'
            ]);
            $nama_kuis =  Kuis::where('id_kuis', $request->keyword)->pluck('nama_kuis');
            $kuis = Kuis::orderBy('nama_kuis')->get();

            $hitung_jawaban = Jawaban::count();

            $nilai = Jawaban::with('user')
                ->where('id_kuis', $request->keyword)
                ->orderBy('timestamp', 'desc')
                ->get();

            return view('hasil-kuis', compact(
                'kuis',
                'nilai',
                'nama_kuis',
                'hitung_jawaban'
            ));

        }elseif(auth()->user()->rolename === 'guru'){

                    $request->validate([
                'keyword' => 'required'
            ]);
            $nama_kuis =  Kuis::where('id_kuis', $request->keyword)->pluck('nama_kuis');
            $kuis = Kuis::where('id_guru', Auth::id())
            ->orderBy('id_mapel', 'asc')
            ->get();

            $hitung_jawaban = Jawaban::count();

            $nilai = Jawaban::with('user')
                ->where('id_kuis', $request->keyword)
                ->orderBy('timestamp', 'desc')
                ->get();

            return view('guru.hasil-kuis', compact(
                'kuis',
                'nilai',
                'nama_kuis',
                'hitung_jawaban'
            ));

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }



    }

}

