@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Daftar Disposisi</h1>
            @auth
            @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.disposisi.create') }}" class="btn btn-primary">Tambah Disposisi</a>
            @elseif(Auth::user()->role == 'user')
            <a href="{{ route('user.disposisi.tambah') }}" class="btn btn-primary">Tambah Disposisi</a>
            @endif
            @endauth
        </div>
        <div class="card-body">
            @if(session('sukses'))
            <div class="alert alert-success">
                {{ session('sukses') }}
            </div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="1%">#</th>
                        <th>No. Registrasi</th>
                        <th>Tanggal Penyelesaian</th>
                        <th>Perihal</th>
                        <th>No./Tgl Surat</th>
                        <th>Asal</th>
                        <th>File Surat</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- FIX 1: Inisialisasi nomor di luar loop --}}
                    @php $no = 1; @endphp
                    @forelse ($disposisis as $disposisi)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $disposisi->no_registrasi }}</td>
                        <td>{{ \Carbon\Carbon::parse($disposisi->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $disposisi->perihal }}</td>
                        <td>{{ $disposisi->no_dan_tanggal }}</td>
                        <td>{{ $disposisi->asal }}</td>
                        <td>
                            @if($disposisi->file_surat)
                            <a href="{{ asset('storage/disposisi_files/' . $disposisi->file_surat) }}"
                                target="_blank">Lihat File</a>
                            @else
                            -
                            @endif
                        </td>
                        <td>{{ $disposisi->catatan ?? '-'}}</td>
                        <td>
                            @if($disposisi->status == 'disetujui')
                            <span class="badge badge-success">{{ ucfirst($disposisi->status) }}</span>
                            @elseif($disposisi->status == 'ditolak')
                            <span class="badge badge-danger">{{ ucfirst($disposisi->status) }}</span>
                            @else
                            <span class="badge badge-warning">{{ ucfirst($disposisi->status) }}</span>
                            @endif
                        </td>
                        {{-- FIX 3: Hanya satu kolom <td> untuk semua tombol aksi --}}
                        <td>

                            @php
                            $routeDetail = Auth::user()->role == 'admin' ? route('admin.disposisi.show', $disposisi->id)
                            : route('user.disposisi.show', $disposisi->id);
                            @endphp
                            <a href="{{ $routeDetail }}" class="btn btn-sm btn-info">Detail</a>
                            @if($disposisi->status == 'disetujui' && !$disposisi->agenda)
                            <a href="{{ route('agenda.create', ['disposisi' => $disposisi->id]) }}"
                                class="btn btn-sm btn-success">Agendakan</a>
                            @endif

                            <!-- Tombol Khusus role admin -->
                            @if(Auth::user()->role == 'admin')
                            <a href="{{ route('admin.disposisi.edit', $disposisi->id) }}"
                                class="btn btn-sm btn-primary">Proses</a>
                            <!-- Khusus role user -->
                            @elseif(Auth::user()->role =='user' )
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- FIX 4: Colspan disesuaikan dengan jumlah kolom (11) --}}
                        <td colspan="11" class="text-center">Belum ada data disposisi.</td>
                    </tr>
                    @endforelse
                </tbody>

                
            </table>
        </div>
    </div>
</div>
@endsection
