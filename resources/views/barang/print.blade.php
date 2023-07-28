<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Barang</title>
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
    <h3><b>Data Barang</b></h3>
    <table>
        <thead>
            <th style="width: 5%">ID</th>
            <th style="width: 20%">Nama Barang</th>
            <th style="width: 15%">Harga Beli</th>
            <th style="width: 15%">Harga Jual</th>
            <th style="width: auto">Deskripsi</th>
        </thead>
        <tbody>
            @foreach ($barang as $item)
            <tr>
                <td data-column="ID">{{ $item->id }}</td>
                <td data-column="Nama Barang">{{ $item->nama }}</td>
                <td data-column="Harga Beli">Rp.{{ number_format($item->harga_beli) }}</td>
                <td data-column="Harga Jual">Rp.{{ number_format($item->harga_jual) }}</td>
                <td data-column="Deskripsi">{{ $item->deskripsi }}</td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</body>
</html>