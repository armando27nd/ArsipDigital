@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="float-left">Daftar Agenda</h4>
                </div>
                <div class="card-body">
                    @if(Session::has('sukses'))
                        <div class="alert alert-success">{{ Session::get('sukses') }}</div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>No./Tgl Surat</th>
                                <th>Jam</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Kegiatan</th>
                                <th>Tempat</th>
                                <th>Pejabat</th>
                                <th>Keterangan</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agendas as $index => $a)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $a->disposisi->no_dan_tanggal ?? 'N/A' }}</td>
                                {{-- FIX: Menambahkan teks "WIB" setelah format jam --}}
                                <td>{{ \Carbon\Carbon::parse($a->jam)->format('H:i') }} WIB</td>
                                <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</td>
                                <td>{{ $a->kegiatan }}</td>
                                <td>{{ $a->tempat }}</td>
                                <td>{{ $a->pejabat }}</td>
                                <td>{{ $a->keterangan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('agenda.edit', $a->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('agenda.destroy', $a->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data agenda.</td>
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
