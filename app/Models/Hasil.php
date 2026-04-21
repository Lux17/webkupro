<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Hasil extends Model
{
    use HasFactory;
    protected $table = 'hasil_diagnosis';
    protected $primaryKey = 'id_hasil';
    protected $fillable = ['kode_hasil', 'data_diagnosis', 'idpengguna','kondisi', 'tanggal', 'penyakit', 'nilai_hasil'];
    public $timestamps = false;
}
