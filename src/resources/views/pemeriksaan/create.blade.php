@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Pemeriksaan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pemeriksaan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="pasien" class="form-label">Pasien</label>
                <select class="form-control" name="pasien" id="pasien" required>
                    <option value="">Select Pasien</option>
                    @foreach ($data['pasien'] as $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                <input type="number" step="0.01" class="form-control" name="tinggi_badan" id="tinggi_badan">
            </div>
            
            <div class="col-md-4 mb-3">
                <label for="berat_badan" class="form-label">Berat Badan</label>
                <input type="number" step="0.01" class="form-control" name="berat_badan" id="berat_badan">
            </div>

            <div class="col-md-4 mb-3">
                <label for="systole" class="form-label">Systole</label>
                <input type="number" step="0.01" class="form-control" name="systole" id="systole">
            </div>

            <div class="col-md-4 mb-3">
                <label for="diastole" class="form-label">Diastole</label>
                <input type="number" step="0.01" class="form-control" name="diastole" id="diastole">
            </div>

            <div class="col-md-4 mb-3">
                <label for="heart_rate" class="form-label">Heart Rate</label>
                <input type="number" step="0.01" class="form-control" name="heart_rate" id="heart_rate">
            </div>

            <div class="col-md-4 mb-3">
                <label for="respiration_rate" class="form-label">Respiration Rate</label>
                <input type="number" step="0.01" class="form-control" name="respiration_rate" id="respiration_rate">
            </div>

            <div class="col-md-4 mb-3">
                <label for="suhu_tubuh" class="form-label">Suhu Tubuh</label>
                <input type="number" step="0.01" class="form-control" name="suhu_tubuh" id="suhu_tubuh">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="pemeriksaan_dokter" class="form-label">Pemeriksaan Dokter</label>
                <textarea id="pemeriksaan_dokter" name="pemeriksaan_dokter" rows="4" class="form-control" placeholder="Enter doctor examination details..."></textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label for="berkas" class="form-label">Berkas</label>
                <input type="file" class="form-control" name="berkas" id="berkas">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        
        $('#pasien').select2({
            tags: true,
            placeholder: "Select Pasien or Add New",
            allowClear: true
        }).on("select2:close", function (e) {
            const selectedValue = $(this).val();
            if (!selectedValue) {
                const newPasien = prompt("Please enter the name of the new pasien:");
                if (newPasien) {
                    const newOption = new Option(newPasien, newPasien, false, true);
                    $(this).append(newOption).trigger('change');
                }
            }
        })
    });
</script>
@endsection
@endsection
