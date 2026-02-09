<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f3f4f6;
        }

        .text-right {
            text-align: right;
        }

        h2 {
            text-align: center;
            color: #b45309;
        }
    </style>
</head>

<body>
    <h2>Laporan Penjualan Material</h2>
    <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Material</th>
                <th class="text-right">Jumlah</th>
                <th class="text-right">Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $penjualan)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $penjualan->nomor_invoice }}</td>
                    <td>{{ $penjualan->customer }}</td>
                    <td>{{ $penjualan->jenis_material }}</td>
                    <td class="text-right">{{ $penjualan->jumlah }} {{ $penjualan->satuan }}</td>
                    <td class="text-right">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($penjualan->status_bayar) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>