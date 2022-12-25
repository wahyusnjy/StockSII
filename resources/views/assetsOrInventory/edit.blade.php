@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Assets / Inventory</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('assetinventory.update', $assets->id)}}">
            @csrf
            @method('PATCH')
          <input type="hidden" id="id" name="id">
            <div class="box-body">
                <div class="form-group">
                    <label >Assets / Inventory </label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $assets->name }}" autofocus required>
                    <span class="help-block with-errors"></span>
                </div>

            </div>
            <!-- /.box-body -->

            <div class="modal-footer">
                <a href="{{ route('assetinventory.index') }}" type="button" class="btn btn-default pull-left" >Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
</div>
@endsection
