<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk</title>
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
    <h1>Laporan Produk Fruit Station</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk ID</th>
                <th>Kategori</th>
                <th>Nama Produk</th>
                <th>Stok Produk</th>
                <th>Satuan</th>
                <th>Harga Produk</th>
                <th>Deskripsi Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produks as $produk)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $produk->produk_id }}</td>
                <td>{{ $produk->kategori->nama_kategori }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td>{{ $produk->stok_produk }}</td>
                <td>{{ $produk->satuan }}</td>
                <td>Rp {{ number_format($produk->harga_produk, 2, ',', '.') }}</td>
                <td>{{ $produk->deskripsi_produk }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
