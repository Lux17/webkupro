<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $table = 'kuis';
    protected $primaryKey = 'id_kuis';

    // karena pakai created_at / updated_at default
    public $timestamps = true;

    protected $fillable = [
        'durasi',
        'id_mapel',
        'id_guru',
        'kode_kuis'
    ];

    protected $casts = [
        'durasi' => 'integer',
    ];

    public function mapel()
{
    return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
}

}