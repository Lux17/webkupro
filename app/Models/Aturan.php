<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Penyakit as Authenticatable;

class Aturan extends Model
{
    use HasFactory;
    protected $table = 'aturan';
    protected $primaryKey = 'id_aturan';
    protected $fillable = ['gejala_x', 'gejala_y', 'nilai_pakar', 'idpenyakit'];
    public $timestamps = false;
}
