@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Agenda</h4>
                </div>
                <div class="card-body">
                    {{-- Menampilkan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Terjadi Kesalahan!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('agenda.update', $agenda->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Kegiatan Asal (Read-only)</label>
                            <p class="form-control-static"><strong>{{ $agenda->disposisi->perihal ?? 'Disposisi tidak ditemukan' }}</strong></p>
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal Pelaksanaan</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $agenda->tanggal) }}" required>

                        </div>

                        <div class="form-group">
                            <label for="kegiatan">Judul Kegiatan Agenda</label>
                            <textarea name="kegiatan" id="kegiatan" class="form-control" rows="3" required>{{ old('kegiatan', $agenda->kegiatan) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam">Jam</label>
                                    <input type="time" name="jam" id="jam" class="form-control" value="{{ old('jam', $agenda->jam) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat">Tempat</label>
                                    <input type="text" name="tempat" id="tempat" class="form-control" value="{{ old('tempat', $agenda->tempat) }}" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pejabat">Pejabat yang Hadir</label>
                                    <textarea name="pejabat" id="pejabat" class="form-control" rows="5" required>{{ old('pejabat', $agenda->pejabat) }}</textarea>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="5">{{ old('keterangan', $agenda->keterangan) }}</textarea>
                                    <!-- <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan', $agenda->keterangan) }}"> -->
                                </div>
                            </div>

                        </div>





                        <hr>

                        <button type="submit" class="btn btn-primary">Update Agenda</button>
                        <a href="{{ route('agenda.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
