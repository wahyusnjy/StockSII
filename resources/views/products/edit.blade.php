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
                        <input type="text" class="form-control
                        @error('nama')
                        is-invalid
                        @enderror" value="{{ $producs->nama }}" id="nama" name="nama"  autofocus required>
                        <span class="help-block with-errors"></span>
                        @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label >Price</label>
                        <input type="text" class="form-control rupiah
                        @error('harga')
                        is-invalid
                        @enderror" value="{{ $producs->harga }}" id="harga" name="harga"   required>
                        <span class="help-block with-errors"></span>
                        @error('harga')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label >Quantity</label>
                        <input type="number" class="form-control
                        @error('qty')
                        is-invalid
                        @enderror" value="{{ $producs->qty }}" id="qty" name="qty"   required>
                        <span class="help-block with-errors"></span>
                        @error('qty')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label >Image</label>
                        <input type="file" class="form-control
                        @error('image')
                        is-invalid
                        @enderror" value="{{ $producs->image }}" id="image" name="image" onchange="loadFile(event)">
                        <span class="help-block with-errors"></span>
                        @if(empty($producs->image))
                        <img src="{{ asset('notfoundimage.png') }}" id="output" class="img-circle" style="max-width: 150px; " alt="">
                        @else
                        <img src="{{ url($producs->image) }}" id="output" style="max-width: 150px;" />
                        @endif
                        <img id="output" style="max-width: 200px;" />
                        @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label >Category</label>
                        <select class="form-control select
                        @error('category_id')
                        is-invalid
                        @enderror" name="category_id" id="category_id" required>
                            <option selected="selected"  value="{{ $producs->category->id }}"> {{ $producs->category->name }}</option>
                            @foreach ($category as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                        @error('category_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label >Lokasi</label>
                        <select class="form-control select
                        @error('lokasi_id')
                        is-invalid
                        @enderror" name="lokasi_id"  id="lokasi_id" required>
                            <option selected="selected"  value="{{ $producs->lokasi->id }}">{{ $producs->lokasi->name }}</option>
                            @foreach ($lokasi as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>

                        <span class="help-block with-errors"></span>
                        @error('lokasi_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label >Assets/Inventory</label>
                        <select class="form-control select
                        @error('assets_id')
                        is-invalid
                        @enderror" name="assets_id" id="assets_id" required>
                            <option selected="selected" value="{{ $producs->assets->id }}">{{ $producs->assets->name }}</option>
                            @foreach ($asset as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                        @error('assets_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label >User</label>
                        <input type="text" class="form-control
                        @error('user')
                        is-invalid
                        @enderror" id="user" name="user" value="{{ $producs->user }}" required>
                        <span class="help-block with-errors"></span>
                        @error('user')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <!-- /.box-body -->

            </div>

            <div class="modal-footer">
                <a href="{{ route('products.index') }}" type="button" class="btn btn-default pull-left" >Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var rupiah = document.querySelectorAll(".rupiah");
        rupiah.forEach((item) => {
            item.addEventListener('keyup', function(e) {
                // tambahkan 'Rp.' pada saat form di ketik
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                item.value = formatRupiah(this.value, "");
            });
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, ""),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }
            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? " " + rupiah : "";
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var loadFile = function(event) {
        var output = document.getElementById('output');

        if (output === null) {
            output.src = "Image Not Found";
        } else {
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    };
</script>
@endsection
