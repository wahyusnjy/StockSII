@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Data Room</h3>
        </div>

        @if(Auth::user()->role == 'admin')
        <div class="box-header">
            <a href="{{ route('ruangan.create') }}" class="btn btn-primary" >Add Room</a>
        </div>
        @endif

        <div class="box-header">
            <div style="max-width: 30%;" class="pull-right">
                <form action="{{ url('/cari/ruangan') }}" method="get" class="input-group">
                    <input type="text" name="cari" class="form-control " placeholder="Cari..."  value="{{ request('cari') }}">
                    <span class="input-group-btn "><input type="submit" class="btn btn-primary" value="CARI">Go</span>
                </form>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <p> {{ "Showing ". $ruangan->count() . " from " . $ruangan->firstItem() . " to " .  $ruangan->lastItem() ." of " . $ruangan->total() . " results "}}</p>
            <table id="lokasi-table" class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Region</th>
                    <th>Room</th>
                    @if(Auth::user()->role == 'admin')
                    <th>Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                 @php
                    $i = 1 + $ruangan->currentPage() * $ruangan->perPage() - $ruangan->perPage();
                @endphp
                    @foreach ($ruangan as $l)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            @if(empty($l->region->name) )
                            -
                            @else
                            {{ $l->region->name }}
                            @endif
                        </td>
                        <td>{{ $l->name }}</td>
                        @if(Auth::user()->role == 'admin')
                        <td>
                         <a href="{{ url('ruangan/'.$l->id.'/edit') }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                         <form id="myForm" action="{{ route('ruangan.destroy', $l->id) }}" method="post" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs" onclick="confirmSubmit({{ $l->id }})"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </form>

                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 pull-right">
            {{ $ruangan->withQueryString()->links() }}
            </div>
        </div>
        <!-- /.box-body -->
    </div>

    @include('ruangan.form')
    @include('ruangan.form_import')

@endsection

@section('bot')

    <!-- DataTables -->
    <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

    {{--<script>--}}
    {{--$(function () {--}}
    {{--$('#items-table').DataTable()--}}
    {{--$('#example2').DataTable({--}}
    {{--'paging'      : true,--}}
    {{--'lengthChange': false,--}}
    {{--'searching'   : false,--}}
    {{--'ordering'    : true,--}}
    {{--'info'        : true,--}}
    {{--'autoWidth'   : false--}}
    {{--})--}}
    {{--})--}}
    {{--</script>--}}

    <script type="text/javascript">
        // var table = $('#ruangan-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     deferRender: true,
        //     ajax: "{{ route('api.ruangan') }}",
        //     columns: [
        //         {data: 'id', name: 'id'},
        //         {data: 'name', name: 'name'},
        //         {data: 'action', name: 'action', orderable: false, searchable: false}
        //     ]
        // });

        // function addForm() {
        //     save_method = "add";
        //     $('input[name=_method]').val('POST');
        //     $('#modal-form').modal('show');
        //     $('#modal-form form')[0].reset();
        //     $('.modal-title').text('Add ruangan');
        // }

        // function editForm(id) {
        //     save_method = 'edit';
        //     $('input[name=_method]').val('PATCH');
        //     $('#modal-form form')[0].reset();
        //     $.ajax({
        //         url: "{{ url('ruangan') }}" + '/' + id + "/edit",
        //         type: "GET",
        //         dataType: "JSON",
        //         success: function(data) {
        //             $('#modal-form').modal('show');
        //             $('.modal-title').text('Edit ruangan');

        //             $('#id').val(data.id);
        //             $('#name').val(data.name);
        //         },
        //         error : function() {
        //             alert("Nothing Data");
        //         }
        //     });
        // }

        // function deleteData(id){
        //     var csrf_token = $('meta[name="csrf-token"]').attr('content');
        //     swal({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         type: 'warning',
        //         showCancelButton: true,
        //         cancelButtonColor: '#d33',
        //         confirmButtonColor: '#3085d6',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then(function () {
        //         $.ajax({
        //             url : "{{ url('ruangan') }}" + '/' + id,
        //             type : "POST",
        //             data : {'_method' : 'DELETE', '_token' : csrf_token},
        //             success : function(data) {
        //                 table.ajax.reload();
        //                 swal({
        //                     title: 'Success!',
        //                     text: data.message,
        //                     type: 'success',
        //                     timer: '1500'
        //                 })
        //             },
        //             error : function () {
        //                 swal({
        //                     title: 'Oops...',
        //                     text: data.message,
        //                     type: 'error',
        //                     timer: '1500'
        //                 })
        //             }
        //         });
        //     });
        // }

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
                    if (save_method == 'add') url = "{{ url('ruangan') }}";
                    else url = "{{ url('ruangan') . '/' }}" + id;

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
