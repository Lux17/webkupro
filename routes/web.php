<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EmailController;

//Halaman Awal
Route::view('/', 'landing/index');

//Admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/kelas', [KelasController::class, 'index'])->name('kelas');
Route::get('/mapel', [MapelController::class, 'index'])->name('mapel');
Route::get('/materi', [MateriController::class, 'index'])->name('materi');
Route::get('/kuis', [KuisController::class, 'index'])->name('kuis');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
Route::get('/guru', [GuruController::class, 'index'])->name('guru');

Route::get('/email-verif', [EmailController::class, 'index'])->name('email-verif');
Route::get('/files', [FilesController::class, 'index'])->name('files');
Route::get('/tambah-materi', [MateriController::class, 'tambah_materi'])->name('tambah-materi');
Route::get('/ubah-materi/{id_materi}', [MateriController::class, 'ubah_materi'])->name('ubah-materi');
Route::get('/tampil-materi/{id_materi}', [MateriController::class, 'tampil_materi'])->name('tampil-materi');
Route::get('/tambah-kuis/{id_kuis}', [KuisController::class, 'tambah_kuis'])->name('tambah-kuis');
Route::get('/ubah-kuis/{id_kuis}', [KuisController::class, 'ubah_kuis'])->name('ubah-kuis');
Route::get('/tampil-kuis/{kode_kuis}', [KuisController::class, 'tampil_kuis'])->name('tampil-kuis');
Route::post('/tambah-soal', [KuisController::class, 'tambah_soal'])->name('tambah-soal');
Route::post('/ubah-soal/{id_kuis}', [KuisController::class, 'ubah_soal'])->name('ubah-soal');
Route::get('/soal/{kode_kuis}', [KuisController::class, 'soal'])->name('soal');
Route::post('/hasil', [KuisController::class, 'hasil'])->name('hasil');
Route::get('/class/{id_kelas}', [ClassController::class, 'index'])->name('class');
Route::get('/lessons/{id_materi}', [LessonsController::class, 'index'])->name('lessons');
Route::get('/quiz/{kode_kuis}', [QuizController::class, 'index'])->name('quiz');
Route::post('/result', [ResultController::class, 'index'])->name('result');
Route::get('/result_user{kode_kuis}', [ResultController::class, 'index'])->name('result_user');

//pengguna
Route::get('/info', [InfoController::class, 'index'])->name('info');
Route::get('/unduh/{id}', [DownloadController::class, 'unduh'])->name('unduh');
Route::get('/riwayat/cari_riwayat', 'App\Http\Controllers\RiwayatController@search_riwayat')->name('cari_riwayat');

//Crud
//kelas
Route::get('/kelas/search_kelas', 'App\Http\Controllers\KelasController@search_kelas')->name('search_kelas');
Route::post('/kelas/simpan', 'App\Http\Controllers\KelasController@simpan')->name('simpan');
Route::put('/kelas/update_kelas/{id}', 'App\Http\Controllers\KelasController@update_kelas')->name('update_kelas');
Route::delete('/kelas/hapus_kelas/{id}', 'App\Http\Controllers\KelasController@hapus_kelas')->name('hapus_kelas');


//mapel
Route::get('/mapel/search_mapel', 'App\Http\Controllers\MapelController@search_mapel')->name('search_mapel');
Route::post('/mapel/simpan', 'App\Http\Controllers\MapelController@simpan')->name('simpan');
Route::put('/mapel/update_mapel/{id}', 'App\Http\Controllers\MapelController@update_mapel')->name('update_mapel');
Route::delete('/mapel/hapus_mapel/{id}', 'App\Http\Controllers\MapelController@hapus_mapel')->name('hapus_mapel');


Route::get('/materi/search_materi', 'App\Http\Controllers\materiController@search_materi')->name('search_materi');
Route::post('/materi/simpan', 'App\Http\Controllers\materiController@simpan')->name('simpan_materi');
Route::put('/materi/update_materi/{id}', 'App\Http\Controllers\materiController@update_materi')->name('update_materi');
Route::delete('/materi/hapus_materi/{id}', 'App\Http\Controllers\materiController@hapus_materi')->name('hapus_materi');

Route::get('/kuis/search_kuis', 'App\Http\Controllers\KuisController@search_kuis')->name('search_kuis');
Route::post('/kuis/simpan', 'App\Http\Controllers\KuisController@simpan')->name('simpan_kuis');
Route::put('/kuis/update_kuis/{id}', 'App\Http\Controllers\KuisController@update_kuis')->name('update_kuis');
Route::delete('/kuis/hapus_kuis/{id}', 'App\Http\Controllers\KuisController@hapus_kuis')->name('hapus_kuis');


Route::get('/files/search_files', 'App\Http\Controllers\FilesController@search_files')->name('search_files');
Route::post('/files/simpan', 'App\Http\Controllers\FilesController@simpan')->name('simpan');
Route::put('/files/update_files/{id}', 'App\Http\Controllers\FilesController@update_files')->name('update_files');
Route::delete('/files/hapus_files/{id}', 'App\Http\Controllers\FilesController@hapus_files')->name('hapus_files');


//Data Admin
Route::get('/admin/search_admin', 'App\Http\Controllers\AdminController@search_admin')->name('search_admin');
Route::post('/admin/simpan', 'App\Http\Controllers\AdminController@simpan')->name('simpan_admin');
Route::put('/admin/update_admin/{id}', 'App\Http\Controllers\AdminController@update_admin')->name('update_admin');
Route::delete('/admin/hapus_admin/{id}', 'App\Http\Controllers\AdminController@hapus_admin')->name('hapus_admin');


//Data Pengguna
Route::get('/users/search_users', 'App\Http\Controllers\PenggunaController@search_users')->name('search_users');
Route::post('/users/simpan', 'App\Http\Controllers\PenggunaController@simpan')->name('simpan_users');
Route::put('/users/update_users/{id}', 'App\Http\Controllers\PenggunaController@update_users')->name('update_users');
Route::delete('/users/hapus_users/{id}', 'App\Http\Controllers\PenggunaController@hapus_users')->name('hapus_users');


Route::get('/guru/search_guru', 'App\Http\Controllers\GuruController@search_guru')->name('search_guru');
Route::post('/guru/simpan', 'App\Http\Controllers\GuruController@simpan')->name('simpan_guru');
Route::put('/guru/update_guru/{id}', 'App\Http\Controllers\GuruController@update_guru')->name('update_guru');
Route::delete('/guru/hapus_guru/{id}', 'App\Http\Controllers\GuruController@hapus_guru')->name('hapus_guru');



// DASHBOARD GURU
Route::get('/dashboard_guru', [DashboardController::class, 'index_guru'])->name('dashboard_guru');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');



require __DIR__.'/auth.php';
