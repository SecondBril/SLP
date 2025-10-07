<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

/**
 * Class PeminjamService
 *
 * Bertanggung jawab untuk semua operasi terkait data peminjam
 * yang disimpan dalam file JSON.
 */
class PeminjamService
{
    /**
     * @var string Lokasi file penyimpanan data.
     */
    protected $filePath = 'peminjam.json';

    /**
     * Mengambil semua data peminjam dari file JSON.
     *
     * @return array Array data peminjam.
     */
    public function getAllPeminjam(): array
    {
        if (!Storage::exists($this->filePath)) {
            return [];
        }

        $jsonContent = Storage::get($this->filePath);
        $data = json_decode($jsonContent, true);

        // Mengurutkan data berdasarkan tanggal register secara descending
        usort($data, function ($a, $b) {
            return strtotime($b['tanggal_register']) - strtotime($a['tanggal_register']);
        });

        return $data;
    }

    /**
     * Menyimpan seluruh data peminjam ke file JSON.
     *
     * @param array $data Data peminjam yang akan disimpan.
     * @return bool True jika berhasil, false jika gagal.
     */
    private function saveData(array $data): bool
    {
        $jsonContent = json_encode($data, JSON_PRETTY_PRINT);
        return Storage::put($this->filePath, $jsonContent);
    }

    /**
     * Menambahkan data peminjam baru ke dalam file.
     *
     * @param array $newData Data peminjam baru yang akan ditambahkan.
     * @return bool True jika berhasil.
     */
    public function addPeminjam(array $newData): bool
    {
        $allData = $this->getAllPeminjam();

        // Menambahkan tanggal register secara otomatis
        $newData['tanggal_register'] = Carbon::now()->toDateTimeString();

        // Menambahkan data baru ke awal array agar urutan descending terjaga
        array_unshift($allData, $newData);

        return $this->saveData($allData);
    }
}
