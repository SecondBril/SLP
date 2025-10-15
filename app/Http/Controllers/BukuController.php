<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;

/**
 * Class BukuController
 * Mengelola semua request HTTP terkait data buku yang disimpan di file JSON.
 */
class BukuController extends Controller
{
    /**
     * @var string Lokasi file penyimpanan data buku.
     */
    protected $filePath = 'buku.json';

    //======================================================================
    // == BAGIAN INI BERASAL DARI SERVICE (LOGIKA MANIPULASI DATA) ==
    //======================================================================

    /**
     * Mengambil semua data buku dari file JSON.
     *
     * @return array
     */
    private function getAllBuku(): array
    {
        if (!Storage::exists($this->filePath)) {
            return [];
        }

        $jsonContent = Storage::get($this->filePath);
        $data = json_decode($jsonContent, true);

        if (!is_array($data)) {
            return [];
        }

        // Mengurutkan data berdasarkan tanggal register (data terbaru di atas)
        usort($data, function ($a, $b) {
            $timeA = isset($a['tanggal_register']) ? strtotime($a['tanggal_register']) : 0;
            $timeB = isset($b['tanggal_register']) ? strtotime($b['tanggal_register']) : 0;
            return $timeB - $timeA;
        });

        return $data;
    }

    /**
     * Mencari dan mengembalikan satu data buku berdasarkan ID (kode_buku).
     *
     * @param string $id
     * @return array|null
     */
    private function getBukuById(string $id): ?array
    {
        foreach ($this->getAllBuku() as $buku) {
            if (isset($buku['kode_buku']) && $buku['kode_buku'] === $id) {
                return $buku;
            }
        }
        return null;
    }

    /**
     * Menyimpan seluruh data buku ke file JSON.
     *
     * @param array $data
     * @return bool
     */
    private function saveData(array $data): bool
    {
        $jsonContent = json_encode(array_values($data), JSON_PRETTY_PRINT);
        return Storage::put($this->filePath, $jsonContent);
    }

    /**
     * Menghasilkan Kode Buku yang unik.
     *
     * @return string
     */
    private function generateKodeBuku(): string
    {
        do {
            $kodeBuku = 'BK-' . strtoupper(uniqid());
        } while ($this->getBukuById($kodeBuku));

        return $kodeBuku;
    }

    /**
     * Menampilkan halaman dashboard dengan data agregat buku.
     *
     * @return \Illuminate\View\View
     */

    public function dashboard()
    {
        // 1. Mengambil semua data buku dan mengubahnya menjadi Collection
        $allBuku = collect($this->getAllBuku());

        // 2. Menghitung total semua buku
        $totalBuku = $allBuku->count();

        // 3. Menghitung jumlah buku per kategori
        $bukuPerKategori = $allBuku->countBy('kategori');

        // 4. (Perbaikan) Mengambil 5 buku TERBARU, bukan 5 buku pertama
        //    Diurutkan berdasarkan tanggal_register secara descending (terbaru ke terlama)
        $bukuTerbaru = $allBuku->sortByDesc('tanggal_register')->take(5);

        // --- PENAMBAHAN BARU ---

        // 5. Mendapatkan nama bulan saat ini dalam format Bahasa Indonesia (misal: "Oktober")
        //    Kita menggunakan Carbon untuk ini. setlocale() memastikan nama bulan sesuai dengan server.
        //    isoFormat('MMMM') akan memberikan nama bulan lengkap.
        setlocale(LC_TIME, 'id_ID.utf8');
        $namaBulanIni = Carbon::now()->isoFormat('MMMM');

        // 6. Menghitung jumlah buku yang ditambahkan PADA BULAN INI
        //    - Kita filter koleksi buku.
        //    - Carbon::parse mengubah string tanggal menjadi objek Carbon.
        //    - isSameMonth(Carbon::now()) akan return true jika tanggal buku berada di bulan & tahun yang sama dengan sekarang.
        $jumlahBukuBulanIni = $allBuku->filter(function ($buku) {
            if (!isset($buku['tanggal_register']) || empty($buku['tanggal_register'])) {
                return false;
            }
            return Carbon::parse($buku['tanggal_register'])->isSameMonth(Carbon::now());
        })->count();

        // --- AKHIR PENAMBAHAN ---

        // 7. Mengirim semua data ke view, termasuk dua variabel baru
        return view('dashboard', compact(
            'totalBuku',
            'bukuPerKategori',
            'bukuTerbaru',
            'jumlahBukuBulanIni',
            'namaBulanIni'
        ));
    }

