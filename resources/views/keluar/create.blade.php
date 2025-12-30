@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Tambah</div>
                <div class="card-body">
                    @if(session('sukses'))
                    <div class="alert alert-success">{{ session('sukses') }}</div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('surat-keluar.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>KODE KLASIFIKASI</label>
                            <input type="text" class="form-control" name="kode_klasifikasi" required>
                        </div>

                        <div class="form-group">
                            <label>TANGGAL SURAT</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>

                        <div class="form-group">
                            <label>NO SURAT</label>
                            <input type="text" class="form-control" name="no_surat" required>
                        </div>


                        <div class="form-group">
                            <label>ISI RINGKASAN</label>
                            <input type="text" class="form-control" name="isi_ringkasan" required>
                        </div>

                        <div class="form-group">
                            <label>ASAL SURAT</label>
                            <input type="text" class="form-control" name="asal" required>
                        </div>


                        <div class="form-group">
                            <label>UPLOAD FILE (PDF, DOCX, XLSX, JPG, PNG)</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>KET.</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
