<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id(); // Primary key bawaan untuk efisiensi relasi di masa depan
            $table->string('kode_buku', 50)->unique(); // Indexing untuk pencarian cepat
            $table->string('ISBN', 20)->unique();
            $table->string('judul');
            $table->string('kategori', 50);
            $table->string('lokasi_rak', 20);
            $table->string('penulis', 100);
            $table->string('penerbit', 100);
            $table->year('tahun_terbit');
            $table->dateTime('tanggal_register');
            $table->timestamps(); // Mengelola created_at dan updated_at secara otomatis
        });
    }

    public function down()
    {
        Schema::dropIfExists('buku');
    }
};
