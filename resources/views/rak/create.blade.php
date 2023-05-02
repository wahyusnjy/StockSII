@extends('layouts.master')
@section('content')
<link defer rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Add Rak</h3>
    </div>
    <div class="box-body">
        <form method="post"class="form-horizontal" enctype="multipart/form-data" action="{{route('rak.store')}}">
            @csrf
            <input type="hidden" id="id" name="id">


            <div class="box-body">
                <div class="form-group">
                    <label >Room</label>
                    <select class="form-control  selectpicker" name="room_id" required data-live-search="true">
                        <option selected="selected" value="">-- Choose Room --</option>
                        @foreach ($room as $r)
                            @if(empty($r->region))
                            <option value="{{$r->id}}"> {{$r->name}}</option>
                            @else
                            <option value="{{$r->id}}"> {{ $r->region->name }} - {{$r->name}}</option>
                            @endif

                        @endforeach
                    </select>
                    <span class="help-block with-errors"></span>
                </div>
                <div class="form-group">
                    <label >Rak</label>
                    <input type="text" class="form-control" id="name" name="name"  autofocus required>
                    <span class="help-block with-errors"></span>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" id="desc" name="desc"  autofocus>
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

