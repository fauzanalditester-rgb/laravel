<!DOCTYPE html>
<html>

<head>
    <title>Rekap Timbangan - ERP System</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        h2 {
            text-align: center;
            color: #b45309;
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
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2>Laporan Rekap Timbangan</h2>
    <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kendaraan</th>
                <th>Material</th>
                <th class="text-right">Masuk</th>
                <th class="text-right">Keluar</th>
                <th class="text-right">Bersih</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $record->nomor_kendaraan }}</td>
                    <td>{{ $record->jenis_material }}</td>
                    <td class="text-right">{{ $record->berat_masuk }}</td>
                    <td class="text-right">{{ $record->berat_keluar }}</td>
                    <td class="text-right">{{ $record->berat_bersih }}</td>
                    <td>{{ $record->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>