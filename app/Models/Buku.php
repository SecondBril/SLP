<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // Menyesuaikan nama tabel secara eksplisit
    protected $table = 'buku';

    // Mendefinisikan kolom yang boleh diisi (fillable)
    protected $fillable = [
        'kode_buku',
        'ISBN',
        'judul',
        'kategori',
        'lokasi_rak',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'tanggal_register',
    ];
}
