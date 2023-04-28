@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Region</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('wilayah.update', $category->id)}}">
            @csrf
            @method('PATCH')
            <div class="box-body">
                <div class="form-group">
                    <label >Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" autofocus required>
                    <span class="help-block with-errors"></span>
                </div>

                <div class="form-group">
                    <label >Desc</label>
                    <input type="text" class="form-control" id="desc" name="desc" value="{{ $category->desc }}" autofocus required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>

            </div>

            <div class="modal-footer">
                <a href="{{ route('wilayah.index') }}" type="button" class="btn btn-default pull-left" >Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
</div>
@endsection
