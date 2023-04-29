@extends('layouts.master')
@section('content')
<link defer rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Room</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('ruangan.update', $ruangan->id)}}">
            @csrf
            @method('PATCH')
            <div class="box-body">
                <div class="form-group">
                    <label >Region</label>
                    <select class="form-control  selectpicker" name="region_id" required data-live-search="true">
                        @if(empty($ruangan->region_id))
                        @foreach ($wilayah as $w)
                            <option value="{{$w->id}}">{{$w->name}} - {{ $w->desc }}</option>
                        @endforeach
                        @else
                        <option selected="selected" value="{{ $ruangan->region_id }}">{{ $ruangan->region->name }}</option>
                        @foreach ($wilayah as $w)
                            <option value="{{$w->id}}">{{$w->name}} - {{ $w->desc }}</option>
                        @endforeach
                        @endif

                    </select>
                    <span class="help-block with-errors"></span>
                </div>
                <div class="form-group">
                    <label >Room</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $ruangan->name }}"  autofocus required>
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
