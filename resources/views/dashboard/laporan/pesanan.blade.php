<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pesanan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header p { text-align: center; font-size: 14px; color: #555; margin: 0; }
        h1 { text-align: center; color: #28a745; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Pesanan Fruit Station</h1>
        <p>Periode: {{ request('bulan') ? DateTime::createFromFormat('!m', request('bulan'))->format('F') : 'Semua Bulan' }} {{ request('tahun') ?? 'Semua Tahun' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Ongkir</th>
                <th>Tanggal Pembelian</th>
                <th>Total Pembelian</th>
                <th>Alamat Pengiriman</th>
                <th>Status Pembelian</th>
                <th>Resi Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanans as $pesanan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pesanan->user->name }}</td>
                <td>Rp {{ number_format($pesanan->ongkir->tarif, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pembelian)->format('Y-m-d') }}</td>
                <td>Rp {{ number_format($pesanan->total_pembelian, 2, ',', '.') }}</td>
                <td>{{ $pesanan->alamat_pengiriman }}</td>
                <td>{{ ucfirst($pesanan->status_pembelian) }}</td>
                <td>{{ $pesanan->resi_pengiriman ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
