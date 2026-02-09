<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kas</title>
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

        .green {
            color: green;
        }

        .red {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Laporan Kas</h2>
    <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>

    <div style="margin-bottom: 20px">
        <strong>Saldo Akhir: Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th class="text-right">Masuk (In)</th>
                <th class="text-right">Keluar (Out)</th>
                <th class="text-right">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $kas)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $kas->kategori }}</td>
                    <td>{{ $kas->keterangan }}</td>
                    <td class="text-right green">{{ $kas->jenis == 'in' ? number_format($kas->jumlah) : '-' }}</td>
                    <td class="text-right red">{{ $kas->jenis == 'out' ? number_format($kas->jumlah) : '-' }}</td>
                    <td class="text-right">{{ number_format($kas->saldo) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>