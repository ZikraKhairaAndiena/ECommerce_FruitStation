<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; color: #28a745; margin-bottom: 5px; }
        .header p { text-align: center; font-size: 14px; color: #555; margin: 0; }
        .text-right { text-align: right; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Pembayaran Fruit Station</h1>
        <p>Periode: {{ request('bulan') ? DateTime::createFromFormat('!m', request('bulan'))->format('F') : 'Semua Bulan' }} {{ request('tahun') ?? 'Semua Tahun' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Nama Produk</th>
                <th>Nama Penyetor</th>
                <th>Bank</th>
                <th>Jumlah Pembayaran</th>
                <th>Tanggal Pembayaran</th>
                <th>Alamat Pengiriman</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayarans as $index => $pembayaran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pembayaran->pembelian->user->name ?? '-' }}</td>
                <td>
                    <ul>
                        @foreach ($pembayaran->pembelian->pembelianproduks as $produk)
                            <li>{{ $produk->nama_produk }} - Jumlah: {{ $produk->jumlah_produk }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $pembayaran->nama_penyetor }}</td>
                <td>{{ $pembayaran->bank }}</td>
                <td>Rp {{ number_format($pembayaran->jumlah, 2, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('Y-m-d') }}</td>
                <td>{{ $pembayaran->pembelian->alamat_pengiriman ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right">
        <h3>Total Pemasukan: Rp {{ number_format($total_pemasukan, 2, ',', '.') }}</h3>
    </div>
</body>
</html>
