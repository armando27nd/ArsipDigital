@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Pengguna</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
