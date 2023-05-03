@extends('layouts.master')
@section('content')

<style type="text/css">
    #results { padding:20px; border:1px solid; background:#ccc; }
    .hide-div    {width: 0;height: 0;opacity: 0;display: none;}
</style>
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
                    <div class="row" >
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Name</label>
                                <input type="text" class="form-control
                                @error('nama')
                                is-invalid
                                @enderror" value="{{ $producs->nama }}" id="nama" name="nama"  autofocus required >
                                <span class="help-block with-errors"></span>
                                @error('nama')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
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
                        </div>

                        <div class="col-md-4">
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
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Region</label>
                                <select class="form-control js-example-basic-single
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
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Room</label>
                                <select class="form-control js-example-basic-single
                                @error('room_id')
                                is-invalid
                                @enderror" name="room_id" id="room_id">
                                @if(empty($producs->room_id))
                                    <option selected="selected" value="" disabled>-- Choose Room --</option>
                                    @foreach ($room as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @else
                                    <option selected="selected" value="{{ $producs->room->id }}">{{ $producs->room->name }}</option>
                                    @foreach ($room as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                                </select>

                                <span class="help-block with-errors"></span>
                                @error('room_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Rack</label>
                                <select class="form-control js-example-basic-single
                                @error('rack_id')
                                is-invalid
                                @enderror" name="rack_id" id="rack_id">
                                @if(empty($producs->rack_id))
                                    <option selected="selected" value="" disabled>-- Choose Rack --</option>
                                    @foreach ($rack as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @else
                                    <option selected="selected" value="{{ $producs->rack->id }}">{{ $producs->rack->name }}</option>
                                    @foreach ($rack as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif



                                </select>

                                <span class="help-block with-errors"></span>
                                @error('rack_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Category</label>
                                <select class="form-control js-example-basic-single
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
                        </div>



                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select Method Upload Image</label>
                                <select class="form-control" id="method">
                                    <option value="" selected >Choose Method Upload Image</option>
                                    <option value="normal">Upload Normal</option>
                                    <option value="webcam">Use Webcam</option>
                                </select>
                            </div>
                        </div>

                    <div class=" hide-div normalimage" >
                        <div class="col-md-12">
                            <div class="form-group">
                                <label >Image</label>
                                <input type="file" class="form-control
                                @error('image')
                                is-invalid
                                @enderror" value="{{ $producs->image }}" id="image" name="image" onchange="loadFile(event)">
                                <span class="help-block with-errors"></span>
                                @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            @if(empty($producs->image))
                            <img src="{{ asset('notfoundimage.png') }}" class="result" id="output" class="img-circle" style="max-width: 200px; " alt="">
                            @else
                            <img src="{{ url($producs->image) }}" class="result" id="output" style="max-width: 200px;" />
                            @endif
                        </div>
                    </div>

                    <div class="hide-div webcam_image" id="">
                        <div class="col-md-12">
                            <div id="my_camera"></div>
                            <br/>
                            <input type=button value="Take Snapshot" onClick="take_snapshot()">
                            <input type="hidden" name="image_webcam" class="image-tag" style="opacity: 0;">
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->

            </div>
            <input type="hidden" name="url" value="{{ url()->previous() }}">

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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script>
    $('.js-example-basic-single').select2();
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

<script language="JavaScript">
    Webcam.set({
    width: 300,
    height: 300,
    image_format: 'jpeg',
    jpeg_quality: 90,
    constraints: {
        facingMode: "user"
    }
});

Webcam.attach('#my_camera');

function switch_camera() {
    var facingModes2 = Webcam.params.constraints.facingMode;

    if (facingModes2 == 'environment') {
        facingModes2 = 'user'; //switch ke kamera depan
    } else {
        facingModes2 = 'environment'; //switch ke kamera belakang
    }

    
    Webcam.set({
        width: 300,
        height: 300,
        image_format: 'jpeg',
        jpeg_quality: 90,
        constraints: {
            facingMode: facingModes2
        }
    });
    Webcam.reset();
    console.log(Webcam);
    console.log(Webcam.params.constraints.facingMode);
    Webcam.attach('#my_camera');
}

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.querySelector('.result').src = data_uri;
            Webcam.reset();
        } );
    }
</script>

<script type="text/javascript">
    var methodimage = document.getElementById('method');

    var normalimage = document.querySelector('.normalimage');
    var webcam_image = document.querySelector('.webcam_image');

    methodimage.addEventListener('change', function() {
        if (this.value == "normal") {
            normalimage.classList.remove('hide-div');
        } else {
            normalimage.classList.add('hide-div');
        }
    })

    // Office
    methodimage.addEventListener('change', function() {
        if (this.value == "webcam") {
            webcam_image.classList.remove('hide-div');
        } else {
            webcam_image.classList.add('hide-div');
        }
    })
</script>
@endsection
