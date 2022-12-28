@extends('layouts.master')
@section('content')
<link defer rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Products Out</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('productsIn.update', $product_masuk->id)}}">
            @csrf
            @method('PATCH')
            <input type="hidden" id="id" name="id">

                    <div class="box-body">
                        <div class="form-group">
                            <label >Products</label>
                            <select class="form-control select selectpicker" name="product_id" id="product_id" required data-live-search="true">
                                <option selected="selected" value="{{ $product_masuk->product->id }}">{{ $product_masuk->product->qrcode }}</option>
                                @foreach ($products as $item)
                                    <option value="{{$item->id}}">{{$item->qrcode}}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Suppliers</label>
                            <select class="form-control select selectpicker" name="supplier_id" id="supplier_id" required data-live-search="true">
                                <option selected="selected" value="{{ $product_masuk->supplier->id }}">{{ $product_masuk->supplier->nama }}</option>
                                @foreach ($suppliers as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                @endforeach
                            </select>

                            {{-- {!! Form::select('customer_id', $customers, null, ['class' => 'form-control select', 'placeholder' => '-- Choose Customer --', 'id' => 'customer_id', 'required']) !!} --}}
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Quantity</label>
                            <input type="text" class="form-control" id="qty" value="{{ $product_masuk->qty }}" name="qty" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Date</label>
                            <input data-date-format='yyyy-mm-dd' type="date" class="form-control" id="tanggal" value="{{ $product_masuk->tanggal }}" name="tanggal"   required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" value="{{ $product_masuk->keterangan }}" name="keterangan" required>
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
