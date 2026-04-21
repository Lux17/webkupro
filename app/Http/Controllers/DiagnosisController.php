<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Session;

use function PHPSTORM_META\map;
use function PHPSTORM_META\type;

class DiagnosisController extends Controller
{
    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');

        }elseif(auth()->user()->rolename === 'admin'){
            return redirect('/dashboard');

        }elseif(auth()->user()->rolename === 'pengguna'){
            
        //Data Gejala, Tampil untuk pertanyaan
        
        $gejala = Gejala::select('nama_gejala', 'kode_gejala')->distinct()->get();
        

        $gejala = Gejala::select('nama_gejala', 'kode_gejala', 'type')
        ->orderBy('type', 'asc')
        ->get()
        ->unique(function($item) {
            return $item['kode_gejala'];
        });
      
        $list = $gejala->values()->toArray();
        // dd($list);
        //Data Kondisi pengguna
        $kondisi = DB::table('kondisi_pengguna')->get();
        return view('pengguna.diagnosis', ['gejala' => $gejala,'kondisi' => $kondisi, 'list' => $list]);
        
        }else{
            return redirect('login');
        }

    }

    public function simpandiagnosis(Request $request)
    {
        //Ambil kode diagnosis dari request input
        $kode1 = $request->kode_diagnosa;

        //ambil data gejala ->kode_gejala
        $ids = DB::table('gejala')->pluck('kode_gejala');
        $gejala = DB::table('gejala')->get();

        $kode = DB::table('gejala')
            ->whereIn('id_gejala', $ids)
            ->pluck('kode_gejala')
            ->all();

        //ubah format "kondisi" 
        $kondisi = [];
        foreach ($ids as $kd) {
            $key = 'kondisi_' . $kd;
            
            if ($request->has($key)) {
                $kondisi[$kd] = $request->input($key);
            }
        }
       

        //Urutkan kondisi sesuai gejala 
        $sorted = [];

        foreach ($ids as $item) {
            if (isset($kondisi[$item])) {
                $sorted[] = $kondisi[$item];
            }
        }
     
       //ubah format array untuk disimkan dikolom kondisi
        $kodeGejala = [];
        $bobotPilihan = [];
        foreach ($sorted as $key => $val) {

                array_push($kodeGejala, $key);
                array_push($bobotPilihan, array(str($key), $val));
        
        }

        
        //ubah datanya jadi JSON
        $jsonData = json_encode($bobotPilihan);

       
        //Data Pakar/Nilai Bobot Pakar
        $cf_pakar =  DB::table('analisa')->orderBy('idpenyakit','asc')->pluck('nilai_prioritas')->toArray();

        //Pilihan/Jawaban User Saat Diagnosis
        $cf_user = [];
        foreach ($bobotPilihan as $item) {
            $cf_user[] = $item[1]; // Mengambil nilai dari elemen kedua ($item[1])
        }

        
        //looping dengan hitung jumlah penyakitnya
        $kode_penyakit = DB::table('penyakit')->get();
        for ($n=0; $n < count($kode_penyakit); $n++) { 
            for ($i=1; $i < count($kode_penyakit)+1; $i++) { 

                $kombin= [];
            
                //Hitung CF HE
                $cf_he  = array_map(function ($a, $b) {
                    return $a * $b;
                }, $cf_pakar, $cf_user);
                array_push($kombin, $cf_he);
        
            
                $penyakit = DB::table('penyakit')->pluck('nama_penyakit');
                //cari nama penyakit
                $pnykt = DB::table('penyakit')->where('id_penyakit', $i)->pluck('nama_penyakit');

                //cari nilai awal dan akhir gejala
                $awal = DB::table('gejala')->where('jenis', $pnykt)->pluck('id_gejala')->first();
                $last = DB::table('gejala')->where('jenis', $pnykt)->orderby('id_gejala', 'desc')->first()->id_gejala;
             
   
                
                //Hitung CF Combine
                foreach($kode_penyakit as $kd){
                    ${'hasilcombin'.$i} = 0;
                    for ($z= ($awal-1); $z < ($last-1) ; $z++) { 
                        if ($z == $awal-1) {
                            if (count($kombin)-1 == 1 ) {
                                $hasil_combine[$i]["hasil_perhitungan"] = round(${'hasilcombin'.$i},9);
                               
                                break;
                            }
                            ${'hasilcombin'.$i} = $kombin[0][$z] + $kombin[0][$z+1] * (1 - $kombin[0][$z]);
                            
                        } else {
                            if ($z+1 == count($kombin)) {
                        
                                $hasil_combine[$i]["hasil_perhitungan"] = round(${'hasilcombin'.$i},9);
                                break;
                            }
                            
                            ${'hasilcombin'.$i} = ${'hasilcombin'.$i} + $kombin[0][$z+1] * ( 1 - ${'hasilcombin'.$i} );
                            
                        }
                    }
                    // $pe = $kd->nama_penyakit;

                    //simpan array cf Combine 
                    $hasil_penyakit[$i] = collect([
                        round(${'hasilcombin'.$i},9),
                    ]);
                    $hasil = round(${'hasilcombin'.$i},9);
                    
                }
            }
        }
        
        //data nama penyakit
        $nm_gejala = DB::table('penyakit')->pluck('nama_penyakit');
     
        //Gabung Format Nama Penyakit dan hasil diagnosis
        $cf_akhir = collect($hasil_penyakit)->map(function ($item, $index) use ($nm_gejala) {
            return [
                $nm_gejala[$index-1],
                $item->first()
                ];
            });
     
   
        //Dikali 100 Jadiin Persen
        $persentase = $cf_akhir->map(function ($item) {
            $item[1] = round($item[1] * 100,2);
            return $item;
            });
        
        // Di Format JSON untuk disimpan di "data Diagnosis"
        $hasil_penyakit = json_encode($persentase);

        //Cari Nilai Maksimum(Tertinggi)
        $Nilai_maksimum = $persentase->sortByDesc(function($item) {
            return $item[1];
            })->first();

        //ID Penyakit dengan Nilai Tertinggi
        $penyakit_maksimum = $persentase->search($Nilai_maksimum);


        // Mengumpulkan "nilai hasil" untuk diperiksa
        $nilai_persentase = $persentase->pluck(1);
        
        //memfilter persentase ketika ada angka 0
        $filter_persentase = $nilai_persentase->filter(function($value) {
            return $value != 0;
        });

        // Mengecek apakah ada nilai yang sama
        $duplicate = $filter_persentase->duplicates();
       
      
        //Jumlah Total input dari user
        $nilai_total_user = array_sum($cf_user);
        
        //Cari nilai yang beda
        $cek_user_unique = array_unique($cf_user);
   

        // Jika ada nilai yang sama, ketika inputnya 0 semua, ketika  pilih 1 semua, redirect ke halaman diagnosis

        if($nilai_total_user === 0){

            $kodeG = [];
            $bobotkondisi = [];
            foreach ($sorted as $key => $val) {

                    array_push($kodeG, $key);
                    array_push($bobotkondisi, array(str($key), '0'));
            
            }

            $jsonkondisi= json_encode($bobotkondisi);

            //Cek datanya dulu
            $cek_data = DB::table('hasil_diagnosis')->where('kode_hasil', $kode1)->exists();
            if($cek_data == false) {

                    $data = [
                        "1" => ["Bukan Penyakit Ginjal", 0]
                    ];
                    $bkn_ginjal = json_encode($data);

                    //Simpan data Hasil Diagnosis
                    $kode = $request->kode_diagnosa;
                    $tgl = date('Y-m-d'); 
                    DB::table('hasil_diagnosis')->insert([
                        'kode_hasil' => strval($kode),
                        'idpengguna' => Auth::user()->id,
                        'tanggal' => $tgl,
                        'data_diagnosis' => $bkn_ginjal,
                        'kondisi' => $jsonkondisi,
                        'penyakit' => "Bukan Penyakit Ginjal",
                        'nilai_hasil' => '100',
                    ]);

                                                                
                    $kode3 = $request->kode_diagnosa;
                    $hasildiagnosis = DB::table('hasil_diagnosis')->where('kode_hasil', $kode3)->paginate();
                    foreach ($hasildiagnosis as $h){
                        $cari_penyakit = $h->penyakit;
                    }
                                            
                    $penyakit = DB::table('penyakit')->where('nama_penyakit', $cari_penyakit)->paginate();
                    $gejala = DB::table('gejala')->get();
                    $kondisi = DB::table('kondisi_pengguna')->get();
                                                

                
                    return $this->hasil($request);

            }elseif($duplicate->isNotEmpty()) {
                session()->flash('danger', 'Silahkan Pilih Ulang Jawaban Anda!!.');
                return redirect()->route('diagnosis');
            }else{

                $kode3 = $request->kode_diagnosa;
                $hasildiagnosis = DB::table('hasil_diagnosis')->where('kode_hasil', $kode3)->paginate();
                foreach ($hasildiagnosis as $h){
                    $cari_penyakit = $h->penyakit;
                }
                                        
                $penyakit = DB::table('penyakit')->where('nama_penyakit', $cari_penyakit)->paginate();
                $gejala = DB::table('gejala')->get();
                $kondisi = DB::table('kondisi_pengguna')->get();
                                            
            }  

            session()->flash('danger', 'Silahkan Isi Pertanyaan Dibawah!!.');
            return redirect()->route('diagnosis');
        }
        else{ 
            //Cek data diagnosis udah ada belum
            $cek_data = DB::table('hasil_diagnosis')->where('kode_hasil', $kode1)->exists();
            if($cek_data == false) {
                //Simpan data Hasil Diagnosis
                $kode = $request->kode_diagnosa;
                $tgl = date('Y-m-d'); 
                DB::table('hasil_diagnosis')->insert([
                    'kode_hasil' => strval($kode),
                    'idpengguna' => Auth::user()->id,
                    'tanggal' => $tgl,
                    'data_diagnosis' => $hasil_penyakit,
                    'kondisi' => $jsonData,
                    'penyakit' => $Nilai_maksimum[0],
                    'nilai_hasil' => $Nilai_maksimum[1],
                ]);

                //Tampil Data Hasil  
                $hasildiagnosis = DB::table('hasil_diagnosis')->where('kode_hasil', $kode)->paginate();
                foreach ($hasildiagnosis as $h){
                    $cari_penyakit = $h->penyakit;
                }
                                        
                $penyakit = DB::table('penyakit')->where('nama_penyakit', $cari_penyakit)->paginate();
            
                $gejala = DB::table('gejala')->get();
                $kondisi = DB::table('kondisi_pengguna')->get();                  
            
            }elseif($duplicate->isNotEmpty()) {
                session()->flash('danger', 'Silahkan Pilih Ulang Jawaban Anda!!.');
                return redirect()->route('diagnosis');
            }
            else{
                                            
                $kode3 = $request->kode_diagnosa;
                $hasildiagnosis = DB::table('hasil_diagnosis')->where('kode_hasil', $kode3)->paginate();
                foreach ($hasildiagnosis as $h){
                    $cari_penyakit = $h->penyakit;
                }
                                        
                $penyakit = DB::table('penyakit')->where('nama_penyakit', $cari_penyakit)->paginate();
                $gejala = DB::table('gejala')->get();
                $kondisi = DB::table('kondisi_pengguna')->get();
                                            
                }                           
        
        }
        return $this->hasil($request);
    }



