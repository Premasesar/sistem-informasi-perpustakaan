<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'kode_buku', 'judul', 'penulis',
        'penerbit', 'tahun', 'stok', 'cover'
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}