<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Promosi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; color: #28a745; }
    </style>
</head>
<body>
    <h1>Laporan Promosi Fruit Station</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jenis Promosi</th>
                <th>Deskripsi</th>
                <th>Jumlah Minimum</th>
                <th>Jumlah Pembelian Minimum</th>
                <th>Persentase Diskon</th>
                <th>Kode Kupon</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($promosis as $index => $promosi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $promosi->produk_id ? $promosi->produk->nama_produk : 'Semua Produk' }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $promosi->type)) }}</td>
                <td>{{ $promosi->description }}</td>
                <td>{{ $promosi->quantity_required ?? '-' }}</td>
                <td>{{ $promosi->minimum_purchase_amount !== null ? 'Rp ' . number_format($promosi->minimum_purchase_amount, 0, ',', '.') : '-' }}</td>
                <td>{{ $promosi->discount_percentage }}%</td>
                <td>{{ $promosi->coupon_code ?? '-' }}</td>
                <td>{{ $promosi->start_date }}</td>
                <td>{{ $promosi->end_date }}</td>
                <td>{{ $promosi->active ? 'Aktif' : 'Tidak Aktif' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
