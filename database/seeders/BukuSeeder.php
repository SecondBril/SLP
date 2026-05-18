<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use Illuminate\Support\Carbon;
use Faker\Factory as Faker;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Data Spesifik (Manual)
        $dataManual = [
            [
                "ISBN" => "9786020635827",
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
                "ISBN" => "9786020635834",
                "judul" => "Sapiens: A Brief History of Humankind",
                "kategori" => "Sejarah",
                "lokasi_rak" => "SH-03",
                "penulis" => "Yuval Noah Harari",
                "penerbit" => "Gramedia Pustaka Utama",
                "tahun_terbit" => "2015",
                "kode_buku" => "BK-SHJ001",
                "tanggal_register" => "2025-10-14 14:20:45"
            ],
            [
                "ISBN" => "9786024812316",
                "judul" => "Laskar Pelangi",
                "kategori" => "Fiksi",
                "lokasi_rak" => "FK-06",
                "penulis" => "Andrea Hirata",
                "penerbit" => "Bentang Pustaka",
                "tahun_terbit" => "2005",
                "kode_buku" => "BK-FIK002",
                "tanggal_register" => "2025-10-13 09:15:00"
            ],
            [
                "ISBN" => "9786020635841",
                "judul" => "Atomic Habits",
                "kategori" => "Pengembangan Diri",
                "lokasi_rak" => "PD-02",
                "penulis" => "James Clear",
                "penerbit" => "Gramedia Pustaka Utama",
                "tahun_terbit" => "2018",
                "kode_buku" => "BK-DEV002",
                "tanggal_register" => "2025-10-12 16:40:20"
            ],
            [
                "ISBN" => "9786024812323",
                "judul" => "Negeri 5 Menara",
                "kategori" => "Fiksi",
                "lokasi_rak" => "FK-07",
                "penulis" => "Ahmad Fuadi",
                "penerbit" => "Gramedia Pustaka Utama",
                "tahun_terbit" => "2009",
                "kode_buku" => "BK-FIK003",
                "tanggal_register" => "2025-10-11 13:30:50"
            ],
            [
                "ISBN" => "9786020635858",
                "judul" => "The Subtle Art of Not Giving a F*ck",
                "kategori" => "Pengembangan Diri",
                "lokasi_rak" => "PD-03",
                "penulis" => "Mark Manson",
                "penerbit" => "Gramedia Pustaka Utama",
                "tahun_terbit" => "2016",
                "kode_buku" => "BK-DEV003",
                "tanggal_register" => "2025-10-10 10:05:15"
            ],
        ];

        // Eksekusi data manual
        foreach ($dataManual as $buku) {
            Buku::updateOrCreate(['ISBN' => $buku['ISBN']], $buku);
        }

        // 2. Generate Sisa Data (Hingga 100)
        $kategoriList = ['Pengembangan Diri', 'Fiksi', 'Sains & Teknologi', 'Sejarah', 'Non-Fiksi'];
        $currentCount = count($dataManual);
        $targetCount = 100;

        for ($i = $currentCount + 1; $i <= $targetCount; $i++) {
            $kategori = $faker->randomElement($kategoriList);
            $prefix = strtoupper(substr($kategori, 0, 3));

            Buku::updateOrCreate(
                ['ISBN' => $faker->isbn13()],
                [
                    "judul" => $faker->sentence(3),
                    "kategori" => $kategori,
                    "lokasi_rak" => $prefix . "-" . $faker->numberBetween(10, 99),
                    "penulis" => $faker->name,
                    "penerbit" => $faker->company,
                    "tahun_terbit" => $faker->year(),
                    "kode_buku" => "BK-" . $prefix . str_pad($i, 3, '0', STR_PAD_LEFT),
                    "tanggal_register" => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')
                ]
            );
        }
    }
}
