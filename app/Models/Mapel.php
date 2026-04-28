<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Mapel extends Model
{
    use HasFactory;
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mapel';
    protected $fillable = ['id_mapel', 'nama_mapel', 'id_kelas','id_guru'];
    public $timestamps = false;


    public function kelas()
    {
    return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'id_guru');
    }
    public function kuis()
    {
        return $this->hasMany(Kuis::class, 'id_mapel');
    }

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

