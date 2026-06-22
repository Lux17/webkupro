<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Soal;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Session;

class ResultController extends Controller
{
    public function index(Request $request)
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
        
        $nilai_total = round($nilai);

        $cekJawaban = Jawaban::where('id_user', auth()->id())
            ->where('id_kuis', $request->id_kuis)
            ->exists();

            if(!$cekJawaban){

            DB::table('jawaban_kuis')->insert([
                'id_user' => auth()->id(),
                'id_kuis' => $request->id_kuis,
                'id_mapel' => $request->id_mapel,
                'skor' => $nilai_total,
                'timestamp' => $request->timestamp
            ]);
            
            $nilai2 = $nilai_total;
            session()->forget('quiz_end_'.$request->id_kuis);
            return view('pengguna.result',['nilai2' => $nilai2]);
        }
   
        $nilai2 = Jawaban::where('id_user', $iduser)->value('skor');

        

        session()->forget('quiz_end_'.$request->id_kuis);
      
        return view('pengguna.result',['nilai2' => $nilai2,'nilai' => $nilai]);

    }



}


