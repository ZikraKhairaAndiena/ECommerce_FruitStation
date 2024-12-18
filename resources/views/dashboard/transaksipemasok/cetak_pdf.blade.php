<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Pemasok</title>
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
        <h1>Laporan Transaksi Pemasok Fruit Station</h1>
        <p>Periode:
            {{ $bulan ? \Carbon\Carbon::createFromFormat('m', $bulan)->format('F') : 'Semua Bulan' }}
            {{ $tahun ?? 'Semua Tahun' }}
        </p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pemasok</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transaksi->pemasok->nama_pemasok }}</td>
                <td>{{ $transaksi->produk->nama_produk }}</td>
                <td>{{ $transaksi->jumlah }}</td>
                <td>{{ 'Rp ' . number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                <td>{{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
