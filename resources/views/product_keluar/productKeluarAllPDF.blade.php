<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    #product-masuk {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #product-masuk td, #product-masuk th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #product-masuk tr:nth-child(even){background-color: #f2f2f2;}

    #product-masuk tr:hover {background-color: #ddd;}

    #product-masuk th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>

<table width="120%">
    <tr>
        <td valign="top" style="padding-right: 2px;"><img src="{{ public_path('assets/LogoSII.png') }}" alt="" width="90"> </td>
        <td valign="top"> <h5>PT.SOLUSI INTEK INDONESIA</h5>
         <p>Head Office : Emerald Commercial Blok UB No. 50 Summarecon Bekasi <br> Telp. 021-89454790 <br>
        Mkt Office &nbsp;&nbsp; : Jl Tebet Barat dalam raya No. 31 Tebet Barat, Jakarta Selatan, <br>Telp. 021-21383852</p>
        </td>
    </tr>
</table>

<h5 class="text-center mt-4">BUKTI PENGELUARAN BARANG</h5>

<table id="product-masuk" width="100%">
    <thead>
    <tr>
        <td>ID</td>
        <td>Product</td>
        <td>Customer</td>
        <td>Quantity</td>
        <td>Date</td>
    </tr>
    </thead>
    @foreach($product_keluar as $p)
        <tbody>
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->product->nama }}</td>
            <td>{{ $p->customer->nama }}</td>
            <td>{{ $p->qty }}</td>
            <td>{{ $p->tanggal }}</td>
        </tr>
        </tbody>
    @endforeach

</table>


