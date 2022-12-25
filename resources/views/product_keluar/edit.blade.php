@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Supplier</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('productsOut.update', $product_keluar->id)}}">
            @csrf
            @method('PATCH')
            <input type="hidden" id="id" name="id">

                    <div class="box-body">
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
                            <label >Customer</label>
                            <select class="form-control select selectpicker" name="customer_id" id="customer_id" required data-live-search="true">
                                <option selected="selected" value="{{ $product_keluar->customer->id }}">{{ $product_keluar->customer->nama }}</option>
                                @foreach ($customers as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                @endforeach
                            </select>

                            {{-- {!! Form::select('customer_id', $customers, null, ['class' => 'form-control select', 'placeholder' => '-- Choose Customer --', 'id' => 'customer_id', 'required']) !!} --}}
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Quantity</label>
                            <input type="text" class="form-control" id="qty" value="{{ $product_keluar->qty }}" name="qty" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Date</label>
                            <input data-date-format='yyyy-mm-dd' type="date" class="form-control" id="tanggal" value="{{ $product_keluar->tanggal }}" name="tanggal"   required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" value="{{ $product_keluar->keterangan }}" name="keterangan" required>
                            <span class="help-block with-errors"></span>
                        </div>

                    </div>
                    <!-- /.box-body -->

            </div>

            <div class="modal-footer">
                <a href="{{ route('suppliers.index') }}" type="button" class="btn btn-default pull-left" >Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
</div>
@endsection
