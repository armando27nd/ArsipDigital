@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Disposisi Baru</h4>
                </div>
                <div class="card-body">
                    {{-- Logika untuk menentukan action form berdasarkan role --}}
                    @php
                        $formAction = null; // Inisialisasi variabel
                        if (Auth::user()->role == 'admin') {
                            $formAction = route('admin.disposisi.store');
                        } elseif (Auth::user()->role == 'user') {
                            $formAction = route('user.disposisi.proses');
                        }
                    @endphp

                    <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>Pilih Jenis Surat</option>
                                <option value="masuk" {{ old('jenis') == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                <option value="keluar" {{ old('jenis') == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="no_registrasi">No. Registrasi</label>
                            <input type="text" name="no_registrasi" id="no_registrasi" class="form-control" value="{{ old('no_registrasi') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal Penyelesaian</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="perihal">Perihal</label>
                            <textarea name="perihal" id="perihal" class="form-control" required>{{ old('perihal') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="no_dan_tanggal">No. / Tanggal Surat</label>
                            <input type="text" name="no_dan_tanggal" id="no_dan_tanggal" class="form-control" value="{{ old('no_dan_tanggal') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="asal">Asal Surat</label>
                            <input type="text" name="asal" id="asal" class="form-control" value="{{ old('asal') }}" required>
                        </div>

                        <div class="form-group">d
                            <label for="file_surat">Upload File Surat (Opsional)</label>
                            <input type="file" name="file_surat" id="file_surat" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control">{{ old('catatan') }}</textarea>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary">Simpan Disposisi</button>
                        @php
                            $routeKembali = Auth::user()->role == 'admin' ? route('admin.disposisi.index') : route('user.disposisi.index');
                        @endphp
                        <a href="{{ $routeKembali }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
