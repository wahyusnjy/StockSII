@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Data Category</h3>
        </div>

        @if(Auth::user()->role == 'admin')
        <div class="box-header">
            <a href="{{ route('kategori.create') }}" class="btn btn-primary" >Add Category</a>
        </div>
        @endif

        <div class="box-header">
            <div style="max-width: 30%;" class="pull-right">
                <form action="{{ url('/cari/kategori') }}" method="get" class="input-group">
                    <input type="text" name="cari" class="form-control " placeholder="Cari..." value="{{ request('cari') }}">
                    <span class="input-group-btn "><input type="submit" class="btn btn-primary" value="CARI">Go</span>
                </form>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <p> {{ "Showing ". $assets->count() . " from " . $assets->firstItem() . " to " .  $assets->lastItem() ." of " . $assets->total() . " results "}}</p>
            <table id="assets-table" class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    @if(Auth::user()->role == 'admin')
                    <th>Action</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1 + $assets->currentPage() * $assets->perPage() - $assets->perPage();
                    @endphp
                    @foreach ($assets as $a)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>
                            @if($a->parent_id != 0)
                               {{ $a->parent->name }} - {{ $a->name }}
                            @else
                            {{ $a->name }}
                            @endif
                        </td>
                        @if(Auth::user()->role == 'admin')
                        <td>
                            <a href="{{ url('kategori/'.$a->id.'/edit') }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                            <form id="myForm" action="{{ route('kategori.destroy', $a->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs" onclick="confirmSubmit({{ $a->id }})"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                            </form>
                        </td>
                        @endif
                    </tr>

                        {{-- @foreach ($a->child as $child)
                        <tr>
                            <td></td>
                            <td style="padding-left: 80px; ">{{ $child->name }}</td>
                            <td></td>
                        </tr>
                        @endforeach --}}
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 pull-right">
            {{ $assets->withQueryString()->links() }}
            </div>
        </div>
        <!-- /.box-body -->
    </div>

    @include('kategori.form')
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
        // var table = $('#assets-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     deferRender: true,
        //     pagingType: 'full_numbers',
        //     ajax: "{{ route('api.kategori') }}",
        //     columns: [
        //         {data: 'id', name: 'id'},
        //         {data: 'name', name: 'name'},
        //         {data: 'action', name: 'action', orderable: false, searchable: false}
        //     ]
        // });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Add Kategori');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('kategori') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit AsetInven');

                    $('#id').val(data.id);
                    $('#name').val(data.name);
                },
                error : function() {
                    alert("Nothing Data");
                }
            });
        }

        function deleteData(id){
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
                $.ajax({
                    url : "{{ url('kategori') }}" + '/' + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success : function(data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error : function () {
                        swal({
                            title: 'Oops...',
                            text: data.message,
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

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
                    if (save_method == 'add') url = "{{ url('kategori') }}";
                    else url = "{{ url('kategori') . '/' }}" + id;

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
