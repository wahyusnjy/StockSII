@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Add Users</h3>
    </div>
    <div class="box-body">
        <form method="post"class="form-horizontal" enctype="multipart/form-data" action="{{route('user.store')}}">
            @csrf
                <input type="hidden" id="id" name="id">


                <div class="box-body">
                    <div class="form-group">
                        <label >Name</label>
                        <input type="text" class="form-control" id="name" name="name"  autofocus required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label >Email</label>
                        <input type="email" class="form-control" id="email" name="email"   required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label >Password</label>
                        <input type="password" class="form-control" id="password" name="password"   required>
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <select class="form-control"
                        placeholder="Role" name="role" id="role" required>
                        <option selected="" disabled="" value="">Role
                        </option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                        </select>
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

