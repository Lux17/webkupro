<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Files extends Model
{
    use HasFactory;
    protected $table = 'files';
    protected $primaryKey = 'id_files';
    protected $fillable = ['nama_files', 'id_files', 'tgl', 'id_user'];
    public $timestamps = false;
}
