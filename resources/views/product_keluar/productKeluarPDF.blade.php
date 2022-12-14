<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pengeluaran Barang</title>
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
             <p>Head Office : Emerald Commercial Blok UB No. 50 Summarecon Bekasi <br> Telp. 021-89454790 <br>
            Mkt Office &nbsp;&nbsp; : Jl Tebet Barat dalam raya No. 31 Tebet Barat, Jakarta Selatan, <br>Telp 021-21383852</p>
            </td>
        </tr>
   </table>

   <h5 class="text-center">BUKTI PENGELUARAN BARANG</h5>
   <p style="font-weight: bold">Tanggal: {{ $product_keluar->tanggal }}</p>

   <table border="0" id="table-data" width="100%" class="mt-4">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center"> {{ $product_keluar->id }}</td>
                <td class="text-center"> {{ $product_keluar->qty }}</td>
                <td class="text-center"> {{ $product_keluar->product->nama }}</td>
                <td class="text-center"> {{ $product_keluar->keterangan }}</td>
            </tr>
        </tbody>
    </table>

    <table border="0" id="table-data" width="100%" class="mt-4">
        <tr>
            <td class="text-center" style="font-weight:600;">Yang Memasukan,</td>
            <td class="text-center" style="font-weight:600;">Mengetahui</td>
        </tr>
        <tr aria-rowspan="2">
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td class="text-center">{{ $product_keluar->customer->nama }}</td>
            <td class="text-center">Sindu Irawan</td>
        </tr>
    </table>
        {{-- </table>

        <table border="0" id="table-data" width="80%">
            <tr>
                <td width="70px">Invoice ID</td>
                <td width="">: {{ $product_keluar->id }}</td>
                <td width="30px">Created</td>
                <td>: {{ $product_keluar->tanggal }}</td>
            </tr>

            <tr>
                <td>Telepon</td>
                <td>: {{ $product_keluar->customer->telepon }}</td>
                <td>Alamat</td>
                <td>: {{ $product_keluar->customer->alamat }}</td>
            </tr>

            <tr>
                <td>Nama</td>
                <td>: {{ $product_keluar->customer->nama }}</td>
                <td>Email</td>
                <td>: {{ $product_keluar->customer->email }}</td>
            </tr>

            <tr>
                <td>Product</td>
                <td >: {{ $product_keluar->product->nama }}</td>
                <td>Quantity</td>
                <td >: {{ $product_keluar->qty }}</td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>: {{ $product_keluar->keterangan }}</td>
                <td></td>
                <td></td>
            </tr>

        </table> --}}

        {{--<hr  size="2px" color="black" align="left" width="45%">--}}


        {{-- <table border="0" width="80%">
            <tr align="right">
                <td>Hormat Kami</td>
            </tr>
        </table>

    <table border="0" width="80%">
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
