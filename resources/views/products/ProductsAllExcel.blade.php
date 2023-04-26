{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--<meta charset="UTF-8">--}}
{{--<meta name="viewport"--}}
{{--content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--<meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--<link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap/dist/css/bootstrap.min.css ')}}">--}}
{{--<!-- Font Awesome -->--}}
{{--<link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css')}} ">--}}
{{--<!-- Ionicons -->--}}
{{--<link rel="stylesheet" href="{{ asset('assets/bower_components/Ionicons/css/ionicons.min.css')}} ">--}}

{{--<title>Product Masuk Exports All PDF</title>--}}
{{--</head>--}}
{{--<body>--}}
<style>
    #products {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #products td, #products th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #products tr:nth-child(even){background-color: #f2f2f2;}

    #products tr:hover {background-color: #ddd;}

    #products th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }
</style>

<table id="products" width="100%">
    <thead>
    <tr>
        <td>ID</td>
        <td>Item</td>
        <td>Qty</td>
        <td>Lokasi</td>
        <td>User</td>
    </tr>
    </thead>
    @foreach($products as $c)
        <tbody>
        <tr>
            <td>{{ $c->id }}</td>
            <td>{{ $c->nama }}</td>
            <td>{{ $c->qty }}</td>
            <td>{{ $c->lokasi->name }}</td>
            <td>{{ $c->user }}</td>
        </tr>
        </tbody>
    @endforeach

</table>




