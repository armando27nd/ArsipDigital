@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    Filter Laporan Arsip Surat
                </div>
                <div class="card-body">
                    {{-- Form Filter --}}
                    <form method="get" action="{{ url('/arsip') }}">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Pilih Bulan</label>
                                    <select class="form-select" name="bulan">
                                        <option value="">-- Semua Bulan --</option>
                                        @php
                                            $namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                        @endphp
                                        @foreach ($namaBulan as $index => $bulan)
                                            <option value="{{ $index + 1 }}" {{ ($input['bulan'] ?? '') == ($index + 1) ? 'selected' : '' }}>
                                                {{ $bulan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Masukkan Tahun</label>
                                    <input type="number" name="tahun" class="form-control" placeholder="Contoh: {{ date('Y') }}" value="{{ $input['tahun'] ?? date('Y') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="fw-bold">Jenis Surat</label>
                                    {{-- ====================================================== --}}
                                    {{-- PERUBAHAN DI SINI: Opsi "Semua Jenis" dihapus         --}}
                                    {{-- ====================================================== --}}
                                    <select class="form-select" name="jenis_surat" required>
                                        <option value="">-- Pilih Jenis Surat --</option>
                                        <option value="surat_masuk" {{ ($input['jenis_surat'] ?? '') == 'surat_masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                        <option value="surat_keluar" {{ ($input['jenis_surat'] ?? '') == 'surat_keluar' ? 'selected' : '' }}>Surat Keluar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                                    <a href="{{ url('/arsip') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr>

                    {{-- Tombol Print & Excel --}}
                    @if(isset($input['bulan']) && isset($input['tahun']) && isset($input['jenis_surat']))
                        <p>
                            <a target="_blank" href="{{ route('arsip.pdf', $input) }}" class="btn btn-secondary">
                                <i class="bi bi-printer"></i> Print PDF
                            </a>
                            <a target="_blank" href="{{ route('arsip.excel', $input) }}" class="btn btn-success">
                                <i class="bi bi-file-earmark-excel"></i> Export Excel
                            </a>
                        </p>
                    @else
                        <p class="text-muted">Pilih jenis surat, bulan, dan tahun untuk mengaktifkan tombol Print dan Export.</p>
                    @endif

                    {{-- Tabel Hasil --}}
                    <table class="table table-bordered table-striped mt-3">
                        <thead class="text-center table-dark">
                            <tr>
                                <th>No</th>
                                <th>Jenis Surat</th>
                                <th>Nomor Surat</th>
                                <th>Perihal</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($arsip as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        @if ($item->jenis == 'Surat Masuk')
                                            <span class="badge bg-success">{{ $item->jenis }}</span>
                                        @else
                                            <span class="badge bg-primary">{{ $item->jenis }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->no_surat }}</td>
                                    <td>{{ $item->nama_surat }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td class="text-center">
                                        @if ($item->jenis == 'Surat Masuk')
                                            <a href="{{ url('/surat-masuk/' . $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                                        @else
                                            <a href="{{ url('/surat-keluar/' . $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        @if(isset($input['jenis_surat']))
                                            <strong>Tidak ada data arsip yang ditemukan untuk filter ini.</strong>
                                        @else
                                            <strong>Silakan pilih filter untuk menampilkan laporan.</strong>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
