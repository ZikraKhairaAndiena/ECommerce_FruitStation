<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Daftar Pemasok</title>
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
    <h1 class="text-center">Laporan Pemasok Fruit Station</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No Telepon</th>
                <th>No Rekening</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemasoks as $pemasok)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pemasok->nama_pemasok }}</td>
                <td>{{ $pemasok->no_telepon ?? '-' }}</td>
                <td>{{ $pemasok->no_rekening ?? '-' }}</td>
                <td>{{ $pemasok->alamat ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
