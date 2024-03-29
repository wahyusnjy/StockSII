@extends('layouts.master')
@section('content')
<link defer rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Add Product In</h3>
    </div>
    <div class="box-body">
        <form method="post"class="form-horizontal" enctype="multipart/form-data" action="{{route('productsIn.store')}}">
            @csrf
            <input type="hidden" id="id" name="id">

                    <div class="box-body">
                        <div class="form-group">
                            <label >Products</label>
                            <select class="form-control select selectpicker" name="product_id" id="product_id" required data-live-search="true">
                                <option selected="selected" value="">-- Choose Product --</option>
                                @foreach ($products as $item)
                                    <option value="{{$item->id}}">{{$item->qrcode}}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Product Supplier</label>
                            <select class="form-control select selectpicker" name="supplier_id" id="supplier_id" required  data-live-search="true">
                                <option selected="selected" value="">-- Choose Supplier --</option>
                                @foreach ($suppliers as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                @endforeach
                            </select>
                            {{-- {!! Form::select('supplier_id', $suppliers, null, ['class' => 'form-control select', 'placeholder' => '-- Choose Supplier --', 'id' => 'supplier_id', 'required']) !!} --}}
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Quantity</label>
                            <input type="text" class="form-control" id="qty" name="qty" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Date</label>
                            <input data-date-format='yyyy-mm-dd' type="date" class="form-control" id="tanggal" name="tanggal"   required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <div class="form-group">
                            <label >Information</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                            <span class="help-block with-errors"></span>
                        </div>

                    </div>
                    <!-- /.box-body -->


            <div class="modal-footer">
                <a href="{{ url()->previous() }}"  type="button" class="btn btn-default pull-left" >Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    @endsection

