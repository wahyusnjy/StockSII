<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistem Inventory Barcode</title>
    <!-- Tell the browser to be responsive to screen width -->

    <style>
        .page-break {
            page-break-after: always;
            margin-top: 20px;
        }
        .page-space {
            word-break: break-word;
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
        margin-top: 100px;
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
        $i=0;
        @endphp
        @foreach($product1 as $pr)
        {{-- @php
            $qr = \QrCode::size(100)->generate($pr->product_code);
        @endphp --}}
        <div class="app">
        <div class="header">
            <p>PT Solusi Intek Indonesia </p>
        </div>
            <div class="badge">
                <img src="data:image/png;base64,{!! base64_encode(QrCode::size(80)->generate($pr->product_code)) !!}">
                {{-- {!! QrCode::size(100)->generate($pr->product_code) !!} --}}
                <p class="text" style="margin-top: 2px">( {{$pr->qrcode}} )</p>
                @php
                    $count = $pr->id;
                @endphp
            </div>
         </div>

         @php
         $i++;
     @endphp

     @if($i % 12 == 0 )
     <div class="page-break"></div>
     @endif

        @endforeach

    </div>
    </body>
</html
