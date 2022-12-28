@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Add Assets / Inventory</h3>
    </div>
    <div class="box-body">
        <form method="post"class="form-horizontal" enctype="multipart/form-data" action="{{route('assetinventory.store')}}">
            @csrf

            <input type="hidden" id="id" name="id">
            <div class="box-body">
                <div class="form-group">
                    <label >Assets / Inventory </label>
                    <input type="text" class="form-control" id="name" name="name"  autofocus required>
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
    @endsection

