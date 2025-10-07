@extends('layouts.app')

@section('title', 'Tambah Data Peminjam')

@section('content')
    <div class="page-header mb-4">
        <div class="page-header-content">
            <div>
                <h1 class="mb-1" style="font-weight: 700; font-size: 28px; color: #2d3142;">Tambah Data Peminjaman</h1>
                <p class="text-muted mb-0" style="font-size: 14px;">Isi formulir di bawah untuk menambahkan data peminjam baru.</p>
            </div>
        </div>
    </div>

    <hr class="mb-4">

    <div class="data-card">
        <form action="{{ route('peminjam.store') }}" method="POST">
        @csrf
        <div class="form-body">
            <div class="form-grid">

                <div class="form-group">
                    <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control @error('nama_peminjam') is-invalid @enderror" id="nama_peminjam" name="nama_peminjam" value="{{ old('nama_peminjam') }}" placeholder="Masukkan nama lengkap" required>
                    @error('nama_peminjam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" required maxlength="16">
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group grid-full-width">
                    <label for="alamat" class="form-label">Alamat</label>
                    {{-- Textarea tidak memerlukan input-wrapper karena tidak ada ikon di dalamnya --}}
                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kota" class="form-label">Kota</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </span>
                        <select class="form-control @error('kota') is-invalid @enderror" id="kota" name="kota" required>
                            <option value="" disabled selected>Pilih Kota</option>
                            @foreach ($kotaOptions as $kota)
                                <option value="{{ $kota }}" {{ old('kota') == $kota ? 'selected' : '' }}>
                                    {{ $kota }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hp" class="form-label">No. HP</label>
                    <input type="tel" class="form-control @error('hp') is-invalid @enderror" id="hp" name="hp" value="{{ old('hp') }}" placeholder="08xx xxxx xxxx" required>
                    @error('hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group grid-full-width">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Contoh: Karyawan Swasta" required>
                    @error('pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('peminjam.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Simpan Data
            </button>
        </div>
    </form>
    </div>
@endsection

@section('scripts')
<style>
    /* Menggunakan style dari halaman list untuk konsistensi */

    /* Form Card specific styles */
    .form-body {
        padding: 0px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .grid-full-width {
        grid-column: 1 / -1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-label {
        font-weight: 500;
        color: #2d3142;
        font-size: 14px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px 12px 48px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    /* Specific padding for textarea and select without icon */
    textarea.form-control {
        padding: 12px 16px;
    }

    input.form-control {
        padding: 12px 16px;
    }

    select.form-control {
        appearance: none;
        padding-right: 40px; /* space for custom arrow */
    }

    .form-control:focus {
        outline: none;
        border-color: #ff6b35;
        box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1);
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 13px;
        margin-top: 4px;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
    }

    /* Form Actions */
    .form-actions {
        padding: 20px 0px;
        background-color: #f8f9fa;
        border-top: 1px solid #f1f2f6;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 107, 53, 0.4);
    }

    .btn-secondary {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        color: #6c757d;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        border-color: #dee2e6;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }


        .form-actions {
            flex-direction: column-reverse;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    // NIK validation - only numbers
    document.getElementById('nik').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Phone number validation - only numbers
    document.getElementById('hp').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endsection
