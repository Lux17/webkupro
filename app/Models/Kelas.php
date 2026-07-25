<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable = ['id_kelas', 'nama_kelas'];
    public $timestamps = false;


    public function users()
    {
    return $this->hasMany(User::class, 'id_kelas');
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

