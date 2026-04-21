<?php

namespace App\Http\Controllers;
use App\Models\Hasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Session;


class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');

        }elseif(auth()->user()->rolename === 'admin'){
            return redirect('/dashboard');

        }elseif(auth()->user()->rolename === 'pengguna'){
            
            $id = Auth::user()->id ;
            $hasil_diagnosis = DB::table('hasil_diagnosis')->where('idpengguna', $id)->get();
         
            return view('pengguna.riwayat', ['hasil_diagnosis' => $hasil_diagnosis]);

        }else{
            return redirect('/');
        }


    }
    
    public function search_riwayat(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');

        }elseif(auth()->user()->rolename === 'admin'){
            return redirect('/dashboard');

        }elseif(auth()->user()->rolename === 'pengguna'){
            
            //ambil data dari input cari
            $keyword = $request->search;

            //menghapus session notif
            Session::forget('danger');
            session()->flash('success', 'Data hasil diagnosis berhasil ditemukan.');

            //cari data dan tampilkan data hasil
            $hasil_diagnosis = Hasil::where('kode_hasil', 'like', "%".$keyword."%")->paginate(10);
            return view('pengguna.riwayat', ['hasil_diagnosis' => $hasil_diagnosis]);
            
        }else{
            return redirect('/');
        }

    }


    public function rincian(Request $request, $id)
    {
        if(auth()->user() === null ){
            return redirect('/');

        }elseif(auth()->user()->rolename === 'admin'){
            return redirect('/dashboard');

        }elseif(auth()->user()->rolename === 'pengguna'){
            

            $kode = $request->id ;
        
   
            $hasil_diagnosis = DB::table('hasil_diagnosis')->where('kode_hasil', $kode)->paginate();
            foreach($hasil_diagnosis as $hasil){
                $id_p = $hasil->penyakit;
            };
            $cari_penyakit = DB::table('penyakit')->where('nama_penyakit', $id_p)->pluck('id_penyakit')->first();
            $analisa =  DB::table('analisa')->where('idpenyakit', $cari_penyakit)->pluck('nilai_prioritas');
            $penyakit = DB::table('penyakit')->where('nama_penyakit', $id_p)->get();
            $gejala = DB::table('gejala')->where('jenis', $id_p)->pluck('kode_gejala');
            $cari_gejala = DB::table('gejala')->where('jenis', $id_p)->pluck('id_gejala');
            $cari_gejala1 = DB::table('gejala')->where('jenis', $id_p)->pluck('id_gejala')->first();
            $cari_gejala2 = DB::table('gejala')->where('jenis', $id_p)->orderby('id_gejala', 'desc')->pluck('id_gejala')->first();
            $input_user = DB::table('hasil_diagnosis')->where('kode_hasil', $kode)->get('kondisi');
            
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
         
            foreach($hasil_diagnosis as $hasil){
                $data_d = $hasil->data_diagnosis;
            };
        
            $decode_hasil = json_decode($data_d, true);
        
        
            usort($decode_hasil, function($a, $b) {
                return $b[1] <=> $a[1];
            });
        
            // Mengambil 3 elemen teratas
            $top3 = array_slice($decode_hasil, 0, 3);
    
            return view('pengguna.rincian', ['hasil_diagnosis' => $hasil_diagnosis,'penyakit' => $penyakit,'top3' => $top3,'gejala' => $gejala,'gejala2' => $gejala2,'analisa' => $analisa,'combined' => $combined,'cari_gejala' => $cari_gejala,'kondisiArray2' => $kondisiArray2, 'kondisiUser' => $kondisiUser, 'lihat_user' => $lihat_user]);
        

        }else{
            return redirect('/');
        }
        
    }
}