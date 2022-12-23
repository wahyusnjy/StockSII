@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Products</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('products.update', $producs->id)}}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id">
                <div class="box-body">
                    <div class="form-group">
                        <label >Name</label>
                        <input type="text" class="form-control" value="{{ $producs->nama }}" id="nama" name="nama"  autofocus required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label >Price</label>
                        <input type="text" class="form-control rupiah" value="{{ $producs->harga }}" id="harga" name="harga"   required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label >Quantity</label>
                        <input type="text" class="form-control" value="{{ $producs->qty }}" id="qty" name="qty"   required>
                        <span class="help-block with-errors"></span>
                    </div>


                    <div class="form-group">
                        <label >Image</label>
                        <input type="file" class="form-control" value="{{ $producs->img }}" id="image" name="image" >
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label >Category</label>
                        <select class="form-control select" name="category_id" id="category_id" required>
                            <option selected="selected"  value="{{ $producs->category->id }}"> {{ $producs->category->name }}</option>
                            @foreach ($category as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>

                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label >Lokasi</label>
                        <select class="form-control select" name="lokasi_id"  id="lokasi_id" required>
                            <option selected="selected"  value="{{ $producs->lokasi->id }}">{{ $producs->lokasi->name }}</option>
                            @foreach ($lokasi as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>

                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label >Assets/Inventory</label>
                        <select class="form-control select" name="assets_id" id="assets_id" required>
                            <option selected="selected" value="{{ $producs->assets->id }}">{{ $producs->assets->name }}</option>
                            @foreach ($asset as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>

                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group">
                        <label >User</label>
                        <input type="text" class="form-control" id="user" name="user" value="{{ $producs->user }}" required>
                        <span class="help-block with-errors"></span>
                    </div>

                </div>
                <!-- /.box-body -->

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" >Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(function(){
  $(".rupiah").keyup(function(e){
    $(this).val(format($(this).val()));
  });
});
var format = function(num){
  var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
  if(str.indexOf(".") > 0) {
    parts = str.split(".");
    str = parts[0];
  }
  str = str.split("").reverse();
  for(var j = 0, len = str.length; j < len; j++) {
    if(str[j] != ",") {
      output.push(str[j]);
      if(i%3 == 0 && j < (len - 1)) {
        output.push(",");
      }
      i++;
    }
  }
  formatted = output.reverse().join("");
  return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};
</script>
@endsection
