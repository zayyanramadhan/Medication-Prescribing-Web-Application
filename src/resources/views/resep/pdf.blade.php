<!DOCTYPE html>
<html>
<head>
    <title>Resi Resep</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Resi Resep</h1>
    <h2>Pasien : {{ $pasien->name }}</h2>
    <table>
        <thead>
            <tr>
                <th>Obat ID</th>
                <th>Obat Name</th>
                <th>Obat Price</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $total=0; @endphp
            @foreach ($resep as $data)
            @php $total+=$data->total_price; @endphp
            <tr>
                <td>{{ $data->obat_id }}</td>
                <td>{{ $data->obat_name }}</td>
                <td>{{ number_format($data->obat_price, 2, ',', '.') }}</td>
                <td>{{ $data->jumlah }}</td>
                <td>{{ $data->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Total Pembayaran : Rp. {{ number_format($total, 2, ',', '.') }}</h3>
</body>
</html>
