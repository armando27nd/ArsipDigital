@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Daftar Surat Keluar</h1>
            <a href="{{ route('surat-keluar.create') }}" class="btn btn-primary">Tambah</a>
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
                        <th>KODE KLASIFIKASI</th>
                        <th>ISI RINGKASAN</th>
                        <th>ASAL SURAT</th>
                        <th>NOMOR SURAT</th>
                        <th>TANGGAL SURAT</th>
                        <th>FILE SURAT</th>
                        <th>Catatan/Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- FIX 1: Inisialisasi nomor di luar loop --}}
                    @php $no = 1; @endphp
                    @foreach ($surat_keluar as $sk)
                    <tr>
                       <td>{{ $no++ }}</td>
                        <td>{{ $sk->kode_klasifikasi }}</td>
                        <td>{{ $sk->isi_ringkasan }}</td>
                        <td>{{ $sk->asal }}</td>
                        <td>{{ $sk->no_surat }}</td>
                        <td>{{ \Carbon\Carbon::parse($sk->tanggal)->format('d-m-Y') }}</td>

                         <td>
                            @if($sk->file)
                            <a href="{{ url('data_file/'.$sk->file) }}" target="_blank">Lihat</a>
                            @else
                            Tidak ada
                            @endif
                        </td>
                        <td>{{ $sk->keterangan ?? '-'}}</td>
                         <td class="text-center">
                            <a href="{{ route('surat-keluar.edit', $sk->id_sk) }}"
                                        class="btn btn-sk btn-primary">Edit</a>
                            <a href="{{ route('surat-keluar.destroy', $sk->id_sk) }}"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                        class="btn btn-sk btn-danger">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
