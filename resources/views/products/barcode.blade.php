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
        .container {
            width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .badge {

            display: inline-block;
            margin-left: 2cm;
            padding:10px;


            width: 4cm; /* 1.9 */
            height: 5.7cm;
            /* width: 0.2cm; */
        }
        @media print {
        #printPageButton {
        display: none;
            }
        }
    </style>
    <body>
    <button id="printPageButton" onclick="window.print()"> PRINT </button>
    <div class="container">
        @php
        $a=1;
        @endphp
        @foreach($product as $pr)
            <div class="badge">
                {!! DNS2D::getBarcodeHTML($pr->product_code, 'QRCODE',3,3) !!}
                <p class="text" style="margin-top: 2px">( {{$pr->qrcode}} )</p>
            </div>


            @php
            $a++;

            @endphp
            @if($a%16 == 1)
            <!-- <p>OK</p> -->
            <div class="page-break"></div>
            @endif

        @endforeach

    </div>
    </body>
</html
