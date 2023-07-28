<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data input Stock</title>
    <style>
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
        }
        tr:nth-of-type(odd) {
            background: #e3e3e3;
        }
        th {
            background: #107c41;
            font-weight: bold;
            border-top: 1px solid black;
            color: white;
        }

        td, 
        th {
            padding: 3;
            border-bottom: 1px solid #cccccc;
            text-align: left;
            font-size: 10px;
            word-wrap: break-word;
        }

    </style>
</head>
<body>
    <h3><b>Data Input Stock</b></h3>
    <table>
        <thead>
            <th style="width: 8%">ID Stock</th>
            <th style="width: 20%">Tanggal Input</th>
            <th style="width: auto">Nama dan ID Barang</th>
            <th style="width: 10%">Jumlah</th>
            <th style="width: 10%">Jenis</th>
        </thead>
        <tbody>
            @foreach ($stock as $item)
            <tr>
                <td data-column="ID Stock">{{ $item->id }}</td>
                <td data-column="Tanggal Input">{{ ($item->created_at)->format('d-m-Y, h:i:s A') }}</td>
                <td data-column="Nama dan ID Barang">{{ $item->barang->nama }} ({{ $item->barang_id }})</td>
                <td data-column="Jumlah">{{ number_format($item->jumlah) }}</td>
                <td data-column="Jenis">{{ ($item->jenis) ? 'Masuk' : 'Keluar' }}</td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</body>
</html>