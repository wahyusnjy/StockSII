<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistem Inventory</title>
    <!-- Tell the browser to be responsive to screen width -->

    <style>
        .page-break {
            page-break-after: always;
        }
        .app {
            display: inline-flex;
        }
        .header {
            font-size: 10px;
            font-weight: bold;
            font-family: 'poppins',sans-serif;
        }
        .container {

        width: 100%;
        padding: 5px;
        margin-top: 60px;
        margin-left: 40px;
        max-height: 2pt;
        }

        .badge {
            margin-top: 5px;
            margin-left: 20px;


            width: 5.6cm;
            height: 4cm;
        }
    </style>
    <body>

    <div class="container">
        @php
        $a=1;
        @endphp
        @foreach($product1 as $pr)
        <div class="app">
        <div class="header">
            <p>PT Solusi Intek Indonesia </p>
        </div>
            <div class="badge">
                {!! DNS2D::getBarcodeHTML($pr->product_code, 'QRCODE', 2,2) !!}
                <p class="text" style="margin-top: 2px">( {{$pr->qrcode}} )</p>
            </div>
        </div>

            @php
            $a++;

            @endphp


        @endforeach

    </div>
    </body>
</html
