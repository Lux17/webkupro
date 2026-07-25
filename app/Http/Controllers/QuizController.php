<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Kuis;
use App\Models\Soal;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Session;

class QuizController extends Controller
{

    public function index(Request $request, $kode_kuis)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'pengguna'){
            
            session()->start();


            $id_kuis = Kuis::where('kode_kuis', $kode_kuis)->value('id_kuis');
            if (! $id_kuis) {
                abort(404, 'Kuis tidak ditemukan.');
            }

            $kuisRow = Kuis::where('id_kuis', $id_kuis)->first();
            $mapelRow = Mapel::where('id_mapel', $kuisRow->id_mapel)->first();
            if (! $mapelRow || (int) $mapelRow->id_kelas !== (int) auth()->user()->id_kelas) {
                abort(403, 'Kuis tidak tersedia untuk kelas Anda.');
            }
         
            $soal = Soal::where('kode_kuis', $kode_kuis)->get();
            
            $mapel_id = Kuis::where('kode_kuis', $kode_kuis)->value('id_mapel'); 
            $mapel = Mapel::with('kelas')->get();

            $durasi = Kuis::where('kode_kuis', $kode_kuis)->value('durasi');

           
                    // session timer
            $sessionKey = 'quiz_end_'.$id_kuis;


            $cek = Jawaban::where('id_user', auth()->id())
                ->where('id_kuis', $id_kuis)
                ->first();
           
            if($cek){
                    return view('hasil', [
                        'nilai2' => $cek->skor
                    ]);
            }
    

            // jika belum ada timer
            if (!session()->has($sessionKey)) {

               $endTime = Carbon::now()->addMinutes($durasi)->timestamp * 1000;

              session([$sessionKey => $endTime]);
            }
            
            $endTime = session($sessionKey);


         
            return view('pengguna.quiz',['endTime' => $endTime, 'mapel' => $mapel, 'id_kuis' => $id_kuis,'mapel_id' => $mapel_id, 'soal' => $soal, 'kode_kuis' => $kode_kuis]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function hasil(Request $request)
    {
        // Hardened: reuse ResultController and map to hasil view if needed.
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Delegate scoring to hardened ResultController logic path.
        return app(\App\Http\Controllers\ResultController::class)->index($request);
    }

}