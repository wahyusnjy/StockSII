@extends('layouts.master')
@section('content')
<link defer rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Add Lokasi</h3>
    </div>
    <div class="box-body">
        <form method="post"class="form-horizontal" enctype="multipart/form-data" action="{{route('lokasi.store')}}">
            @csrf
            <input type="hidden" id="id" name="id">


            <div class="box-body">
                <div class="form-group">
                    <label >Lokasi</label>
                    <input type="text" class="form-control" id="name" name="name"  autofocus required>
                    <span class="help-block with-errors"></span>
                </div>


            </div>
            <!-- /.box-body -->


            <div class="modal-footer">
                <a href="{{ route('lokasi.index') }}"  type="button" class="btn btn-default pull-left" >Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    @endsection

