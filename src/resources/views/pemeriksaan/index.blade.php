@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pemeriksaan</h1>
    
    <form action="{{ route('pemeriksaan.index') }}" method="GET" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-2" placeholder="Search Pasien" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <a href="{{ route('pemeriksaan.create') }}" class="btn btn-primary">Add Pemeriksaan</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Tinggi Badan</th>
                    <th>Berat Badan</th>
                    <th>Systole</th>
                    <th>Diastole</th>
                    <th>Heart Rate</th>
                    <th>Respiration Rate</th>
                    <th>Suhu Tubuh</th>
                    <th>Pemeriksaan Dokter</th>
                    <th>Berkas</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemeriksaan as $data)
                <tr>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->tinggi_badan }} </td>
                    <td>{{ $data->berat_badan }} </td>
                    <td>{{ $data->systole }} </td>
                    <td>{{ $data->diastole }} </td>
                    <td>{{ $data->heart_rate }} </td>
                    <td>{{ $data->respiration_rate }} </td>
                    <td>{{ $data->suhu_tubuh }} </td>
                    <td>{{ $data->pemeriksaan_dokter }} </td>
                    <td><a href="{{ asset('storage/' . $data->berkas) }}" target="_blank">Download Berkas</a> </td>
                    <td>{{ $data->created_at }} </td>
                    <td>{{ $data->updated_at }} </td>
                    <td>
                        <a href="{{ route('pemeriksaan.edit', $data->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('resep.show', $data->id) }}" class="btn btn-info">Resep</a>
                        <form action="{{ route('pemeriksaan.destroy', $data->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $pemeriksaan->links() }}
</div>
@endsection
