<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Analisa extends Model
{
    use HasFactory;
    protected $table = 'analisa';
    protected $primaryKey = 'id_analisa';
    protected $fillable = ['idpenyakit', 'gejala', 'jumlah_nilai',  'nilai_eigen','nilai_prioritas'];
    public $timestamps = false;
}
