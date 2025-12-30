@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Daftar Surat Masuk</h1>
            <a href="{{ route('surat-masuk.create') }}" class="btn btn-primary">Tambah</a>
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
                        <th>KETEARANGAN</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- FIX 1: Inisialisasi nomor di luar loop --}}
                    @php $no = 1; @endphp
                    @foreach ($surat_masuk as $sm)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $sm->kode_klasifikasi }}</td>
                        <td>{{ $sm->isi_ringkasan }}</td>
                        <td>{{ $sm->asal }}</td>
                        <td>{{ $sm->no_surat }}</td>
                        <td>{{ \Carbon\Carbon::parse($sm->tanggal)->format('d-m-Y') }}</td>

                         <td>
                            @if($sm->file)
                            <a href="{{ url('data_file/'.$sm->file) }}" target="_blank">Lihat</a>
                            @else
                            Tidak ada
                            @endif
                        </td>
                        <td>{{ $sm->keterangan ?? '-'}}</td>
                         <td class="text-center">
                            <a href="{{ route('surat-masuk.edit', $sm->id_sm) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                            <a href="{{ route('surat-masuk.destroy', $sm->id_sm) }}"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                        class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
