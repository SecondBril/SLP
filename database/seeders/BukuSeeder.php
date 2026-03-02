<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use Illuminate\Support\Carbon;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dummy yang diambil dari struktur JSON Anda sebelumnya
        $dataBuku = [
            [
                "ISBN" => "978602063582766",
                "judul" => "Sebuah Seni untuk Bersikap Bodo Amat",
                "kategori" => "Pengembangan Diri",
                "lokasi_rak" => "PD-01",
                "penulis" => "Mark Manson",
                "penerbit" => "Gramedia Pustaka Utama",
                "tahun_terbit" => "2019",
                "kode_buku" => "BK-DEV001",
                "tanggal_register" => "2025-10-16 08:25:11"
            ],
            [
                "ISBN" => "9786024812309",
                "judul" => "Bumi",
                "kategori" => "Fiksi",
                "lokasi_rak" => "FK-05",
                "penulis" => "Tere Liye",
                "penerbit" => "Gramedia Pustaka Utama",
                "tahun_terbit" => "2014",
                "kode_buku" => "BK-FIK001",
                "tanggal_register" => "2025-10-15 11:45:30"
            ],
            [
                "ISBN" => "9786024246128",
                "judul" => "Cosmos",
                "kategori" => "Sains & Teknologi",
                "lokasi_rak" => "ST-11",
                "penulis" => "Carl Sagan",
                "penerbit" => "Kepustakaan Populer Gramedia",
                "tahun_terbit" => "2017",
                "kode_buku" => "BK-SCI001",
                "tanggal_register" => "2025-10-14 09:10:05"
            ],
            [
                "ISBN" => "9789799109315",
                "judul" => "Nusantara: A History of Indonesia",
                "kategori" => "Sejarah",
                "lokasi_rak" => "SJ-02",
                "penulis" => "Bernard H.M. Vlekke",
                "penerbit" => "Kepustakaan Populer Gramedia",
                "tahun_terbit" => "2016",
                "kode_buku" => "BK-SEJ001",
                "tanggal_register" => "2025-10-13 14:00:00"
            ],
            [
                "ISBN" => "9786020320333",
                "judul" => "Filosofi Teras",
                "kategori" => "Pengembangan Diri",
                "lokasi_rak" => "PD-02",
                "penulis" => "Henry Manampiring",
                "penerbit" => "Kompas",
                "tahun_terbit" => "2018",
                "kode_buku" => "BK-DEV002",
                "tanggal_register" => "2025-10-12 16:20:45"
            ],
            [
                "ISBN" => "9789792273113",
                "judul" => "Laskar Pelangi",
                "kategori" => "Fiksi",
                "lokasi_rak" => "FK-08",
                "penulis" => "Andrea Hirata",
                "penerbit" => "Bentang Pustaka",
                "tahun_terbit" => "2005",
                "kode_buku" => "BK-FIK002",
                "tanggal_register" => "2025-10-10 10:30:00"
            ],
            [
                "ISBN" => "9786024246838",
                "judul" => "Guns, Germs, and Steel",
                "kategori" => "Sejarah",
                "lokasi_rak" => "SJ-03",
                "penulis" => "Jared Diamond",
                "penerbit" => "Kepustakaan Populer Gramedia",
                "tahun_terbit" => "2018",
                "kode_buku" => "BK-SEJ002",
                "tanggal_register" => "2025-10-09 13:00:19"
            ],
            [
                "ISBN" => "9780553801477",
                "judul" => "A Brief History of Time",
                "kategori" => "Sains & Teknologi",
                "lokasi_rak" => "ST-07",
                "penulis" => "Stephen Hawking",
                "penerbit" => "Bantam Dell Publishing Group",
                "tahun_terbit" => "1988",
                "kode_buku" => "BK-SCI002",
                "tanggal_register" => "2025-10-08 17:55:00"
            ],
            [
                "ISBN" => "9786024241772",
                "judul" => "Sejarah Dunia yang Disembunyikan",
                "kategori" => "Non-Fiksi",
                "lokasi_rak" => "NF-01",
                "penulis" => "Jonathan Black",
                "penerbit" => "Pustaka Alvabet",
                "tahun_terbit" => "2016",
                "kode_buku" => "BK-NON001",
                "tanggal_register" => "2025-10-07 15:15:15"
            ],
            [
                "ISBN" => "9781451673319",
                "judul" => "How to Win Friends and Influence People",
                "kategori" => "Non-Fiksi",
                "lokasi_rak" => "NF-04",
                "penulis" => "Dale Carnegie",
                "penerbit" => "Simon & Schuster",
                "tahun_terbit" => "1936",
                "kode_buku" => "BK-NON002",
                "tanggal_register" => "2025-10-05 20:10:10"
            ]
        ];

        // Looping dan masukkan data ke database menggunakan Model
        foreach ($dataBuku as $buku) {
            // Kita menggunakan updateOrCreate agar jika seeder dijalankan dua kali,
            // data tidak menjadi duplikat (mengakibatkan error unique constraint pada ISBN).
            Buku::updateOrCreate(
                ['ISBN' => $buku['ISBN']], // Kunci pencarian
                $buku // Data yang diisi atau diperbarui
            );
        }
    }
}
