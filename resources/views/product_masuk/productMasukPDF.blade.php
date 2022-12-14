<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Product Masuk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
    #table-data {
        border-collapse: collapse;
        padding: 3px;
    }

    #table-data td, #table-data th {
        border: 1px solid black;
    }
</style>

<body>
<div class="invoice-box">
    <table width="120%">
        <tr>
            <td valign="top" style="padding-right: 2px;"><img src="{{ public_path('assets/LogoSII.png') }}" alt="" width="90"> </td>
            <td valign="top"> <h5>PT.SOLUSI INTEK INDONESIA</h5>
                <p>Head Office &nbsp; &nbsp; &nbsp; &nbsp;: Jl Cikunir Raya No.689 Jakamulya, Bekasi Selatan,
                   <br> Telp. 021-89454790 <br>
                    Marketing Office : Jl Tebet Barat dalam raya No.31 Tebet Barat, Jakarta Selatan,<br>
                    Telp. 021-21383852</p>
            </td>
        </tr>
   </table>

   <h5 class="text-center mt-4">BUKTI PEMASUKAN BARANG</h5>
   <p style="font-weight:bold">Tanggal : {{  $product_masuk->tanggal }}</p>

    <table border="0" id="table-data" width="100%" class="mt-4">
        <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Quantity</th>
            <th class="text-center">Nama Barang</th>
            <th class="text-center">Kategori Barang</th>
            <th class="text-center">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center"> {{ $product_masuk->id }}</td>
            <td class="text-center"> {{ $product_masuk->qty }}</td>
            <td class="text-center"> {{ $product_masuk->product->nama }}</td>
            <td class="text-center"> {{ $product_masuk->product->category->name }}</td>
            <td class="text-center"> {{ $product_masuk->keterangan }}</td>
        </tr>
    </tbody>
    </table>


    <table border="0" id="table-data" width="100%" class="mt-4">
        <tr>
            <td class="text-center" style="font-weight:600;">Yang Memasukan,</td>
            <td class="text-center" style="font-weight:600;">Mengetahui</td>
        </tr>
        <tr>
            <td><br><br><br></td>
            <td><br><br><br></td>
        </tr>
        <tr>
            <td class="text-center">{{ $product_masuk->supplier->nama }}</td>
            <td class="text-center">Sindu Irawan</td>
        </tr>
    </table>

    {{-- <table border="0" width="80%">
        <tr align="right">
            <td><img src="https://upload.wikimedia.org/wikipedia/en/f/f4/Timothy_Spall_Signature.png" width="100px" height="100px"></td>
        </tr>

    </table>
    <table border="0" width="80%">
        <tr align="right">
            <td>Sheptian Bagja Utama</td>
        </tr>
    </table> --}}
</div>