private function hasil(Request $request)
{
      
    //Halaman Untuk Hasil DIagnosis        
    $kode3 = $request->kode_diagnosa;
    $hasildiagnosis = DB::table('hasil_diagnosis')->where('kode_hasil', $kode3)->paginate();
    foreach ($hasildiagnosis as $h){
        $cari_penyakit = $h->penyakit;
    }
   
    $penyakit = DB::table('penyakit')->where('nama_penyakit', $cari_penyakit)->paginate();
    $gejala = DB::table('gejala')->get();
    
    $kode4 = $request->id ;
    $hasil_diagnosis = DB::table('hasil_diagnosis')->where('kode_hasil', $kode4)->paginate();
    
    foreach($hasil_diagnosis as $hasil){
        $id_p = $hasil->penyakit;
    };

    
    $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', $id_p)->pluck('id_penyakit')->first();
            
    $analisa =  DB::table('analisa')->where('idpenyakit', $cari_penyakit)->pluck('nilai_prioritas');
    $penyakit2 = DB::table('penyakit')->where('nama_penyakit', $id_p)->get();
    $gejala3 = DB::table('gejala')->where('jenis', $id_p)->pluck('kode_gejala');
    $kondisi = DB::table('kondisi_pengguna')->get();
    $cari_gejala = DB::table('gejala')->where('jenis', $id_p)->pluck('id_gejala');
    $cari_gejala1 = DB::table('gejala')->where('jenis', $id_p)->pluck('id_gejala')->first();
    $cari_gejala2 = DB::table('gejala')->where('jenis', $id_p)->orderby('id_gejala', 'desc')->pluck('id_gejala')->first();
    $input_user = DB::table('hasil_diagnosis')->where('kode_hasil', $kode4)->get('kondisi');
    
    $kondisiArray = json_encode($input_user, true);
    $arrayData = json_decode($kondisiArray, true);
    $kondisiArray2 = json_decode($arrayData[0]['kondisi'], true);


    $gejala2 = DB::table('gejala')->where('jenis', $id_p)->get();
    
    //mengambil data input user dari database
    $kondisiUser= [];

    for ($i = $cari_gejala1-1 ; $i < $cari_gejala2; $i++) {
        $kondisiUser[] = [
            'kondisi' => $kondisiArray2[$i],
        ];
    }
   

    //merubah format kondisi user
    $transform = array_map(function ($item) {
        return $item['kondisi'];
    }, $kondisiUser);

  

    //mengambil nilai kondisinya saja
    $values = [];
    foreach ($transform as $subarray) {
        if (isset($subarray[1])) {
            $values[] = $subarray[1];
        }
    }


    //menampilkan input user dengan kode gejalanya(CF user)
    $lihat_user = [];
    $hitung = min(count($kondisiUser), count($gejala3));
    for ($i = 0; $i < $hitung; $i++) {
        $lihat_user[] = [
            'kondisi' => $values[$i],
            'gejala' => $gejala3[$i]
        ];
    }


    //gabungkan nilai bobot dengan kode gejala(menampilkan cf pakar )
    $combined = [];
    $count = min(count($analisa), count($gejala3));
    for ($i = 0; $i < $count; $i++) {
        $combined[] = [
            'analis' => $analisa[$i],
            'gejala' => $gejala3[$i]
        ];
    }
    // dd($combined);

    foreach($hasil_diagnosis as $hasil){
        $data_d = $hasil->data_diagnosis;
    };

    $decode_hasil = json_decode($data_d, true);


    usort($decode_hasil, function($a, $b) {
        return $b[1] <=> $a[1];
    });

    // Mengambil 3 elemen teratas
    $top3 = array_slice($decode_hasil, 0, 3);

    // dd($top3);
    return view('pengguna.hasil', ['hasil_diagnosis' => $hasil_diagnosis,'penyakit' => $penyakit,'top3' => $top3,'gejala' => $gejala,'gejala2' => $gejala2,'analisa' => $analisa,'combined' => $combined,'cari_gejala' => $cari_gejala,'kondisiArray2' => $kondisiArray2, 'kondisiUser' => $kondisiUser, 'lihat_user' => $lihat_user, 'gejala' => $gejala,'penyakit' => $penyakit, 'kondisi' => $kondisi, 'hasildiagnosis' => $hasildiagnosis,'penyakit2' => $penyakit2 ]);
}

}