<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BukuController extends Controller
{
    /**
     * Menghasilkan Kode Buku yang unik langsung divalidasi ke database.
     */
    private function generateKodeBuku(): string
    {
        do {
            $kodeBuku = 'BK-' . strtoupper(uniqid());
        } while (Buku::where('kode_buku', $kodeBuku)->exists());

        return $kodeBuku;
    }

   public function dashboard()
    {
        $now = \Carbon\Carbon::now();

        // 1. Total keseluruhan buku
        $totalBuku = Buku::count();

        // 2. Limitasi 5 buku terbaru
        $bukuTerbaru = Buku::orderBy('tanggal_register', 'desc')->limit(5)->get();

        // 3. Agregasi buku bulan ini
        $jumlahBukuBulanIni = Buku::whereMonth('tanggal_register', $now->month)
                                ->whereYear('tanggal_register', $now->year)
                                ->count();

        // 4. Agregasi buku hari ini (Metrik yang terlewat)
        $jumlahBukuHariIni = Buku::whereDate('tanggal_register', $now->format('Y-m-d'))
                                ->count();

        setlocale(LC_TIME, 'id_ID.utf8');
        $namaBulanIni = $now->isoFormat('MMMM');

        return view('dashboard', compact(
            'totalBuku',
            'bukuTerbaru',
            'jumlahBukuBulanIni',
            'jumlahBukuHariIni',
            'namaBulanIni'
        ));
    }

    public function index()
    {
        // Query diserahkan ke DB engine.
        $buku = Buku::orderBy('tanggal_register', 'desc')->get();

        $jumlahBukuHariIni = Buku::whereDate('tanggal_register', Carbon::today())->count();

        return view('buku.index', compact('buku', 'jumlahBukuHariIni'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ISBN'         => 'required|string|min:10|max:20|unique:buku,ISBN', // Validasi unique ditangani langsung oleh database
            'judul'        => 'required|string|min:3|max:255',
            'kategori'     => 'required|string|max:50',
            'lokasi_rak'   => 'required|string|max:20',
            'penulis'      => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4',
        ]);

        $validatedData['kode_buku'] = $this->generateKodeBuku();
        $validatedData['tanggal_register'] = Carbon::now('Asia/Jakarta')->toDateTimeString();

        // Eksekusi insert yang bersih.
        Buku::create($validatedData);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Cari berdasarkan kode_buku atau gagalkan (404) secara otomatis
        $buku = Buku::where('kode_buku', $id)->firstOrFail();

        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::where('kode_buku', $id)->firstOrFail();

        $validatedData = $request->validate([
            // Mengecualikan id buku saat ini dari validasi unique
            'ISBN'         => 'required|string|min:10|max:20|unique:buku,ISBN,' . $buku->id,
            'judul'        => 'required|string|min:3|max:255',
            'kategori'     => 'required|string|max:50',
            'lokasi_rak'   => 'required|string|max:20',
            'penulis'      => 'required|string|max:100',
            'penerbit'     => 'required|string|max:100',
            'tahun_terbit' => 'required|numeric|digits:4',
        ]);

        $buku->update($validatedData);

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::where('kode_buku', $id)->first();

        if ($buku) {
            $buku->delete();
            return redirect()->route('buku.index')->with('success', 'Data buku berhasil dihapus!');
        }

        return redirect()->route('buku.index')->with('error', 'Gagal menghapus data, buku tidak ditemukan.');
    }
}
