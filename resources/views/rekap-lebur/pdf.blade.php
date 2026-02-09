<!DOCTYPE html>
<html>

<head>
    <title>Rekap Lebur</title>
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

        .anomaly {
            background-color: #fee2e2;
            color: #b91c1c;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Laporan Produksi Lebur</h2>
    <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Material</th>
                <th class="text-right">Berat Awal</th>
                <th class="text-right">Berat Hasil</th>
                <th class="text-right">Susut</th>
                <th class="text-right">% Susut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $lebur)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($lebur->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $lebur->jenis_material }}</td>
                    <td class="text-right">{{ number_format($lebur->berat_awal, 2) }}</td>
                    <td class="text-right">{{ number_format($lebur->berat_hasil, 2) }}</td>
                    <td class="text-right">{{ number_format($lebur->susut, 2) }}</td>
                    <td class="text-right {{ $lebur->persentase_susut > 10 ? 'anomaly' : '' }}">
                        {{ number_format($lebur->persentase_susut, 2) }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>