<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PeminjamService;
use Illuminate\Support\Collection;

/**
 * Class PeminjamController
 * Mengelola request HTTP terkait peminjam.
 */
class PeminjamController extends Controller
{
    /**
     * @var PeminjamService Instance dari PeminjamService.
     */
    protected $peminjamService;

    /**
     * Constructor untuk injeksi PeminjamService.
     *
     * @param PeminjamService $peminjamService
     */
    public function __construct(PeminjamService $peminjamService)
    {
        $this->peminjamService = $peminjamService;
    }

    /**
     * Menampilkan halaman dashboard dengan data agregat.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $allPeminjam = collect($this->peminjamService->getAllPeminjam());

        $totalPeminjam = $allPeminjam->count();
        $peminjamPerKota = $allPeminjam->countBy('kota');
        $peminjamTerakhir = $allPeminjam->take(5);

        return view('dashboard', compact('totalPeminjam', 'peminjamPerKota', 'peminjamTerakhir'));
    }

    /**
     * Menampilkan daftar semua data peminjam.
     *
     * @return \Illuminate\View\View
     */
    // public function index()
    // {
    //     $peminjam = $this->peminjamService->getAllPeminjam();
    //     return view('peminjam.index', compact('peminjam'));
    // }

    public function index()
    {
        // 1. Ambil data (hasilnya adalah array)
        $peminjamArray = $this->peminjamService->getAllPeminjam();

        // 2. Ubah array menjadi Laravel Collection
        $peminjam = collect($peminjamArray);

        // 3. Kirim Collection ke view
        return view('peminjam.index', compact('peminjam'));
    }

    /**
     * Menampilkan form untuk menambah data peminjam baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $kotaOptions = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan', 'Makassar'];
        return view('peminjam.create', compact('kotaOptions'));
    }

    /**
     * Menyimpan data peminjam baru dari form.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data (Requirement 2.e)
        $validatedData = $request->validate([
            'nama_peminjam' => 'required|string|min:3',
            'nik'           => 'required|numeric|digits:16',
            'alamat'        => 'required|string|min:10',
            'kota'          => 'required|string',
            'hp'            => 'required|numeric|min:10',
            'pekerjaan'     => 'required|string|min:3',
        ]);

        $this->peminjamService->addPeminjam($validatedData);

        return redirect()->route('peminjam.index')->with('success', 'Data peminjam berhasil ditambahkan!');
    }
}
