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

        $iduser = auth()->id();

        
        $jawabanUser = $request->jawaban;
        $skor = 0;
        
        $soalDB = Soal::whereIn('id_soal', collect($jawabanUser)->pluck('id_soal'))
                    ->get()
                    ->keyBy('id_soal');

      

        foreach ($jawabanUser as $j) {

            if (!isset($j['pilihan'])) continue;

            if ($soalDB[$j['id_soal']]->jawaban == $j['pilihan']) {
                $skor++;
            }
        }

        $total = count($jawabanUser);
        $nilai = ($total > 0) ? ($skor / $total) * 100 : 0;

        $cekJawaban = Jawaban::where('id_user', auth()->id())
            ->where('id_kuis', $request->id_kuis)
            ->exists();

        if(!$cekJawaban){

            DB::table('jawaban_kuis')->insert([
                'id_user' => auth()->id(),
                'id_kuis' => $request->id_kuis,
                'id_mapel' => $request->id_mapel,
                'skor' => $nilai,
            ]);
        }
   
        $nilai2 = Jawaban::where('id_user', $iduser)->value('skor');

        session()->forget('quiz_end_'.$request->id_kuis);
      
        return view('hasil',['nilai2' => $nilai2]);
    }

}
