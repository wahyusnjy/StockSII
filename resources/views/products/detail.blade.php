@extends('layouts.master')
<style>
    #products-table{
        max-width: 500px;
    }
    td.dt-nowrap { white-space: nowrap }
</style>

@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <h2>Detail Product</h2>
    <div class="box">
        <table class="table table-bordered mt-4">
            <tbody>
                <tr>
                    <td>QR Code</td>
                    <td>{!! QrCode::size(100)->generate($producs->product_code)!!}
                        <p style="margin-top: 20px;">{{ $producs->qrcode }}</p>
                    </td>

                </tr>
                <tr>
                    <td>Barcode Code</td>
                    <td>
                        {!! DNS1D::getBarcodeSVG($producs->qrcode, 'C128', true) !!}
                    </td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>{{ $producs->nama }}</td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>{{ number_format($producs->harga) }}</td>
                </tr>
                <tr>
                    <td>QTY</td>
                    <td>{{ $producs->qty }}</td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td>
                        @if($producs->image == NULL)
                        <p>No Image</p>
                        @else
                        <a href="{{ url($producs->image) }}"  target="_blank"><img src="{{ url($producs->image) }}" width="400"></a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Region</td>
                    <td>{{ $producs->category->name }}</td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td>{{ $producs->lokasi->name }}</td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                        @if($producs->assets->parent_id == 0)
                        {{ $producs->assets->name}}
                        @else
                        {{ $producs->assets->parent->name }} - {{ $producs->assets->name }}
                        @endif
                        {{-- {{ $producs->assets->name }} --}}
                    </td>
                </tr>

                @if(empty($producs->room->name))

                @else
                <tr>
                    <td>Room</td>
                    <td>{{ $producs->room->name }}</td>
                </tr>
                @endif

                @if(empty($producs->rack->name))

                @else
                <tr>
                    <td>Rack</td>
                    <td>{{ $producs->rack->name }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-danger">Back</a>

@endsection
