<?php

namespace App\Http\Controllers;

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
            return view('pengguna.quiz',['mapel' => $mapel, 'id_kuis' => $id_kuis,'mapel_id' => $mapel_id, 'soal' => $soal, 'kode_kuis' => $kode_kuis]);
        
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

        DB::table('jawaban_kuis')->insert([
            'id_user' => auth()->id(),
            'id_kuis' => $request->id_kuis,
            'id_mapel' => $request->id_mapel,
            'skor' => $nilai,
        ]);
   
        $nilai2 = Jawaban::where('id_user', $iduser)->value('skor');
      
        return view('hasil',['nilai2' => $nilai2]);
    }

}
