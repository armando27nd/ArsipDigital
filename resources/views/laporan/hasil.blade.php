@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Filter Laporan Agenda
                </div>
                <div class="card-body">
                    {{-- Form Filter --}}
                    {{-- PERBAIKAN UTAMA DI SINI: UBAH ACTION KE ROUTE laporan.index --}}
                    <form method="get" action="{{ route('laporan.index') }}">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pilih Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required value="{{ $tanggal_terpilih ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Filter Berdasarkan Disposisi</label>
                                    <select class="form-control" name="disposisi_id">
                                        <option value="semua">- Semua Disposisi -</option>
                                        @foreach($disposisiList as $d)
                                            <option value="{{ $d->id }}" {{ ($disposisi_terpilih ?? '') == $d->id ? 'selected' : '' }}>
                                                {{ $d->perihal }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input type="submit" class="btn btn-primary mt-4" value="Tampilkan">
                            </div>
                        </div>
                    </form>

                    <hr>

                    {{-- Tombol Print & Excel --}}
                    {{-- Tombol ini hanya muncul jika filter sudah diterapkan (tanggal_terpilih tidak null) --}}
                    @if($tanggal_terpilih)
                    <a target="_blank" href="{{ route('laporan.pdf', ['tanggal' => $tanggal_terpilih, 'disposisi_id' => $disposisi_terpilih]) }}" class="btn btn-secondary">
                        <i class="fas fa-print"></i> Print
                    </a>
                    <a target="_blank" href="{{ route('laporan.excel', ['tanggal' => $tanggal_terpilih, 'disposisi_id' => $disposisi_terpilih]) }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    @else
                    <p class="text-muted">Pilih filter tanggal dan disposisi terlebih dahulu untuk mengaktifkan tombol Print dan Export.</p>
                    @endif

                    {{-- Tabel Hasil --}}
                    <table class="table table-bordered table-striped mt-4">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Jam</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Kegiatan</th>
                                <th>Tempat</th>
                                <th>Pejabat</th>
                                <th>Keterangan</th>
                                <th>Surat Asal</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Hanya tampilkan data jika ada agenda yang ditemukan --}}
                            @forelse($agendas as $index => $agenda)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($agenda->jam)->format('H:i') }} WIB</td>
                                    {{-- Menggunakan $agenda->tanggal sesuai model Agenda --}}
                                    <td>{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $agenda->kegiatan }}</td>
                                    <td>{{ $agenda->tempat }}</td>
                                    <td>{{ $agenda->pejabat }}</td>
                                    <td>{{ $agenda->keterangan }}</td>
                                    <td>{{ $agenda->disposisi->no_dan_tanggal ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        @if($tanggal_terpilih)
                                            Tidak ada data agenda yang ditemukan untuk filter ini.
                                        @else
                                            Silakan pilih tanggal dan disposisi untuk menampilkan laporan.
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