    /**
     * Menampilkan daftar semua data buku.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $bukuArray = $this->getAllBuku();
        $buku = collect($bukuArray);
        return view('buku.index', compact('buku'));
    }

    /**
     * Menampilkan form untuk menambah data buku baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Variabel $kotaOptions tidak lagi relevan untuk buku
        return view('buku.create');
    }

    /**
     * Menyimpan data buku baru dari form.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Lakukan validasi dasar terhadap input form.
        $validatedData = $request->validate([
            'ISBN'         => 'required|string|min:10|max:20',
            'judul'        => 'required|string|min:3|max:255',
            'kategori'     => 'required|string|max:50',
            'lokasi_rak'   => 'required|string|max:20',
            'penulis'      => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4',
        ]);

        // 2. Ambil semua data buku yang sudah ada.
        $allData = $this->getAllBuku();

        // --- PENGECEKAN ISBN UNIK ---
        // 3. Gunakan Laravel Collection untuk mencari apakah ada buku dengan ISBN yang sama.
        //    firstWhere() akan mengembalikan data buku pertama yang cocok, atau null jika tidak ada.
        $isbnExists = collect($allData)->firstWhere('ISBN', $validatedData['ISBN']);

        // 4. Jika $isbnExists tidak null (artinya ISBN sudah ada), kembalikan ke halaman sebelumnya.
        if ($isbnExists) {
            // withErrors() akan mengirimkan pesan error ke view.
            // withInput() akan mengisi kembali form dengan data yang sudah diinput pengguna.
            return back()->withErrors(['ISBN' => 'This ISBN is already registered. Please use a different ISBN.'])->withInput();
        }
        // --- AKHIR PENGECEKAN ---


        // 5. Jika ISBN unik, lanjutkan proses pembuatan data baru.
        //    Kode_buku sudah dijamin unik oleh fungsi generateKodeBuku().
        $newData = array_merge($validatedData, [
            'kode_buku'        => $this->generateKodeBuku(),
            'tanggal_register' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
        ]);

        // 6. Tambahkan data baru ke awal array dan simpan.
        array_unshift($allData, $newData);
        $this->saveData($allData);

        // 7. Redirect ke halaman index dengan pesan sukses.
        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data buku.
     * (Metode ini ditambahkan untuk kelengkapan CRUD)
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $buku = $this->getBukuById($id);

        if (!$buku) {
            // Jika data tidak ditemukan, kembali ke index dengan pesan error
            return redirect()->route('buku.index')->with('error', 'Data buku tidak ditemukan.');
        }

        return view('buku.edit', ['buku' => $buku]); // variabel 'buku' disesuaikan dengan view edit
    }

    /**
     * Memperbarui data buku di dalam file JSON.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // 1. Lakukan validasi dasar terhadap input form.
        $validatedData = $request->validate([
            'ISBN'         => 'required|string|min:10|max:20',
            'judul'        => 'required|string|min:3|max:255',
            'kategori'     => 'required|string|max:50',
            'lokasi_rak'   => 'required|string|max:20',
            'penulis'      => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4',
        ]);

        // 2. Ambil semua data buku yang ada.
        $allData = $this->getAllBuku();

        // --- PENGECEKAN ISBN UNIK ---
        // 3. Cari buku yang memiliki ISBN sama DENGAN input DAN kode_bukunya BUKAN kode_buku yang sedang diedit.
        $isbnExistsOnOtherBook = collect($allData)->first(function ($buku) use ($validatedData, $id) {
            return $buku['ISBN'] === $validatedData['ISBN'] && $buku['kode_buku'] !== $id;
        });

        // 4. Jika ditemukan (artinya ISBN dipakai oleh buku lain), kembalikan dengan pesan error.
        if ($isbnExistsOnOtherBook) {
            return back()->withErrors(['ISBN' => 'ISBN ini sudah digunakan oleh buku lain.'])->withInput();
        }


        // 5. Jika ISBN unik, lanjutkan proses pembaruan data.
        $dataUpdated = false;
        foreach ($allData as $key => $buku) {
            if (isset($buku['kode_buku']) && $buku['kode_buku'] === $id) {
                // Gabungkan data lama (seperti kode_buku & tgl_register) dengan data baru dari form.
                $allData[$key] = array_merge($buku, $validatedData);
                $dataUpdated = true;
                break;
            }
        }

        // 6. Jika pembaruan berhasil, simpan data dan redirect.
        if ($dataUpdated) {
            $this->saveData($allData);
            return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
        }

        // 7. Jika buku yang akan diedit tidak ditemukan, kembalikan dengan pesan error.
        return redirect()->route('buku.index')->with('error', 'Gagal memperbarui data, buku tidak ditemukan.');
    }

    /**
     * Menghapus data buku dari file JSON.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $allData = $this->getAllBuku();
        $initialCount = count($allData);

        $filteredData = array_filter($allData, function ($buku) use ($id) {
            return isset($buku['kode_buku']) && $buku['kode_buku'] !== $id;
        });

        if (count($filteredData) < $initialCount) {
            $this->saveData($filteredData);
            return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
        }

        return redirect()->route('buku.index')->with('error', 'Gagal menghapus data, buku tidak ditemukan.');
    }
}
