<?php

namespace App\Http\Controllers;

use App\Models\Aturan;
use App\Models\Analisa;
use App\Models\Gejala;
use App\Models\Penyakit;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Response;


class AturanController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
        //ambil data nama penyakit
        $keyword = $request->nama_penyakit;
        //ambil data id penyakit
        $keyword2 = $request->idpenyakit;

        //nilai 0 ketika belum pilih penyakit 1 untuk sudah pilih penyakit 
        $pilih = 0;

        //ambil data gejala dan penyakit untuk tampil
        $gejala =  Gejala::all();
        $penyakit = Penyakit::all();

        //hitung data gejala
        $hitung_gejala =   Gejala::where('jenis', $keyword)->count();
        //cari data aturan yg penyakitnya sama untuk tampil
        $aturan = Aturan::where('idpenyakit', $keyword)->get();
        //cari nama penyakit 
        $cari_penyakit = Penyakit::where('nama_penyakit', 'like', "%".$keyword."%")->get();
        return view('aturan', ['gejala' => $gejala,'pilih' => $pilih,'aturan' => $aturan,'penyakit' => $penyakit,'cari_penyakit' => $cari_penyakit, 'hitung_gejala'=> $hitung_gejala]);


        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

 }

    public function search_aturan(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            $keyword = $request->nama_penyakit;
            $hitung_gejala2 = 0;
            $penyakit = DB::table('penyakit')->get();
            $id =  1;
            $pilih = 1;
    
            $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', $keyword)->get();
            foreach ($cari_penyakit as $cari) {
                $idp= $cari->id_penyakit;
                $tampil_aturan = DB::table('aturan')->where('idpenyakit', $idp)->orderby('gejala_y', 'asc')->get();
            }
      
            if($tampil_aturan == null)
            {
                $status = 1;
                foreach ($cari_penyakit as $cari) {
                    $idp= $cari->id_penyakit;
                    $tampil_aturan = DB::table('aturan')->where('idpenyakit', $idp)->pluck('nilai_pakar');
                }
                $hitung_gejala =  DB::table('gejala')->where('jenis', $keyword)->count();
                // dd($hitung_gejala);
                $aturan = DB::table('aturan')->get();
                $gejala2 = DB::table('gejala')->where('jenis', $keyword)->pluck('kode_gejala')->toArray();
                $gejala = DB::table('gejala')->where('jenis', $keyword)->paginate();
                $data = $tampil_aturan;
                $tampil = [];
                foreach ($data as $comparison) {
                    $comparisons[$comparison->gejala_x][$comparison->gejala_y] = $comparison->nilai_pakar;
                    $tampil = $comparisons;
                }
                
            }else{
            $status = 2;
            $tampil= 0;
            $hitung_gejala =  DB::table('gejala')->where('jenis', $keyword)->count();
            foreach ($cari_penyakit as $cari) {
                $idp= $cari->id_penyakit;
            }
            $hitung_p = DB::table('penyakit')->where('id_penyakit', $idp)->count();
            
            $tampil_aturan = DB::table('aturan')
                ->where('idpenyakit', $idp)
                ->get()
                ->groupBy('gejala_x')
                ->take(7)
                ->map(function ($group) {
                    return $group->pluck('nilai_pakar');
                });
    
            $group = $tampil_aturan->toArray();
    
            $hitung_gejala =  DB::table('gejala')->where('jenis', $keyword)->count();
            $gejala = DB::table('gejala')->where('jenis', $keyword)->paginate();
            // dd($gejala);
            $aturan = DB::table('aturan')->get();
            $gejala2 = DB::table('gejala')->where('jenis', $keyword)->pluck('kode_gejala')->toArray();
    
            // dd($cari_penyakit);
            foreach ($cari_penyakit as $cari) {
                $idp= $cari->id_penyakit;
                $tampil_aturan = DB::table('aturan')->where('idpenyakit', $idp)->pluck('nilai_pakar');
            }
            // dd($tampil_aturan);
            }
    
            return view('aturan', ['gejala' => $gejala,'pilih' => $pilih,'group' => $group,'status' => $status,'tampil' => $tampil,'gejala2' => $gejala2,'penyakit' => $penyakit,'aturan' => $aturan,'cari_penyakit' => $cari_penyakit, 'hitung_gejala'=> $hitung_gejala, 'hitung_gejala2'=> $hitung_gejala2, 'tampil_aturan'=> $tampil_aturan]);
        

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

}

    public function simpan(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            $comparisons = $request->input('comparison');
            $pilih = 1;
            $keyword = $request->nama_penyakit;
            $keyword2 = $request->idpenyakit;
    
            $cari_penyakit = DB::table('penyakit')->where('id_penyakit', $keyword2)->get();
            foreach ($cari_penyakit as $cari) {
                $idp= $cari->id_penyakit;
                $name_p = $cari->nama_penyakit;
                $tampil_aturan = DB::table('aturan')->where('idpenyakit', $idp)->pluck('nilai_pakar');
            }
            
            $gejala2 = DB::table('gejala')->where('jenis', $name_p)->pluck('kode_gejala')->toArray();
            session()->flash('success', 'Data berhasil disimpan.');
            $penyakit = DB::table('penyakit')->get();
            $aturan = DB::table('aturan')->get();
            $hitung_gejala =  DB::table('gejala')->where('jenis', $keyword)->count();
            $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', 'like', "%".$keyword."%")->get();
            $gejala = DB::table('gejala')->where('jenis',  $keyword)->paginate();
            
            $n =  count($comparisons);
                
            $urut = 0;
    
            // diagonal --> bernilai 1
            for ($i = 0; $i <= ($n - 1); $i++) {
                $comparisons[$i][$i] = 1;
            }
        
            // inisialisasi jumlah tiap kolom dan baris penyakit
            $jmlmpb = array_fill(0, $n, 0);
            $jmlmnk = array_fill(0, $n, 0);
                
            // menghitung jumlah pada kolom penyakit tabel perbandingan berpasangan
            for ($x = 0; $x <= ($n - 1); $x++) {
                for ($y = 0; $y <= ($n - 1); $y++) {
                    $value =  number_format($comparisons[$x][$y],15);
                    $jmlmpb[$y] += $value;
                }
            }
          
            // menghitung jumlah pada baris penyakit tabel nilai penyakit
            // matrikb merupakan matrik yang telah dinormalisasi
            for ($x = 0; $x <= ($n - 1); $x++) {
                for ($y = 0; $y <= ($n - 1); $y++) {
                    $matrikb[$x][$y] = $comparisons[$x][$y] / $jmlmpb[$y];
                    $value = round($matrikb[$x][$y],10);
                    $jmlmnk[$x] += $value;
                }
                    
                // nilai priority vektor
                $pv[$x] = round($jmlmnk[$x] / $n,10);
                    
            }
            // dd($pv);
            //Cek Konsistensi
            $arr_eigen  = array_map(function ($a, $b) {
                return $a * $b;
            }, $pv, $jmlmpb);
                
                
            $jmlh_eigen = array_sum($arr_eigen);
                
         
    
            //udah bener
            session()->start();
            
            $CI = ($jmlh_eigen - $n)/($n - 1);
            
            $RI = DB::table('random_index')->where('matrix',  $n)->get('nilai');
      
    
            foreach($RI as $ri){
                $n = $ri -> nilai;
                if ($n == 0 ){
                    $CR = 0;
                }else{
                    $CR = $CI / $n;
                };
            };
             
    
            if($CR <= 0.1 && $CR >= 0){
                $keyword = $request->nama_penyakit;
                $keyword2 = $request->idpenyakit;
                    
                $penyakit = DB::table('penyakit')->get();
    
                $aturan = DB::table('aturan')->get();
                $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', 'like', "%".$keyword."%")->get();
                $gejala = DB::table('gejala')->where('jenis', $keyword)->paginate();
                
                // dd($gejala2);
    
                for($l=0; $l < count($arr_eigen); $l++){
                    Analisa::updateOrCreate([
                                'idpenyakit' => $idp,
                                'gejala' => $gejala2[$l],
                        ],[
                            'jumlah_nilai' => $jmlmnk[$l],
                            'nilai_prioritas' => number_format($pv[$l],10),
                            'nilai_eigen' => $arr_eigen[$l]
                    ]);
       
                };
    
                
                foreach ($comparisons as $i => $rows) {
                    foreach ($rows as $j => $value) {
                        $keyword2 = $request->idpenyakit;
    
                        Aturan::updateOrCreate([
                            'idpenyakit' => $keyword2,
                            'gejala_x' => $i,
                            'gejala_y' => $j
                        ],[
                            'nilai_pakar' => $value
                        ]);
                    
                    }
                }
                   
                session()->forget('danger');
                session()->flash('success', 'Data Sudah Konsisten.');
                return view('hasil_aturan', ['gejala' => $gejala,'gejala2' => $gejala2,'matrikb' => $matrikb,'comparisons' => $comparisons,'pv' => $pv,'arr_eigen' =>  $arr_eigen,'pilih' => $pilih,'jmlmnk' => $jmlmnk,'jmlh_eigen'=> $jmlh_eigen,'CR' => $CR,'CI' => $CI,'RI' => $RI,'penyakit' => $penyakit,'aturan' => $aturan,'tampil_aturan' => $tampil_aturan,'cari_penyakit' => $cari_penyakit, 'hitung_gejala'=> $hitung_gejala]);
            }else{
        
                $keyword = $request->nama_penyakit;
                $keyword2 = $request->idpenyakit;
                session()->forget('success');
                session()->flash('danger', 'Nilai Masih Tidak Konsisten.');
                // dd($keyword2);
                $penyakit = DB::table('penyakit')->get();
                $aturan = DB::table('aturan')->get();
                $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', 'like', "%".$keyword."%")->get();
                $gejala = DB::table('gejala')->where('jenis', $keyword)->paginate();
                return view('hasil_aturan', ['gejala' => $gejala,'gejala2' => $gejala2,'pilih' => $pilih,'matrikb' => $matrikb,'pv' => $pv,'jmlmnk' => $jmlmnk,'CR' => $CR,'arr_eigen' =>  $arr_eigen,'comparisons' => $comparisons,'jmlh_eigen'=> $jmlh_eigen,'CI' => $CI,'RI' => $RI,'penyakit' => $penyakit,'aturan' => $aturan,'tampil_aturan' => $tampil_aturan,'cari_penyakit' => $cari_penyakit, 'hitung_gejala'=> $hitung_gejala]);
        
            };
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
        
    }



    public function hasil(Request $request)
    {
        $comparisons = $request->input('comparison');
        $pilih = 1;
        $keyword = $request->nama_penyakit;
        $keyword2 = $request->idpenyakit;
        $cari_penyakit = DB::table('penyakit')->where('id_penyakit', $keyword2)->get();
        foreach ($cari_penyakit as $cari) {
            $idp= $cari->id_penyakit;
            $tampil_aturan = DB::table('aturan')->where('idpenyakit', $idp)->pluck('nilai_pakar');
        }
        
        session()->flash('success', 'Data berhasil disimpan.');
        $penyakit = DB::table('penyakit')->get();
        $aturan = DB::table('aturan')->get();
        $hitung_gejala =  DB::table('gejala')->where('jenis', $keyword)->count();
        $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', 'like', "%".$keyword."%")->get();
        $gejala = DB::table('gejala')->where('jenis', $keyword)->paginate();

        //Matrix Normalisasi
        $n =  count($comparisons);
            
        $urut = 0;

        // diagonal --> bernilai 1
        for ($i = 0; $i <= ($n - 1); $i++) {
        $comparisons[$i][$i] = 1;
        }
    
        // inisialisasi jumlah tiap kolom dan baris penyakit
        $jmlmpb = array_fill(0, $n, 0);
        $jmlmnk = array_fill(0, $n, 0);
        // dd($n);
        // menghitung jumlah pada kolom penyakit tabel perbandingan berpasangan
        for ($x = 0; $x <= ($n - 1); $x++) {
            for ($y = 0; $y <= ($n - 1); $y++) {
                $value = $comparisons[$x][$y];
                $jmlmpb[$y] += $value;
            }
        }
            
        // menghitung jumlah pada baris penyakit tabel nilai penyakit
        // matrikb merupakan matrik yang telah dinormalisasi
        for ($x = 0; $x <= ($n - 1); $x++) {
            for ($y = 0; $y <= ($n - 1); $y++) {
                $matrikb[$x][$y] = $comparisons[$x][$y] / $jmlmpb[$y];
                $value = $matrikb[$x][$y];
                $jmlmnk[$x] += $value;
            }
                
            // nilai priority vektor
            $pv[$x] = $jmlmnk[$x] / $n;
                
        }

            //Cek Konsistensi
          
        $arr_eigen  = array_map(function ($a, $b) {
            return $a * $b;
        }, $pv, $jmlmpb);
            
            
        $jmlh_eigen = array_sum($arr_eigen);
            
    
        //udah bener
        session()->start();
    
        $CI = ($jmlh_eigen - $n)/($n-1);
        $RI = DB::table('random_index')->where('matrix', $n)->get('nilai');

        foreach($RI as $ri){
            $n = $ri -> nilai;
            if ($n == 0){
                $CR = 0;
            }else{
                $CR = $CI / $n;
            };
        };


        if($CR <= 0.1 && $CR >= 0){
            $keyword = $request->nama_penyakit;
            $keyword2 = $request->idpenyakit;
    
            $penyakit = DB::table('penyakit')->get();
            $aturan = DB::table('aturan')->get();
            $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', 'like', "%".$keyword."%")->get();
            $gejala = DB::table('gejala')->where('jenis', $keyword)->paginate();
                        
            foreach ($comparisons as $i => $rows) {
                foreach ($rows as $j => $value) {
                    if ($i != $j) {
                        $keyword2 = $request->idpenyakit;
                        // dd($keyword2);
                        Aturan::updateOrCreate([
                            'idpenyakit' => $keyword2,
                            'gejala_x' => $i,
                            'gejala_y' => $j
                        ],[
                                'nilai_pakar' => $value
                        ]);
                    }
                }
            }
               
            session()->forget('danger');
            session()->flash('success', 'Data Sudah Konsisten.');
            return view('hasil_aturan', ['gejala' => $gejala,'gejala2' => $gejala2,'matrikb' => $matrikb,'comparisons' => $comparisons,'pv' => $pv,'arr_eigen' =>  $arr_eigen,'pilih' => $pilih,'jmlmnk' => $jmlmnk,'jmlh_eigen'=> $jmlh_eigen,'CR' => $CR,'CI' => $CI,'RI' => $RI,'penyakit' => $penyakit,'aturan' => $aturan,'tampil_aturan' => $tampil_aturan,'cari_penyakit' => $cari_penyakit, 'hitung_gejala'=> $hitung_gejala]);
        }else{
    
            $keyword = $request->nama_penyakit;
            $keyword2 = $request->idpenyakit;
            session()->forget('success');
            session()->flash('danger', 'Nilai Masih Tidak Konsisten.');
            $penyakit = DB::table('penyakit')->get();
            $aturan = DB::table('aturan')->get();
            $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', 'like', "%".$keyword."%")->get();
            $gejala = DB::table('gejala')->where('jenis', $keyword)->paginate();
            return view('hasil_aturan', ['gejala' => $gejala,'gejala2' => $gejala2,'pilih' => $pilih,'matrikb' => $matrikb,'pv' => $pv,'jmlmnk' => $jmlmnk,'CR' => $CR,'arr_eigen' =>  $arr_eigen,'comparisons' => $comparisons,'jmlh_eigen'=> $jmlh_eigen,'CI' => $CI,'RI' => $RI,'penyakit' => $penyakit,'aturan' => $aturan,'tampil_aturan' => $tampil_aturan,'cari_penyakit' => $cari_penyakit, 'hitung_gejala'=> $hitung_gejala]);
        };
       
    }

}
