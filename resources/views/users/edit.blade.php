@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Pengguna</h3>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required value="{{ old('username', $user->username) }}">
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label>Password Baru (opsional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
