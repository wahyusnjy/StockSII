@extends('layouts.master')


@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Latest compiled and minified CSS -->

@endsection

@section('content')
    <div class="box">

        <div class="box-header">
            <h3 class="box-title">Data Products Out</h3>
        </div>

        <div class="box-header">
            <a href="{{ route('productsOut.create') }}" class="btn btn-primary" >Add Products Out</a>
            <a href="{{ route('exportPDF.productKeluarAll') }}" class="btn btn-danger">Export PDF</a>
            <a href="{{ route('exportExcel.productKeluarAll') }}" class="btn btn-success">Export Excel</a>
        </div>

        <div class="box-header">
            <div style="max-width: 30%;" class="pull-right">
                <form action="{{ url('/cari/productsOut') }}" method="get" class="input-group">
                    <input type="text" name="cari" class="form-control " placeholder="Cari..."  value="{{ request('cari') }}">
                    <span class="input-group-btn "><input type="submit" class="btn btn-primary" value="CARI">Go</span>
                </form>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <p> {{ "Showing " .$invoice_data->count() . " from "  . $invoice_data->firstItem() . " to " .  $invoice_data->lastItem() ." of " . $invoice_data->total() . " results "}}</p>
            <table id="products-out-table" class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Products</th>
                    <th>Customer</th>
                    <th>QTY</th>
                    <th>Tanggal Keluar</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @php
                     $id = 1 + $invoice_data->count() * $invoice_data->perPage() - $invoice_data->perPage();
                    @endphp
                    @foreach ($invoice_data as $i)
                    <tr>
                        <td>{{ $id++ }}</td>
                        <td>{{ $i->product->nama }}</td>
                        <td>{{ $i->customer->nama }}</td>
                        <td>{{ $i->qty }}</td>
                        <td>{{ $i->tanggal }}</td>
                        <td>{{ $i->keterangan }}</td>
                        <td>
                        <form action="{{ route('productsOut.destroy', $i->id) }}" method="post">
                            <div style="display:inline-block">
                            <a href="{{ route('exportPDF.productKeluar', [ 'id' => $i->id ]) }}" class="btn btn-xs btn-warning">Export Invoice</a>
                            <a href="{{ url('productsOut/'.$i->id.'/edit') }}" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                        </div>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 pull-right">
            {{ $invoice_data->links() }}
            </div>
        </div>
        <!-- /.box-body -->
    </div>



    @include('product_keluar.form')

    @include('product_keluar.form_import')

@endsection

@section('bot')

    <!-- DataTables -->
    <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>


    <!-- InputMask -->
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('assets/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>
    <!-- Latest compiled and minified JavaScript -->


    <script>
    // $(function () {
    // // $('#items-table').DataTable()
    // $('#invoice').DataTable({
    // 'paging'      : true,
    // 'lengthChange': false,
    // 'searching'   : false,
    // 'ordering'    : true,
    // 'info'        : true,
    // 'autoWidth'   : false,
    // 'processing'  : true,
    // // 'serverSide'  : true
    // })
    // })
    // </script>

    <script>
        $(function () {

            //Date picker
            $('#tanggal').datepicker({
                autoclose: true,
                // dateFormat: 'yyyy-mm-dd'
            })

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })
        })
    </script>

    <script type="text/javascript">
        // var table = $('#products-out-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     deferRender: true,
        //     ajax: "{{ route('api.productsOut') }}",
        //     columns: [
        //         {data: 'id', name: 'id'},
        //         {data: 'products_name', name: 'products_name'},
        //         {data: 'customer_name', name: 'customer_name'},
        //         {data: 'qty', name: 'qty'},
        //         {data: 'tanggal', name: 'tanggal'},
        //         {data: 'keterangan', name: 'keterangan'},
        //         {data: 'action', name: 'action', orderable: false, searchable: false}
        //     ]
        // });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Add Products Out');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('productsOut') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Edit Products');

                    $('#id').val(data.id);
                    $('#product_id').val(data.product_id);
                    $('#customer_id').val(data.customer_id);
                    $('#qty').val(data.qty);
                    $('#tanggal').val(data.tanggal);
                    $('#keterangan').val(data.keterangan);
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
                    url : "{{ url('productsOut') }}" + '/' + id,
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

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('productsOut') }}";
                    else url = "{{ url('productsOut') . '/' }}" + id;

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
