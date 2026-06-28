<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggotas';

    protected $fillable = [
        'nama', 'alamat', 'no_hp', 'email', 'tgl_daftar'
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}