<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function kelas()
    {
    return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function mapel()
    {
        return $this->hasMany(Mapel::class, 'id_guru');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /**
     * Mass-assignable attributes. Intentionally excludes `rolename`
     * to prevent privilege escalation via mass assignment.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'riwayat_penyakit',
        'tgl_lahir',
        'nisn',
        'nip',
        'id_kelas',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jawaban_kuis()
{
    return $this->hasMany(Jawaban::class, 'id_user', 'id');
}

    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'id_guru', 'id');
    }

    public function files()
    {
        return $this->hasMany(Files::class, 'id_user', 'id');
    }

    public function kuis()
    {
        return $this->hasMany(Kuis::class, 'id_guru', 'id');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'id_guru', 'id');
    }


}
