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

class KuisController extends Controller
{

    public function index()
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //hitung kuis
            $hitung_kuis = kuis::count();

            //menampilkan kuis
            $kuis = Kuis::orderBy('id_kuis', 'asc')->get();
            
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
    

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function search_kuis(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            //cari kata dari input
            $keyword = $request->search;

            //hitung kuis
            $hitung_kuis = kuis::count();

            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil ditemukan.');
            //cari data dari database
            $kuis = kuis::where('title', 'like', "%".$keyword."%")->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();

            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
    

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
            
             //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'kode_kuis' => ['required', 'min:1'],
                'id_guru' => ['required', 'min:1'],
                'id_mapel' => ['required', 'min:1'],
                'durasi' => ['required', 'min:1']
            ]);
            
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('kuis')->withErrors($validator)->withInput();
            }
            
            $hitung_kuis = kuis::count();
            //nilai untuk id
            $idnext = $hitung_kuis + 1;
            Kuis::insert([
                'id_kuis' => $idnext,
                'kode_kuis' => $request->kode_kuis,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
                'durasi' => $request->durasi,
            ]);

            //menampilkan data
            $kuis = Kuis::orderBy('id_kuis', 'asc')->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil disimpan.');
            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
    
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

  }
    
    public function update_kuis(Request $request, $id_kuis)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'min:1'],
                'content' => ['required', 'min:1'],
                'id_mapel' => ['required', 'min:1'],
                'tgl' => ['required', 'min:1']
            ]);
    
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('kuis')->withErrors($validator)->withInput();
            }
            //update data
            $preferences = kuis::where('id_kuis', $id_kuis)
                ->update([
                'title' => $request->title,
                'content' => $request->content,
                'tgl' => $request->tgl,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $request->id_guru,
                ]);
    
            $hitung_kuis = kuis::count();
            //menampilkan data
            $kuis = kuis::orderBy('id_kuis', 'asc')->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil diubah.');
            
            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
      
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

  }


    public function hapus_kuis($id_kuis)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            //hapus data
            $hapus_kuis = kuis::where('id_kuis', $id_kuis)->delete();
            $hitung_kuis = kuis::count();
            //menampilkan data
            $kuis = kuis::orderBy('id_kuis', 'asc')->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('success');
            session()->flash('danger', 'Data kuis berhasil dihapus.');
            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis,'hapus_kuis' => $hapus_kuis]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function tambah_kuis(Request $request, $id_kuis)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            $kuis= Kuis::where('id_kuis', $id_kuis)->first();

            return view('tambah-kuis',['kuis' => $kuis]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function tambah_soal(Request $request)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            $hitung_kuis = Kuis::count();
            $data = [];

            foreach ($request->questions as $q) {

                if (empty($q['pertanyaan'])) continue;

                $data[] = [
                    'durasi' =>  $request->durasi,
                    'kode_kuis' =>  $request->kode_kuis,
                    'id_mapel' =>  $request->id_mapel,
                    'id_guru' =>  $request->id_guru,
                    'pertanyaan' => $q['pertanyaan'],
                    'opsi_a' => $q['opsi_a'],
                    'opsi_b' => $q['opsi_b'],
                    'opsi_c' => $q['opsi_c'],
                    'opsi_d' => $q['opsi_d'],
                    'opsi_e' => $q['opsi_e'],
                    'jawaban' => $q['jawaban'],
                ];
            }

            Soal::insert($data);


            //menampilkan data
            $kuis = Kuis::orderBy('id_kuis', 'asc')->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil disimpan.');
            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
    
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
    }

    public function ubah_kuis(Request $request, $id_kuis)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            $kuis2 = Kuis::where('id_kuis', $id_kuis)->first();
            $get_kode = Kuis::where('id_kuis', $id_kuis)->value('kode_kuis');
            $soal = Soal::where('kode_kuis', $get_kode)->get();
            $mapel = Mapel::with('kelas')->get();

            return view('ubah-kuis',['mapel' => $mapel, 'kuis2' => $kuis2,'soal' => $soal,'get_kode' => $get_kode]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

    public function tampil_kuis(Request $request, $kode_kuis)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
            $soal = Soal::where('kode_kuis', $kode_kuis)->get();
            $mapel = Mapel::with('kelas')->get();
            return view('tampil-kuis',['mapel' => $mapel, 'soal' => $soal]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

        public function ubah_soal(Request $request, $id_kuis)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();

            $kuis2 = Kuis::where('id_kuis', $id_kuis)->first();
            $get_kode = Kuis::where('id_kuis', $id_kuis)->value('kode_kuis');
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            $soal = Soal::where('kode_kuis', $get_kode)->get();
            $kuis    = kuis::orderBy('id_kuis', 'asc')->get();
            $hitung_kuis = Kuis::count();

            $kode_kuis = $request->kode_kuis;

            if ($request->deleted_ids) {

                $ids = explode(',', $request->deleted_ids);

                Soal::whereIn('id_soal', $ids)->delete();
            }

            foreach ($request->questions as $q) {


                if (!empty($q['id_soal'])) {

                    Soal::where('id_soal', $q['id_soal'])->update([
                        'pertanyaan' => $q['pertanyaan'],
                        'opsi_a' => $q['opsi_a'],
                        'opsi_b' => $q['opsi_b'],
                        'opsi_c' => $q['opsi_c'],
                        'opsi_d' => $q['opsi_d'],
                        'opsi_e' => $q['opsi_e'],
                        'jawaban' => $q['jawaban'],
                    ]);

                } 
                // kalau soal baru → INSERT
                else {
                    Soal::create([
                        'kode_kuis' => $kode_kuis,
                        'id_mapel' =>  $request->id_mapel,
                        'durasi' =>  $request->durasi,
                        'id_guru' =>  $request->id_guru,
                        'pertanyaan' => $q['pertanyaan'],
                        'opsi_a' => $q['opsi_a'],
                        'opsi_b' => $q['opsi_b'],
                        'opsi_c' => $q['opsi_c'],
                        'opsi_d' => $q['opsi_d'],
                        'opsi_e' => $q['opsi_e'],
                        'jawaban' => $q['jawaban'],
                    ]);
                }
            }
            return view('kuis',['guru' => $guru,'mapel' => $mapel, 'kuis' => $kuis,'kuis2' => $kuis2,'hitung_kuis' => $hitung_kuis,'soal' => $soal,'get_kode' => $get_kode]);
        
        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }

        public function soal(Request $request, $kode_kuis)
    {
        if(auth()->user() === null ){
            return redirect('/');
        }elseif(auth()->user()->rolename === 'admin'){
            
            session()->start();
    
            $id_kuis = Kuis::where('kode_kuis', $kode_kuis)->value('id_kuis');
         
            $soal = Soal::where('kode_kuis', $kode_kuis)->get();
            
            $mapel_id = Kuis::where('kode_kuis', $kode_kuis)->value('id_mapel'); 
            $mapel = Mapel::with('kelas')->get();
            return view('soal',['mapel' => $mapel, 'id_kuis' => $id_kuis,'mapel_id' => $mapel_id, 'soal' => $soal, 'kode_kuis' => $kode_kuis]);
        
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
