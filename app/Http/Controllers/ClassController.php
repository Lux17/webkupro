<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;
use File;
use Session;

class ClassController extends Controller
{
    public function index(Request $request, $id_mapel)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'pengguna'){

            //tampil dan urutkan

            $materi = Materi::where('id_mapel', $id_mapel)->get();
            
            Session::forget('danger');
            Session::forget('success');

            return view('pengguna.class', ['materi' => $materi]);
    

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
    }




}
