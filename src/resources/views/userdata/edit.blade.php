@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('userdata.update', $userData->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $userData->name }}">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" value="{{ $userData->username }}">
        </div>
        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select class="form-control" name="level" id="level" required>
                <option value="">Select Level</option>
                <option value="admin" {{ $userData->level == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="dokter" {{ $userData->level == 'dokter' ? 'selected' : '' }}>Dokter</option>
                <option value="apoteker" {{ $userData->level == 'apoteker' ? 'selected' : '' }}>Apoteker</option>
                <option value="pasien" {{ $userData->level == 'pasien' ? 'selected' : '' }}>Pasien</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password">
            <small class="form-text text-muted">Leave blank to keep current password.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
