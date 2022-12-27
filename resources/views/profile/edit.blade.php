@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">Edit Users</h3>
    </div>

    <div class="box-body">

        <form method="POST"class="form-horizontal" enctype="multipart/form-data" action="{{ route('update.profile',$users)}}">
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
                    <input type="password" class="form-control" placeholder="Please re-input password" id="password" name="password" >
                    <span class="help-block with-errors"></span>
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
                    <label >Image</label>
                    <input type="file" class="form-control" value="{{ $users->image }}" id="image" name="image" onchange="loadFile(event)">
                    <span class="help-block with-errors"></span>
                    @if(empty($users->image))
                    <img src="{{ asset('user.png') }}" id="output" class="img-circle" style="max-width: 200px; " alt="">
                    @else
                    <img src="{{ url($users->image) }}" id="output" style="max-width: 200px;" />
                    @endif
                    <img id="output" style="max-width: 200px;" />
                </div>


            </div>
            <!-- /.box-body -->

            </div>

            <div class="modal-footer">
                <a href="{{ route('user.index') }}" type="button" class="btn btn-default pull-left" >Cancel</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var loadFile = function(event) {
        var output = document.getElementById('output');

        if (output === null) {
            output.src = "Image Not Found";
        } else {
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    };
</script>

@endsection

@section('bot')

    <!-- DataTables -->
    <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

@endsection
