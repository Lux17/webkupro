<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    protected $table = 'jawaban_kuis'; // sesuaikan nama tabel kamu
    protected $primaryKey = 'attempt_id';

    public $timestamps = false; // karena pakai kolom timestamp manual

    protected $fillable = [
        'id_user',
        'id_mapel',
        'skor',
        'timestamp',
        'id_kuis'
    ];

    protected $casts = [
        'id_user' => 'integer',
        'id_kuis' => 'integer',
        'id_mapel' => 'integer',
        'skor' => 'integer',
        'timestamp' => 'datetime',
    ];


    // ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // ke kuis (soal / quiz)
    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'id_kuis');
    }
}