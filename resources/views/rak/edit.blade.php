@extends('layouts.master')
@section('content')
<link defer rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Rak</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('rak.update', $rak->id)}}">
            @csrf
            @method('PATCH')
            <div class="box-body">
                <div class="form-group">
                    <label >Room</label>
                    <select class="form-control  selectpicker" name="room_id" required data-live-search="true">
                        @if(empty($rak->room_id))
                            @foreach ($room as $r)
                                <option value="{{$r->id}}">{{ $r->region->name }} - {{$r->name}}</option>
                            @endforeach
                        @else
                            @foreach ($room as $r)
                                @if($r->id == $rak->room_id)
                                    <option selected="selected" value="{{ $rak->room_id }}">{{ $rak->room->region->name }} - {{ $rak->room->name }}</option>
                                @else
                                    <option value="{{$r->id}}">{{$r->name}}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    <span class="help-block with-errors"></span>
                </div>
                <div class="form-group">
                    <label >Rak</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $rak->name }}"  autofocus required>
                    <span class="help-block with-errors"></span>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" id="desc" name="desc" value="{{ $rak->desc }}"  autofocus>
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
