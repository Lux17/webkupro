<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Episode extends Model
{
    use HasFactory;
    protected $table = 'episode';
    protected $primaryKey = 'id_eps';
    protected $fillable = ['nama_eps', 'isi_eps', 'type', 'id_materi', 'tgl','img'];
    public $timestamps = false;
}
