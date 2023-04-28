@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Category</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('kategori.update', $parent_id->id)}}">
            @csrf
            @method('PATCH')
          <input type="hidden" id="id" name="id">
            <div class="box-body">
                <div class="form-group">
                    <select class="form-control js-example-basic-single
                        @error('parent_id')
                        is-invalid
                        @enderror" name="parent_id" id="parent_id">
                        <option selected="selected" value="0" disabled>Parent Category</option>
                        @if(empty($parent_id->parent_id))
                            @foreach ($allkategori as $k)
                            @if($parent_id->parent_id != 0)
                            <option value="{{ $k->id }}">{{ $parent_id->parent->name }} - {{ $k->name}}</option>
                            @else
                            <option value="{{ $k->id }}"> {{ $k->name}}</option>
                            @endif
                            @endforeach
                        @else
                            <option value="{{ $parent_id->parent_id }}">{{ $parent_id->parent->name }}</option>
                        @endif

                    </select>
                    </div>

                    <div class="form-group">
                        <label >Category </label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $parent_id->name }}"  autofocus required>
                        <span class="help-block with-errors"></span>
                    </div>

            </div>
            <!-- /.box-body -->

            <div class="modal-footer">
                <a href="{{ route('kategori.index') }}" type="button" class="btn btn-default pull-left" >Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
</div>
@endsection
