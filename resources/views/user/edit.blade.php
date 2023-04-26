@extends('layouts.master')
@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Users</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('user.update', $users->id)}}">
            @csrf
            @method('PATCH')
            <div class="box-body">
                <div class="form-group">
                    <label >Name</label>
                    <input type="text" class="form-control" value="{{ $users->name }}" id="name" name="name"  autofocus required>
                    <span class="help-block with-errors"></span>
                </div>

                <div class="form-group">
                    <label >Email</label>
                    <input type="email" class="form-control" value="{{ $users->email }}" id="email" name="email"   required>
                    <span class="help-block with-errors"></span>
                </div>

                <div class="form-group">
                    <label >Password</label>
                    <input type="password" class="form-control" placeholder="Please re-input password" id="password" name="password">
                    {{-- <span class="help-block with-errors"></span> --}}
                </div>

                <div class="form-group">
                    <select class="form-control"
                    placeholder="Role" name="role" id="role" required>
                    <option selected="" value="{{ $users->role }}">{{ $users->role }}
                    </option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                    </select>
                    <span class="help-block with-errors"></span>
                </div>

                <div class="form-group">
                    <select class="form-control"
                    placeholder="Divisi" name="divisi" id="divisi" required>
                    @if(empty($users->divisi->id))
                        @foreach ($divisi as $d)
                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    @else
                    <option selected="" value="{{ $users->divisi->id }}">{{ $users->divisi->name }}</option>
                    @foreach ($divisi as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                    @endforeach
                    @endif
                    </select>
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
