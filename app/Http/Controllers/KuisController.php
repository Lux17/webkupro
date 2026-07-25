<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\Soal;
use App\Models\Mapel;
use App\Models\User;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
            $kuis = Kuis::with(['mapel','guru'])
            ->orderBy('id_kuis', 'asc')
            ->get();
            
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            
            $guru =  User::where('rolename', 'like', 'guru')->get();
            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
        }elseif(auth()->user()->rolename === 'guru'){
            //hitung kuis
            $user = Auth::user();
            $kuis = Kuis::with(['mapel','guru'])
            ->orderBy('id_kuis', 'asc')
            ->get();


            $hitung_kuis = Kuis::where('id_guru', $user->id)->count();
            
            $mapel = Mapel::where('id_guru', Auth::id())->orderBy('id_mapel', 'asc')->get();
            
            $guru =  User::where('rolename', 'like', 'guru')->get();
            //hapus notif/session
            Session::forget('danger');
            Session::forget('success');

            return view('guru.kuis_guru', ['kuis' => $kuis,'user' => $user,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }
 }

    public function get_soal_by_kode($kode_kuis)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $rolename = auth()->user()->rolename;
        if (!in_array($rolename, ['admin', 'guru'])) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $soal = Soal::where('kode_kuis', $kode_kuis)
            ->orderBy('id_soal', 'asc')
            ->get();

        return response()->json($soal);
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
            $kuis = kuis::with(['mapel','guru'])->where('nama_kuis', 'like', "%".$keyword."%")->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();

            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
        }elseif(auth()->user()->rolename === 'guru'){
            $user = Auth::user();
            //cari kata dari input
            $keyword = $request->search;

            //hitung kuis
            $hitung_kuis = kuis::count();

            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil ditemukan.');
            //cari data dari database
            
            $kuis = Kuis::with(['mapel','guru'])->where('id_guru', Auth::id())
            ->where('nama_kuis', 'like', "%{$keyword}%")
            ->get();
           $mapel = Mapel::where('id_guru', Auth::id())->orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();

            return view('guru.kuis_guru', ['kuis' => $kuis,'user' => $user,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);

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
             $mapel_id =  $request->id_mapel;
             $cari_guru = Mapel::where('id_mapel',  $mapel_id )->pluck('id_guru')->first();
            
             //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'kode_kuis' => ['required', 'min:1'],
                'nama_kuis' => ['required', 'min:1'],
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
                'nama_kuis' => $request->nama_kuis,
                'kode_kuis' => $request->kode_kuis,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $cari_guru,
                'durasi' => $request->durasi,
            ]);

            //menampilkan data
            $kuis = Kuis::with(['mapel','guru'])
            ->orderBy('id_kuis', 'asc')
            ->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil disimpan.');
            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
        }elseif(auth()->user()->rolename === 'guru'){
            $user = Auth::user();
            $mapel_id =  $request->id_mapel;
             $cari_guru = Mapel::where('id_mapel',  $mapel_id )->pluck('id_guru')->first();
            
             //Validasi Masukan
            $validator = Validator::make($request->all(), [
                'kode_kuis' => ['required', 'min:1'],
                'nama_kuis' => ['required', 'min:1'],
                'id_mapel' => ['required', 'min:1'],
                'durasi' => ['required', 'min:1']
            ]);
            
            //menampilkan pesan eror validasi
            if ($validator->fails()) {
                session()->flash('danger', 'Data tidak dapat disimpan, cek data dan silahkan ulangi!!');
                return redirect('guru.kuis_guru')->withErrors($validator)->withInput();
            }
            
            $hitung_kuis2 = kuis::count();
            //nilai untuk id
            $idnext = $hitung_kuis2 + 1;
            Kuis::insert([
                'id_kuis' => $idnext,
                'nama_kuis' => $request->nama_kuis,
                'kode_kuis' => $request->kode_kuis,
                'id_mapel' => $request->id_mapel,
                'id_guru' => $cari_guru,
                'durasi' => $request->durasi,
            ]);

            //menampilkan data
            $kuis = Kuis::with(['mapel','guru'])->where('id_guru', Auth::id())
                            ->orderBy('id_kuis')
                            ->get();

            $hitung_kuis = Kuis::where('id_guru', $user->id)->count();
           $mapel = Mapel::where('id_guru', Auth::id())->orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil disimpan.');
            return view('guru.kuis_guru', ['kuis' => $kuis,'user' => $user,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);

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
            $kuis = Kuis::with(['mapel','guru'])
            ->orderBy('id_kuis', 'asc')
            ->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil diubah.');
            
            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
        }elseif(auth()->user()->rolename === 'guru'){
            
            session()->start();
            $user = Auth::user();
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
                return redirect('guru.kuis_guru')->withErrors($validator)->withInput();
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
    
            $kuis = Kuis::with(['mapel','guru'])->where('id_guru', Auth::id())
                            ->orderBy('id_kuis')
                            ->get();

            $hitung_kuis = Kuis::where('id_guru', $user->id)->count();
            $mapel = Mapel::where('id_guru', Auth::id())->orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil diubah.');
            
            return view('guru.kuis_guru', ['kuis' => $kuis,'user' => $user,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);

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
            $kuis = Kuis::with(['mapel','guru'])
            ->orderBy('id_kuis', 'asc')
            ->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('success');
            session()->flash('danger', 'Data kuis berhasil dihapus.');
            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis,'hapus_kuis' => $hapus_kuis]);
        }elseif(auth()->user()->rolename === 'guru'){
            $user = Auth::user();
            session()->start();
            //hapus data
            $hapus_kuis = kuis::where('id_kuis', $id_kuis)->delete();
            $kuis = Kuis::with(['mapel','guru'])->where('id_guru', Auth::id())
                            ->orderBy('id_kuis')
                            ->get();

            $hitung_kuis = Kuis::where('id_guru', $user->id)->count();
            $mapel = Mapel::where('id_guru', Auth::id())->orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('success');
            session()->flash('danger', 'Data kuis berhasil dihapus.');
            return view('guru.kuis_guru', ['kuis' => $kuis,'user' => $user,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis,'hapus_kuis' => $hapus_kuis]);

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
        }elseif(auth()->user()->rolename === 'guru'){
            
            session()->start();
            $kuis= Kuis::where('id_kuis', $id_kuis)->first();

            return view('guru.tambah-kuis',['kuis' => $kuis]);

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
            $kuis = Kuis::with(['mapel','guru'])
            ->orderBy('id_kuis', 'asc')
            ->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil disimpan.');
            return view('kuis', ['kuis' => $kuis,'mapel' => $mapel, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);
        }elseif(auth()->user()->rolename === 'guru'){
            $user = Auth::user();

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
            $kuis = Kuis::with(['mapel','guru'])->where('id_guru', Auth::id())
                            ->orderBy('id_kuis')
                            ->get();
            $mapel = Mapel::orderBy('id_mapel', 'asc')->get();
            $guru =  User::where('rolename', 'like', 'guru')->get();
            Session::forget('danger');
            session()->flash('success', 'Data kuis berhasil disimpan.');
            return view('guru.kuis_guru', ['kuis' => $kuis,'mapel' => $mapel, 'user' => $user, 'guru' => $guru,'hitung_kuis' => $hitung_kuis]);


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
        }elseif(auth()->user()->rolename === 'guru'){
            session()->start();

            $kuis2 = Kuis::where('id_kuis', $id_kuis)->first();
            $get_kode = Kuis::where('id_kuis', $id_kuis)->value('kode_kuis');
            $soal = Soal::where('kode_kuis', $get_kode)->get();
            $mapel = Mapel::with('kelas')->get();

            return view('guru.ubah-kuis',['mapel' => $mapel, 'kuis2' => $kuis2,'soal' => $soal,'get_kode' => $get_kode]);

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
        }elseif(auth()->user()->rolename === 'guru'){

            session()->start();
            $soal = Soal::where('kode_kuis', $kode_kuis)->get();
            $mapel = Mapel::with('kelas')->get();
            return view('guru.tampil-kuis',['mapel' => $mapel, 'soal' => $soal]);

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
        }elseif(auth()->user()->rolename === 'guru'){
            $user = Auth::user();
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
            return view('guru.kuis_guru',['guru' => $guru,'user' => $user,'mapel' => $mapel, 'kuis' => $kuis,'kuis2' => $kuis2,'hitung_kuis' => $hitung_kuis,'soal' => $soal,'get_kode' => $get_kode]);

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
        }elseif(auth()->user()->rolename === 'guru'){
            session()->start();
    
            $id_kuis = Kuis::where('kode_kuis', $kode_kuis)->value('id_kuis');
         
            $soal = Soal::where('kode_kuis', $kode_kuis)->get();
            
            $mapel_id = Kuis::where('kode_kuis', $kode_kuis)->value('id_mapel'); 
            $mapel = Mapel::with('kelas')->get();
            return view('guru.soal',['mapel' => $mapel, 'id_kuis' => $id_kuis,'mapel_id' => $mapel_id, 'soal' => $soal, 'kode_kuis' => $kode_kuis]);

        }elseif(auth()->user()->rolename === 'pengguna'){
            return redirect('/info');
        }else{
            return redirect('/');
        }

    }


    public function hasil(Request $request)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if ($user->rolename !== 'pengguna') {
            abort(403, 'Hanya siswa yang dapat mengirim jawaban kuis.');
        }

        $validated = $request->validate([
            'id_kuis' => ['required', 'integer'],
            'id_mapel' => ['required', 'integer'],
            'jawaban' => ['nullable', 'array'],
            'jawaban.*.id_soal' => ['required_with:jawaban', 'integer'],
            'jawaban.*.pilihan' => ['nullable', 'string', 'max:5'],
        ]);

        $idKuis = (int) $validated['id_kuis'];
        $idMapelReq = (int) $validated['id_mapel'];
        $jawabanUser = $validated['jawaban'] ?? [];

        $kuis = Kuis::where('id_kuis', $idKuis)->first();
        if (! $kuis) {
            abort(404, 'Kuis tidak ditemukan.');
        }

        $idMapel = (int) $kuis->id_mapel;
        if ($idMapelReq !== $idMapel) {
            abort(422, 'Data mapel tidak valid untuk kuis ini.');
        }

        $mapel = Mapel::where('id_mapel', $idMapel)->first();
        if (! $mapel || (int) $mapel->id_kelas !== (int) $user->id_kelas) {
            abort(403, 'Kuis tidak tersedia untuk kelas Anda.');
        }

        $sessionKey = 'quiz_end_'.$idKuis;

        $existing = Jawaban::where('id_user', $user->id)
            ->where('id_kuis', $idKuis)
            ->first();

        if ($existing) {
            session()->forget($sessionKey);

            return view('hasil', [
                'nilai2' => $existing->skor,
                'nilai' => $existing->skor,
            ]);
        }

        $soalDB = Soal::where('kode_kuis', $kuis->kode_kuis)->get()->keyBy('id_soal');
        $totalSoal = $soalDB->count();
        if ($totalSoal === 0) {
            abort(422, 'Kuis belum memiliki soal.');
        }

        $skor = 0;
        $seen = [];
        foreach ($jawabanUser as $j) {
            $idSoal = (int) ($j['id_soal'] ?? 0);
            if ($idSoal <= 0 || isset($seen[$idSoal])) {
                continue;
            }
            $seen[$idSoal] = true;
            if (! isset($soalDB[$idSoal])) {
                continue;
            }
            $pilihan = isset($j['pilihan']) ? strtoupper(trim((string) $j['pilihan'])) : '';
            if ($pilihan !== '' && strtoupper((string) $soalDB[$idSoal]->jawaban) === $pilihan) {
                $skor++;
            }
        }

        $nilaiTotal = (int) round(($skor / $totalSoal) * 100);

        DB::table('jawaban_kuis')->insert([
            'id_user' => $user->id,
            'id_kuis' => $idKuis,
            'id_mapel' => $idMapel,
            'skor' => $nilaiTotal,
            'timestamp' => now(),
        ]);

        session()->forget($sessionKey);

        return view('hasil', ['nilai2' => $nilaiTotal]);
    }

}