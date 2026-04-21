<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Penyakit extends Model
{
    use HasFactory;
    protected $table = 'penyakit';
    protected $primaryKey = 'id_penyakit';
    protected $fillable = ['kode_penyakit', 'nama_penyakit', 'images', 'solusi'];
    public $timestamps = false;
}

// Model Post
// public function comments()
// {
//     return $this->hasMany(Comment::class);
// }

// Model Comment
// public function post()
// {
//     return $this->belongsTo(Post::class);
// }

