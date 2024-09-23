@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Tambah Resep</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('resep.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="pasien" class="form-label">Pasien</label>
                <input type="text" class="form-control" value="{{ $data['pasien']->name }}" name="Pasien" id="Pasien" disabled>
                <input type="hidden" class="form-control" value="{{ $data['pemeriksaan_id'] }}" name="pemeriksaan_id" id="pemeriksaan_id">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="pasien" class="form-label">Pemeriksaan id</label>
                <input type="text" class="form-control" value="{{ $data['pemeriksaan_id'] }}" name="pemeriksaan_id" id="pemeriksaan_id" disabled>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
            <label for="obat_id" class="form-label">obat</label>
                <select id="obat_id" name='obat_id' style="width: 100%;"></select>
                <input type="hidden" class="form-control" name="obat_name" id="obat_name">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="obat_price" class="form-label">Price</label>
                <input type="text" class="form-control" name="v_obat_price" id="v_obat_price" disabled>
                <input type="hidden" class="form-control" name="obat_price" id="obat_price">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="jumlah" class="form-label">jumlah</label>
                <input type="text" class="form-control" name="jumlah" id="jumlah">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
    </form>
    <br>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>obat id</th>
                    <th>obat name</th>
                    <th>obat price</th>
                    <th>jumlah</th>
                    <th>status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['resep'] as $value)
                <tr>
                    <td>{{ $value->obat_id }}</td>
                    <td>{{ $value->obat_name }} </td>
                    <td>{{ number_format($value->obat_price, 2, ',', '.') }} </td>
                    <td>{{ $value->jumlah }} </td>
                    <td>{{ $value->status }} </td>
                    <td>
                        <!-- Trigger Modal -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                            data-id="{{ $value->id }}" 
                            data-pemeriksaan_id="{{ $value->pemeriksaan_id }}" 
                            data-obat_id="{{ $value->obat_id }}"
                            data-obat_name="{{ $value->obat_name }}"
                            data-obat_price="{{ $value->obat_price }}"
                            data-jumlah="{{ $value->jumlah }}">Edit</button>
                            <form action="{{ route('resep.delete', $value->id) }}" method="POST" style="display:inline;">
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
    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="{{ route('resep.export-pdf', $value['pemeriksaan_id'] ) }}" class="btn btn-primary">Export as PDF</a>
        </div>
    </div>
    <br>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Resep</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="mb-3">
                <label for="edit_obat_id" class="form-label">Obat</label>
                <select id="edit_obat_id" name='obat_id' style="width: 100%;"></select>
                <input type="hidden" class="form-control" id="edit_obat_name" name="obat_name">
            </div>
            <div class="mb-3">
                <label for="edit_obat_price" class="form-label">Price</label>
                <input type="text" class="form-control" id="edit_obat_price_v" name="obat_price_v" disable>
                <input type="hidden" class="form-control" id="edit_obat_price" name="obat_price" >
            </div>
            <div class="mb-3">
                <label for="edit_jumlah" class="form-label">Jumlah</label>
                <input type="text" class="form-control" id="edit_jumlah" name="jumlah" required>
                <input type="hidden" class="form-control" id="edit_pemeriksaan_id" name="pemeriksaan_id" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
    @php
    $apiToken = session('api_token');
    @endphp

    @if ($apiToken)
        
    @else
    alert("API http://recruitment.rsdeltasurya.com/api/v1/medicines ERROR");
    @endif

    var editModal = document.getElementById('editModal')
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var id = button.getAttribute('data-id')
        var obat_id = button.getAttribute('data-obat_id')
        var pemeriksaan_id = button.getAttribute('data-pemeriksaan_id')
        var obat_name = button.getAttribute('data-obat_name')
        var obat_price = button.getAttribute('data-obat_price')
        var jumlah = button.getAttribute('data-jumlah')

        var modalTitle = editModal.querySelector('.modal-title')
        var form = editModal.querySelector('#editForm')
        var inputObatId = editModal.querySelector('#edit_obat_id')
        var inputObatPemeriksaanId = editModal.querySelector('#edit_pemeriksaan_id')
        var inputObatName = editModal.querySelector('#edit_obat_name')
        var inputObatPrice = editModal.querySelector('#edit_obat_price')
        var inputJumlah = editModal.querySelector('#edit_jumlah')

        modalTitle.textContent = 'Edit Resep ID ' + id
        form.action = '/resep/' + id
        inputObatId.value = obat_id
        inputObatPemeriksaanId.value = pemeriksaan_id
        inputObatName.value = obat_name
        inputObatPrice.value = obat_price
        inputJumlah.value = jumlah
        setTimeout(function () {
            $('#edit_obat_id').val(obat_id).trigger('change');
        }, 500);  // Adjust the delay as necessary
        
    })
</script>

<script>
$(document).ready(function() {
    $('#obat_id').select2({
        placeholder: 'Select obat',
        ajax: {
            delay: 250,
            url: 'http://recruitment.rsdeltasurya.com/api/v1/medicines',
            headers: {
                'Authorization': 'Bearer {{ $apiToken }}'
            },
            processResults: function(data) {
                return {
                    results: $.map(data.medicines, function(item) {
                        return {
                            id: item.id,
                            text: item.name
                        };
                    })
                };
            },
            cache: true
        }
    });

    $('#edit_obat_id').select2({
        placeholder: 'Select obat',
        dropdownParent: $("#editModal"),
        data: [
            @foreach ($data['obat'] as $obat)
                { id: '{{ $obat['id'] }}', text: '{{ $obat['name'] }}' },
            @endforeach
        ]
    });

    $('#obat_id').on('change', function() {
        var medicineId = $(this).val();
        if (medicineId) {
            fetchPrices(medicineId,'create');
        }
        $('#obat_name').val($(this).select2('data')[0].text);
    });
    $('#edit_obat_id').on('change', function () {
        fetchPrices(obat_id, 'edit');
    });
});

function fetchPrices(medicineId,from) {
        $.ajax({
            url: 'http://recruitment.rsdeltasurya.com/api/v1/medicines/' + medicineId + '/prices',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer {{ $apiToken }}'
            },
            success: function(data) {
                displayCurrentPrice(data.prices,from);
            },
            error: function(xhr) {
                console.error('Error fetching prices:', xhr);
            }
        });
    }

    function displayCurrentPrice(prices,from) {
        const today = new Date();        
        const formattedToday = today.toISOString().split('T')[0];
        const currentPrice = prices.find(price => {
        const startDate = new Date(price.start_date.value);
        const endDate = price.end_date.value ? new Date(price.end_date.value) : new Date();

            return today >= startDate && today <= endDate;
        });

        if (currentPrice) {
            if (from === 'create') {
                $('#v_obat_price').val(currentPrice.unit_price);
                $('#obat_price').val(currentPrice.unit_price);
            }else{
                $('#edit_obat_price_v').val(currentPrice.unit_price);
                $('#edit_obat_price').val(currentPrice.unit_price);
            }
        } else {
            
        }
    }
</script>

@endsection
