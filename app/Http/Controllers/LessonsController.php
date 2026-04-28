<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Session;

class LessonsController extends Controller
{

    public function index(Request $request, $id_materi)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'pengguna'){
            
            session()->start();
            $materi = Materi::where('id_materi', $id_materi)->first();
            $tampil = $materi->content;
            $content = str_replace('src="upload/', 'src="'.asset('upload/').'/', $tampil); 
            $mapel = Mapel::with('kelas')->get();
            return view('pengguna.lessons',['mapel' => $mapel, 'materi' => $materi, 'content' => $content]);
        
        }elseif(auth()->user()->rolename === 'admin'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

 }



}
