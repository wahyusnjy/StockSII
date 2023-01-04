@extends('layouts.master')
<style>
    #products-table {
        max-width: 500px;
    }

    td.dt-nowrap {
        white-space: nowrap
    }
</style>

@section('top')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Data Products</h3>
            @php
                $page = $producs->currentPage();
            @endphp
            <a href="{{ url('/barcodePage?page='.$page.'') }}" class="btn btn-warning pull-right" style="margin-top: -8px;">Print
                Barcode</a>
            <button type="button" id="button-export-selected" disabled class="btn btn-danger pull-right"
                style="margin-top: -8px;" onclick="exportDataTerpilih()">Print Selected Barcode</button>
            <a href="{{ url('/products/create') }}" class="btn btn-primary pull-right" style="margin-top: -8px;">Add
                Products</a>
        </div>

    <div class="box-header">
        <div style="max-width: 30%;" class="pull-right">
            <form action="{{ url('/cari/product') }}" method="get" class="input-group">
                <input type="text" name="cari" class="form-control " placeholder="Cari Product..." value="{{ request('cari') }}">
                <span class="input-group-btn "><input type="submit" class="btn btn-primary" value="CARI">Go</span>
            </form>
        </div>
    </div>

        <!-- /.box-header -->
        <div class="box-body">
            @php

            @endphp
            <p> {{ "Showing ". $producs->count() . " from " . $producs->firstItem() . " to " .  $producs->lastItem() ." of " . $producs->total() . " results "}}</p>
            <div class="table-responsive">
                <table class="table table-striped products-table" style="width: 100%;">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="head-cb">
                            </th>
                            <th>ID</th>
                            <th>QR_CODE</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>QTY</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Lokasi</th>
                            <th>Asset/Inventory</th>
                            <th>User</th>
                            <th>Activity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                             $i = 1 + $producs->currentPage() * $producs->perPage() - $producs->perPage();
                        @endphp
                        @foreach ($producs as $p)
                            @php
                                $activ = App\Models\ActivityLog::where('product_id', $p->id)
                                    ->orderBy('id_activity', 'desc')
                                    ->first();
                                $date = Carbon\Carbon::parse($p->created_at)->format('d-m-Y');
                                // use SimpleSoftwareIO\QrCode\Facades\QrCode as FacadesQrCode;
                                // $qr = FacadesQrCode::size(300)->
                            @endphp
                            <tr>
                                <td><input type="checkbox" class="child-cb" value="{{ $p->id }}"></td>
                                <td> {{ $i++ }}</td>
                                <td>{!! QrCode::size(70)->generate($p->product_code) !!} <br>
                                    <p>{{ $p->qrcode }}</p>
                                </td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->harga }}</td>
                                <td>{{ $p->qty }}</td>
                                @if (empty($p->image))
                                    <td>No Image</td>
                                @else
                                    <td><a href="{{ url($p->image) }}" target="_blank"><img class="rounded-square"
                                                width="50" height="50" src="{{ url($p->image) }}"
                                                alt=""></a></td>
                                @endif
                                <td>{{ $p->category->name }}</td>
                                <td>{{ $p->lokasi->name }}</td>
                                <td>{{ $p->assets->name }}</td>
                                <td>{{ $p->user }}</td>
                                <td>
                                    @if (empty($activ->activity_status))
                                        <span class="badge badge-warning">Nothing <br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 1)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 2)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 3)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 4)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 5)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 6)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 7)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 8)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 9)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 10)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 11)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @elseif($activ->activity_status == 12)
                                        <span class="badge badge-warning">Last Input Product
                                            by{{ auth()->user()->name }}<br>{{ $date }}</span>
                                    @endif
                                </td>
                                <td>

                                    <a href="/print/barcode/{{ $p->id }} ?download=Y"
                                        class="btn btn-warning btn-xs "><i class="glyphicon glyphicon-eye-open"></i>
                                        Export</a>
                                    <a href="{{ url('products/detail/'.$p->id) }}" class="btn btn-info btn-xs"><i
                                            class="glyphicon glyphicon-eye-open"></i> Show</a>
                                    <a href="{{ url('products/' . $p->id . '/edit') }}" class="btn btn-primary btn-xs"><i
                                            class="glyphicon glyphicon-edit"></i> Edit</a>
                                    <form id="myForm" action="{{ route('products.destroy', $p->id) }}" method="post" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs"  onclick="confirmSubmit({{ $p->id }})"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 pull-right">

                  {{ $producs->withQueryString()->links() }}
                </div>
            </div>
        </div>

        <!-- /.box-body -->
    </div>

    {{-- @include('products.form') --}}
    @include('products.form_import')

    <form action="{{ route('barcodeSelected.products') }}" method="get" id="form-export-terpilih" class="hidden">
        <input type="hidden" name="ids">
        <button class="hidden" style="display: none;" type="submit">S</button>
    </form>
@endsection

