@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Data Divisi</h3>
        </div>

        <div class="box-header">
            <a href="{{ route('divisi.create') }}" class="btn btn-primary" >Add Divisi</a>
            {{-- <a href="{{ route('exportExcel.lokasiAll') }}" class="btn btn-success">Export Excel</a> --}}
        </div>

        <div class="box-header">
            <div style="max-width: 30%;" class="pull-right">
                <form action="{{ url('/cari/divisi') }}" method="get" class="input-group">
                    <input type="text" name="cari" class="form-control " placeholder="Cari..."  value="{{ request('cari') }}">
                    <span class="input-group-btn "><input type="submit" class="btn btn-primary" value="CARI">Go</span>
                </form>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <p> {{ "Showing ". $divisi->count() . " from " . $divisi->firstItem() . " to " .  $divisi->lastItem() ." of " . $divisi->total() . " results "}}</p>
            <table id="lokasi-table" class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Divisi</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                 @php
                    $i = 1 + $divisi->currentPage() * $divisi->perPage() - $divisi->perPage();
                @endphp
                    @foreach ($divisi as $d)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $d->name }}</td>
                        <td>
                         <a href="{{ url('divisi/edit/'.$d->id.'') }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                         <form id="myForm" action="{{ route('divisi.destroy', $d->id) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs" onclick="confirmSubmit({{ $d->id }})"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 pull-right">
            {{ $divisi->withQueryString()->links() }}
            </div>
        </div>
        <!-- /.box-body -->
    </div>

    @include('divisi.form')

@endsection

@section('bot')

    <!-- DataTables -->
    <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>


    <script type="text/javascript">

        function confirmSubmit(id) {
                // Display the confirm dialog
            event.preventDefault(); // prevent form submit
            var form = event.target.form; // storing the form
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                buttons: true,
                dangerMode: true,
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
                }).then((willDelete) => {
                // If the user clicks the "confirm" button, submit the form
                if (willDelete) {
                    form.submit();
                }
                });

                // Prevent the form from being submitted
                return false;
            }

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('divisi') }}";
                    else url = "{{ url('divisi') . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
                        //hanya untuk input data tanpa dokumen
//                      data : $('#modal-form form').serialize(),
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error : function(data){
                            swal({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });
    </script>

@endsection
