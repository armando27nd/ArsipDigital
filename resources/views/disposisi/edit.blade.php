{{-- views/disposisi/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('admin.disposisi.update', $disposisi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <h4>Detail Disposisi dari: {{ $disposisi->user->name ?? 'User' }}</h4>
                <p>Status Saat Ini: <span class="badge badge-info">{{ $disposisi->status }}</span></p>
            </div>
            <div class="card-body">
                {{-- Tampilkan data yang diinput user sebagai read-only --}}
                <p><strong>Asal Surat:</strong> {{ $disposisi->asal }}</p>
                <p><strong>Perihal:</strong> {{ $disposisi->perihal }}</p>
                <p><strong>File:</strong> <a href="{{ asset('data_file/' . $disposisi->file_surat) }}"
                        target="_blank">Lihat File</a></p>
                {{-- ... field lainnya dari user ... --}}
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4>Instruksi & Persetujuan Admin</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="instruksi_admin">Instruksi dari Pimpinan</label>
                    <textarea name="instruksi_admin" class="form-control"
                        rows="4">{{ old('instruksi_admin', $disposisi->instruksi_admin) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="diteruskan">Diteruskan Kepada</label>
                    <input type="text" name="diteruskan" class="form-control"
                        value="{{ old('diteruskan', $disposisi->diteruskan) }}">
                </div>
                <div class="form-group">
                    <label for="status">Ubah Status</label>
                    <select name="status" class="form-control" required>
                        <option value="proses" {{ $disposisi->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ $disposisi->status == 'disetujui' ? 'selected' : '' }}>Disetujui
                        </option>
                        <option value="ditolak" {{ $disposisi->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jenis">Jenis Disposisi (Untuk Agenda)</label>
                    <select  name="jenis" class="form-control" required>
                        <option value="">-- Biasa --</option>
                        <option value="undangan" {{ $disposisi->jenis == 'undangan' ? 'selected' : '' }}>
                            Undangan/Penugasan</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Simpan Perubahan</button>
        <a href="{{ route('admin.disposisi.index') }}" class="btn btn-secondary mt-2">Batal</a>
    </form>
</div>
@endsection