@section('bot')
    <!-- DataTables -->
    <script src=" {{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    {{-- Validator --}}
    <script src="{{ asset('assets/validator/validator.min.js') }}"></script>

    {{-- <script> --}}
    {{-- $(function () { --}}
    {{-- $('#items-table').DataTable() --}}
    {{-- $('#example2').DataTable({ --}}
    {{-- 'paging'      : true, --}}
    {{-- 'lengthChange': false, --}}
    {{-- 'searching'   : false, --}}
    {{-- 'ordering'    : true, --}}
    {{-- 'info'        : true, --}}
    {{-- 'autoWidth'   : false --}}
    {{-- }) --}}
    {{-- }) --}}
    {{-- </script> --}}

    <script type="text/javascript">
        let yangDiCheck = 0;
        // var table = $('#products-table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     deferRender: true,
        //     ajax: "{{ route('getProducts.products') }}",
        //     columns: [
        //         {data: 'checkbox', name: 'checkbox'},
        //         {data: 'id', name: 'id'},
        //         {data: 'product_code', name: 'product_code'},
        //         {data: 'nama', name: 'nama'},
        //         {data: 'harga', name: 'harga',
        //         render: $.fn.dataTable.render.number('.')},
        //         {data: 'qty', name: 'qty'},
        //         {data: 'show_photo', name: 'show_photo'},
        //         {data: 'category_name', name: 'category_name'},
        //         {data: 'lokasi_name', name: 'lokasi_name'},
        //         {data: 'assets_name', name: 'assets_name'},
        //         {data: 'user_show', name: 'user_show'},
        //         {data: 'activity_status', name: 'activity_status'},
        //         {data: 'action', name: 'action', orderable: false, searchable: false}
        //     ]
        // });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Add Products');
        }

        // function editForm(id) {
        //     save_method = 'edit';
        //     $('input[name=_method]').val('PATCH');
        //     $('#modal-form form')[0].reset();
        //     $.ajax({
        //         url: "{{ url('products') }}" + '/' + id + "/edit",
        //         type: "GET",
        //         dataType: "JSON",
        //         success: function(data) {
        //             $('#modal-form').modal('show');
        //             $('.modal-title').text('Edit Products');

        //             $('#id').val(data.id);
        //             $('#product_code').val(data.product_code);
        //             $('#nama').val(data.nama);
        //             $('#harga').val(data.harga);
        //             $('#qty').val(data.qty);
        //             $('#user').val(data.user);
        //             $('#category_id').val(data.category_id);
        //             $('#lokasi_id').val(data.lokasi_id);
        //             $('#assets_id').val(data.assets_id);
        //         },
        //         error : function() {
        //             alert("Nothing Data");
        //         }
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

        function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then(function() {
                $.ajax({
                    url: "{{ url('products') }}" + '/' + id,
                    type: "POST",
                    data: {
                        '_method': 'DELETE',
                        '_token': csrf_token
                    },
                    success: function(data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error: function() {
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

        $(function() {
            $('#importform').validator().on('submit', function(e) {
                console.log(e);
                if (!e.isDefaultPrevented()) {
                    var file = $('#file').val();
                    if (save_method == 'add') url = "{{ url('products') }}";
                    else url = "{{ url('products') . '/' }}" + id;

                    $.ajax({
                        url: url,
                        type: "POST",
                        //hanya untuk input data tanpa dokumen
                        //                      data : $('#modal-form form').serialize(),
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            console.log(data);
                            $('#modal-form').modal('hide');
                            table.ajax.reload();
                            window.location.reload();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error: function(data) {
                            console.log(data);
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

        //Checkbox Cek All
        $("#head-cb").on('click', function() {
            var isChecked = $('#head-cb').prop('checked')
            $(".child-cb").prop('checked', isChecked)
            $("#button-export-selected").prop('disabled', !isChecked)
        })

        $(".products-table ").on('click', '.child-cb', function() {
            if ($(this).prop('checked') != true) {
                $("#head-cb").prop('checked', false)
            }
            let semua_checkbox = $(".products-table  .child-cb:checked")
            let button_export_selected = (semua_checkbox.length > 0)

            $("#button-export-selected").prop('disabled', !button_export_selected)
        })

        function exportDataTerpilih() {
            let checkbox_terpilih = $(".products-table .child-cb:checked")
            let semua_id = []
            $.each(checkbox_terpilih, function(index, elm) {
                semua_id.push(elm.value)
            })
            let ids = semua_id.join(',')
            $("#button-export-selected").prop('disabled', true)
            $("#form-export-terpilih [name='ids']").val(ids)
            $("#form-export-terpilih").submit()
            // $.ajax({
            //     url: "{{ url('products') }}" + '/barcodeSelected'+ '/'+ id,
            //     method:'GET',
            //     success:function(res){
            //         console.log(res)
            //         $("#button-export-selected").prop('disabled',true)
            //     }
            // })
        }
    </script>
@endsection
