@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Input Agenda</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('/agenda/update/'.$agenda->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        {{ method_field('PUT') }}

                        <input type="hidden" name="disposisi_id" value="{{ $disposisi->id }}">

                        <div class="form-group">
                            <label for="kegiatan">Kegiatan</label>
                            <textarea name="kegiatan" id="kegiatan" class="form-control" rows="3" required>{{ old('kegiatan', $disposisi->perihal) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jam">Jam</label>
                                    <input type="time" name="jam" id="jam" class="form-control" value="{{ old('jam') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat">Tempat</label>
                                    <input type="text" name="tempat" id="tempat" class="form-control" value="{{ old('tempat') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="pejabat">Pejabat yang Hadir</label>
                            <input type="text" name="pejabat" id="pejabat" class="form-control" value="{{ old('pejabat', $disposisi->diteruskan) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan (Opsional)</label>
                            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ old('keterangan') }}">
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary">Simpan Agenda</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                    </form>eb
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
