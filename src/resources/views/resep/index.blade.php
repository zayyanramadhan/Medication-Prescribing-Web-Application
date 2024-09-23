@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resep</h1>
    
    <form action="{{ route('resep.index') }}" method="GET" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search Pasien" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Pemeriksaan id</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resep as $data)
                <tr>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->id }} </td>
                    <td>{{ $data->status }} </td>
                    <td>{{ $data->created_at }} </td>
                    <td>{{ $data->updated_at }} </td>
                    <td>
                        <a href="{{ route('resep.show', $data->id) }}" class="btn btn-warning">show</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $resep->links() }}
</div>
@endsection
