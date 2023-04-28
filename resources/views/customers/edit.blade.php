@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Product Users</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('customers.update', $customer->id)}}">
            @csrf
            @method('PATCH')
            <input type="hidden" id="id" name="id">


            <div class="box-body">
                <div class="form-group">
                    <label >Name</label>
                    <input type="text" class="form-control" id="nama" value="{{ $customer->nama }}" name="nama"  autofocus required>
                    <span class="help-block with-errors"></span>
                </div>

                <div class="form-group">
                    <label >Address</label>
                    <input type="text" class="form-control" id="alamat" value="{{ $customer->alamat }}" name="alamat"   required>
                    <span class="help-block with-errors"></span>
                </div>

                <div class="form-group">
                    <label >Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $customer->email }}" name="email"   required>
                    <span class="help-block with-errors"></span>
                </div>

                <div class="form-group">
                    <label >Phone</label>
                    <input type="text" class="form-control" id="telepon" value="{{ $customer->telepon }}" name="telepon"   required>
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
@endsection
