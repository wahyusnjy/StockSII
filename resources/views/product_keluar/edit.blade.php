@extends('layouts.master')
@section('content')
<link defer rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Product Users</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('productsOut.update', $product_keluar->id)}}">
            @csrf
            @method('PATCH')
            <input type="hidden" id="id" name="id">

                    <div class="box-body">
                        <div class="form-group">
                            <label > Name</label>
                            <input type="text" name="nama_peminjam" class="form-control" value="{{ $product_keluar->nama_peminjam }}">

                            {{-- {!! Form::select('customer_id', $customers, null, ['class' => 'form-control select', 'placeholder' => '-- Choose Customer --', 'id' => 'customer_id', 'required']) !!} --}}
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label >Division</label>
                            <select class="form-control  selectpicker" name="divisi_id" required data-live-search="true">
                                {{-- <option selected="selected" value="">-- Choose Division --</option> --}}
                                @foreach ($divisi as $divisi)
                                @if ($product_keluar->divisi->id == $divisi->id)
                                    <option value="{{ $product_keluar->divisi_id }}">{{ $product_keluar->divisi->name }}</option>
                                @else
                                    <option value="{{$divisi->id}}">{{$divisi->name}}</option>
                                @endif
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label >Products</label>
                            <select class="form-control select selectpicker" name="product_id" id="product_id" required data-live-search="true">
                                <option selected="selected" value="{{ $product_keluar->product->id }}">{{ $product_keluar->product->qrcode }}</option>
                                @foreach ($products as $item)
                                    <option value="{{$item->id}}">{{$item->qrcode}}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Quantity</label>
                            <input type="text" class="form-control" id="qty" value="{{ $product_keluar->qty }}" name="qty" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Region</label>
                            <select class="form-control  selectpicker" name="region_id" data-live-search="true">
                                @if(empty($product_keluar->region_id))
                                <option selected="selected" value="">-- Choose Region --</option>
                                @else
                                <option selected="selected" value="{{ $product_keluar->region_id }}">{{ $product_keluar->region->name }}</option>
                                @endif

                                @foreach ($region as $region)
                                    <option value="{{$region->id}}">{{$region->name}}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Room</label>
                            <select class="form-control  selectpicker" name="room_id" data-live-search="true">=
                                @if(empty($product_keluar->room_id))
                                <option selected="selected" value="">-- Choose Region --</option>
                                @else
                                <option selected="selected" value="{{ $product_keluar->room_id }}">{{ $product_keluar->room->name }}</option>
                                @endif
                                @foreach ($room as $room)
                                    <option value="{{$room->id}}">{{$room->name}}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Rack</label>
                            <select class="form-control  selectpicker" name="rack_id" data-live-search="true">
                                @if(empty($product_keluar->rack_id))
                                <option selected="selected" value="">-- Choose Region --</option>
                                @else
                                <option selected="selected" value="{{ $product_keluar->rack_id }}">{{ $product_keluar->rack->name }}</option>
                                @endif
                                @foreach ($rack as $rack)
                                    <option value="{{$rack->id}}">{{$rack->name}}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Date</label>
                            <input data-date-format='yyyy-mm-dd' type="date" class="form-control" id="tanggal" value="{{ $product_keluar->tanggal }}" name="tanggal"   required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Information</label>
                            <input type="text" class="form-control" id="keterangan" value="{{ $product_keluar->keterangan }}" name="keterangan" required>
                            <span class="help-block with-errors"></span>
                        </div>

                    </div>
                    <!-- /.box-body -->

            </div>

            <div class="modal-footer">
                <a href="{{ url()->previous() }}" type="button" class="btn btn-default pull-left" >Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
