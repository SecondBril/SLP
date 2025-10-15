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

        // Kembalikan array kosong untuk mencegah error
        if (!is_array($data)) {
            return [];
        }

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
     * Menghasilkan Kode Buku yang unik dan terjamin tidak ada di data.
     *
     * @return string
     */
    private function generateKodeBuku(): string
    {
        do {
            // 1. Buat kode acak dengan prefix 'BK-'
            $kodeBuku = 'BK-' . strtoupper(uniqid());

            // 2. Cek apakah kode ini sudah ada
            $existing = $this->getPeminjamById($kodeBuku);

        // 3. Jika sudah ada ($existing tidak null), ulangi prosesnya.
        } while ($existing);

        return $kodeBuku;
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

        // Menambahkan kode buku yang unik secara otomatis
        $newData['kode_buku'] = $this->generateKodeBuku();

        // Menambahkan tanggal register secara otomatis
        $newData['tanggal_register'] = Carbon::now()->toDateTimeString();

        // Menambahkan data baru ke awal array agar urutan descending terjaga
        array_unshift($allData, $newData);

        return $this->saveData($allData);
    }

    /**
     * Mencari dan mengembalikan satu data peminjam berdasarkan ID (kode_buku).
     *
     * @param string $id ID unik (kode_buku) dari peminjam.
     * @return array|null Mengembalikan data peminjam jika ditemukan, atau null jika tidak.
     */
    public function getPeminjamById(string $id): ?array
    {
        $allData = $this->getAllPeminjam();
        foreach ($allData as $peminjam) {
            if (isset($peminjam['kode_buku']) && $peminjam['kode_buku'] === $id) {
                return $peminjam;
            }
        }
        return null;
    }

    /**
     * Memperbarui data peminjam yang ada berdasarkan ID.
     *
     * @param string $id ID unik (kode_buku) dari data yang akan diperbarui.
     * @param array $updatedData Data baru untuk menggantikan data lama.
     * @return bool True jika berhasil, false jika tidak ada data yang diperbarui.
     */
    public function updatePeminjam(string $id, array $updatedData): bool
    {
        $allData = $this->getAllPeminjam();
        $dataUpdated = false;

        // Cari dan perbarui data yang sesuai
        foreach ($allData as $key => $peminjam) {
            if (isset($peminjam['kode_buku']) && $peminjam['kode_buku'] === $id) {
                // Ganti data lama dengan data baru
                $allData[$key] = $updatedData;
                $dataUpdated = true;
                break; // Keluar dari loop setelah data ditemukan dan diperbarui
            }
        }

        // Jika ada data yang berhasil diperbarui, simpan kembali ke file
        if ($dataUpdated) {
            return $this->saveData($allData);
        }

        return false;
    }

    /**
     * Menghapus data peminjam dari file berdasarkan ID.
     *
     * @param string $id ID unik (kode_buku) dari data yang akan dihapus.
     * @return bool True jika berhasil, false jika data tidak ditemukan.
     */
    public function deletePeminjam(string $id): bool
    {
        $allData = $this->getAllPeminjam();
        $initialCount = count($allData);

        // Filter array, hanya simpan data yang 'kode_buku'-nya TIDAK SAMA dengan $id
        $filteredData = array_filter($allData, function ($peminjam) use ($id) {
            return isset($peminjam['kode_buku']) && $peminjam['kode_buku'] !== $id;
        });

        // Cek apakah ada data yang terhapus dengan membandingkan jumlah array
        if (count($filteredData) < $initialCount) {
            return $this->saveData($filteredData);
        }

        return false; // Tidak ada data yang dihapus
    }
}
