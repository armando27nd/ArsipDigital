@extends('layouts.app')

@section('content')
<style>
    .container{
        font-family: 'Times New Roman', Times, serif;    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Detail Disposisi: {{ $disposisi->perihal }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Bagian Kiri: Informasi Surat --}}
                <div class="col-md-6">
                    <h5>Informasi Surat</h5>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="30%"><strong>Diajukan oleh</strong></td>
                            <td>: {{ $disposisi->user->name ?? 'User tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Diajukan</strong></td>
                            <td>: {{ $disposisi->created_at->translatedFormat('d F Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Asal Surat</strong></td>
                            <td>: {{ $disposisi->asal }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nomor & Tgl. Surat</strong></td>
                            <td>: {{ $disposisi->no_dan_tanggal }}</td>
                        </tr>
                        <tr>
                            <td><strong>Perihal</strong></td>
                            <td>: {{ $disposisi->perihal }}</td>
                        </tr>
                        <tr>
                            <td><strong>Instruksi Awal</strong></td>
                            <td>: {{ $disposisi->instruksi_user ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>File Surat</strong></td>
                            <td>
                                @if($disposisi->file_surat)
                                : <a href="{{ asset('storage/disposisi_files/' . $disposisi->file_surat) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat File</a>
                                @else
                                : Tidak ada file
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                {{-- Bagian Kanan: Informasi Disposisi dari Pimpinan --}}
                <div class="col-md-6">
                    <h5>Tindak Lanjut Pimpinan</h5>
                    {{-- Tampilkan bagian ini hanya jika sudah diproses admin --}}
                    @if($disposisi->admin_id)
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="30%"><strong>Status</strong></td>
                            <td>:
                                @if($disposisi->status == 'disetujui')
                                <span class="badge badge-success">{{ ucfirst($disposisi->status) }}</span>
                                @elseif($disposisi->status == 'ditolak')
                                <span class="badge badge-danger">{{ ucfirst($disposisi->status) }}</span>
                                @else
                                <span class="badge badge-warning">{{ ucfirst($disposisi->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Diproses oleh</strong></td>
                            <td>: {{ $disposisi->admin->name ?? 'Admin tidak ditemukan' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Waktu Instruksi</strong></td>
                            <td>:
                                {{ $disposisi->waktu_instruksi_admin ? $disposisi->waktu_instruksi_admin->translatedFormat('d F Y, H:i') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;"><strong>Instruksi Pimpinan</strong></td>
                            <td style="vertical-align: top;">: {{ $disposisi->instruksi_admin ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diteruskan Kepada</strong></td>
                            <td>: {{ $disposisi->diteruskan ?? '-' }}</td>
                        </tr>
                    </table>
                    @else
                    <div class="alert alert-info">
                        Disposisi ini belum ditindaklanjuti oleh pimpinan.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
            @php
                $routeCetak = Auth::user()->role == 'admin' ? route('admin.disposisi.cetak', $disposisi->id) : route('user.disposisi.cetak', $disposisi->id);
            @endphp
            <a href="{{ $routeCetak }}" target="_blank" btn btn-success">Cetak Disposisi</a>

            @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.disposisi.edit', $disposisi->id) }}" class="btn btn-primary float-right">Proses / Edit Disposisi</a>
            @endif
        </div>
    </div>

    <hr>

    {{-- Bagian Pratinjau Cetak --}}
    <h4 class="mt-4">Pratinjau Cetak</h4>
    <div id="print-area">
        {{-- Memanggil file parsial dan mengirimkan data $disposisi --}}
        @include('disposisi.cetak', ['disposisi' => $disposisi, 'is_preview' => true])
    </div>
</div>
@endsection
