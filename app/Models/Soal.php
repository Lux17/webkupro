<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';
    protected $primaryKey = 'id_soal';

    // karena pakai created_at / updated_at default
    public $timestamps = false;

    protected $fillable = [
        'durasi',
        'pertanyaan',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'opsi_e',
        'jawaban',
        'kode_kuis',
        'id_mapel',
        'id_guru'
    ];

    protected $casts = [
        'durasi' => 'integer',
    ];

}