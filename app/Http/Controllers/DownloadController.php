<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;
use PDF;

class DownloadController extends Controller
{
    public function unduh(Request $request, $id)
    {
        $kode = $request->id ;
        $keyword = $request->id ;
        $hasildiagnosis = DB::table('hasil_diagnosis')->where('id_hasil', 'like', "%".$keyword."%")->paginate();
        foreach($hasildiagnosis as $hasil){
            $id_p = $hasil->penyakit;
        };
        $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', $id_p)->pluck('id_penyakit')->first();
        $analisa =  DB::table('analisa')->where('idpenyakit', $cari_penyakit)->pluck('nilai_prioritas');
        $penyakit = DB::table('penyakit')->where('nama_penyakit', $id_p)->get();
        $gejala = DB::table('gejala')->where('jenis', $id_p)->pluck('kode_gejala');
        $cari_gejala = DB::table('gejala')->where('jenis', $id_p)->pluck('id_gejala');
        $cari_gejala1 = DB::table('gejala')->where('jenis', $id_p)->pluck('id_gejala')->first();
        $cari_gejala2 = DB::table('gejala')->where('jenis', $id_p)->orderby('id_gejala', 'desc')->pluck('id_gejala')->first();
        $input_user = DB::table('hasil_diagnosis')->where('id_hasil', $kode)->get('kondisi');
        
        $kondisiArray = json_encode($input_user, true);
        $arrayData = json_decode($kondisiArray, true);
        $kondisiArray2 = json_decode($arrayData[0]['kondisi'], true);
 

        $gejala2 = DB::table('gejala')->where('jenis', $id_p)->get();
        // dd($cari_gejala);
        
        $kondisiUser= [];
        // $hitung = min(count($gejala), count($cari_gejala));

        for ($i = $cari_gejala1-1 ; $i < $cari_gejala2; $i++) {
            $kondisiUser[] = [
                'kondisi' => $kondisiArray2[$i],
            ];
        }

        $transform = array_map(function ($item) {
            return $item['kondisi'];
        }, $kondisiUser);


        $values = [];
        foreach ($transform as $subarray) {
            if (isset($subarray[1])) {
                $values[] = $subarray[1];
            }
        }
        // dd($values);

        $lihat_user = [];
        $hitung = min(count($kondisiUser), count($gejala));
        for ($i = 0; $i < $hitung; $i++) {
            $lihat_user[] = [
                'kondisi' => $values[$i],
                'gejala' => $gejala[$i]
            ];
        }

        // dd($lihat_user);

        $combined = [];
        $count = min(count($analisa), count($gejala2));
        for ($i = 0; $i < $count; $i++) {
            $combined[] = [
                'analis' => $analisa[$i],
                'gejala' => $gejala[$i]
            ];
        }

   


        $pdf = PDF::loadView('pengguna.download',['hasildiagnosis' => $hasildiagnosis, 'penyakit' => $penyakit ,'gejala' => $gejala,'gejala2' => $gejala2,'analisa' => $analisa,'combined' => $combined,'cari_gejala' => $cari_gejala,'kondisiArray2' => $kondisiArray2, 'kondisiUser' => $kondisiUser, 'lihat_user' => $lihat_user]);

        return $pdf->download('hasildiagnosis.pdf');

    }
}