@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Edit Arsip</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/surat-keluar/update/'.$surat_keluar->id_sk) }}"
                        enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label>KODE KLASIFIKASI</label>
                            <input type="date" name="kode_klasifikasi" class="form-control" value="{{$surat_keluar->kode_klarifikasi}}" required>
                        </div>

                        <div class="form-group">
                            <label>TANGGAL</label>
                            <input type="date" name="tanggal" class="form-control" value="{{$surat_keluar->tanggal}}" required>
                        </div>

                        <div class="form-group">
                            <label>NOMOR SURAT</label>
                            <input type="text" name="no_surat" class="form-control" value="{{ $surat_keluar->nama_surat }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label>ISI RINGKASAN</label>
                            <input type="text" name="isi_ringkasan" class="form-control" Required>
                        </div>

                        <div class="form-group">
                            <label>ASAL SURAT</label>
                            <input type="text" name="asal" class="form-control" Required>
                        </div>

                        <div class="form-group">
                            <label>FILE SURAT (biarkan kosong jika tidak diubah)</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label>KET.</label>
                            <textarea name="keterangan" class="form-control">{{ $surat_keluar->keterangan }}</textarea>
                        </div>



                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ url('/surat-keluar') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
