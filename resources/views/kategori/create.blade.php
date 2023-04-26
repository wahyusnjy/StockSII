@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Add Kategori</h3>
    </div>
    <div class="box-body">
        <form method="post"class="form-horizontal" enctype="multipart/form-data" action="{{route('kategori.store')}}">
            @csrf

            <input type="hidden" id="id" name="id">
            <div class="box-body">

                <div class="form-group">
                <select class="form-control js-example-basic-single
                    @error('parent_id')
                    is-invalid
                    @enderror" name="parent_id" id="parent_id">
                    <option selected="selected" value="0" disabled>Parent Kategori</option>
                    @if(empty($parent_id))
                    @else
                    @foreach ($parent_id as $kategori)
                        @if($kategori->parent_id != 0)
                        <option value="{{ $kategori->id }}">{{ $kategori->parent->name }} - {{ $kategori->name }}</option>
                        @else
                        <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                        @endif
                    @endforeach
                    @endif

                </select>
                </div>

                <div class="form-group">
                    <label >Kategori </label>
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


