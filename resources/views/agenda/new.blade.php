@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Tambah Arsip</div>
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

                    <form action="{{ route('arsip.store') }}" method="post" enctype="multipart/form-data">
                        @csrf



                        <div class="form-group">
                            <label>No./Tgl Surat</label>
                            <select name="disposisi_id" class="form-control" required>
                                <option value="">-- Pilih No./Tgl Surat --</option>
                                @foreach($disposisi as $d)
                                <option value="{{ $d->id }}">{{ $d->no_dan_tanggal  }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jam</label>
                            <input type="time" class="form-control" name="nama_surat" required>
                        </div>

                         <div class="form-group">
                            <label>KEGIATAN</label>
                            <textarea class="form-control" name="kegiatan"></textarea>
                        </div>

                        <div class="form-group">
                            <label>TEMPAT</label>
                            <textarea class="form-control" name="tempat"></textarea>
                        </div>



                        <div class="form-group">
                            <label>PEJABAT YANG HADIR</label>
                            <textarea class="form-control" name="pejabat"></textarea>
                        </div>

                        <div class="form-group">
                            <label>KET.</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                        </div>

                        <!-- <div class="form-group"> -->
                            <!-- <label>TANGGAL</label> -->
                            <!-- <input type="date" class="form-control" name="tanggal" required> -->
                        <!-- </div> -->

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('arsip.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
