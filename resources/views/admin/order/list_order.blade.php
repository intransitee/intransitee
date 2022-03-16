@section('content')
    <style>
        .action:hover {
            opacity: 0.5;
        }

    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="breadcrumb-wrapper py-3 mb-4">
            <span class="text-muted fw-light">Order /</span> Daftar Order
        </h4>
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div>
                <h5 class="card-header" style="float: left">Daftar Order</h5>
                @foreach (session('akses') as $menu)
                    @if ($menu->id_menu_function == 2 && $menu->menu_name == 'order-add')
                        <button type="button" class="btn btn-primary mt-3" style="float: right; margin-right: 1%"
                            onclick="addOrder()">Add new order</button>
                    @endif

                    @if ($menu->id_menu_function == 2 && $menu->menu_name == 'order-import')
                        <button type="button" class="btn btn-warning mt-3" style="float: right; margin-right: 1%"
                            data-bs-toggle="modal" data-bs-target="#import">Import CSV</button>
                    @endif

                    @if ($menu->id_menu_function == 2 && $menu->menu_name == 'order-export')
                        <a href="{{ route('order.exportOrder') }}" class="btn btn-success mt-3"
                            style="float: right; margin-right: 1%">Export CSV</a>
                    @endif
                @endforeach
            </div>

            <div class="card-datatable table-responsive pt-0 text-nowrap" style="clear: both">
                <table class="table" id="order" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Awb</th>
                            <th>Client</th>
                            <th>Type</th>
                            <th>Service</th>
                            <th>Collection date</th>
                            <th>Delivery date</th>
                            <th>Status</th>
                            <th>Created at</th>
                            {{-- @foreach (session('akses') as $menu)
                            @if (($menu->id_menu_function == 2 && $menu->menu_name == 'order-edit') || ($menu->id_menu_function == 2 && $menu->menu_name == 'order-delete')) --}}
                            <th>Actions</th>
                            {{-- @endif
                        @endforeach --}}
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="bodyOrder">
                        {{-- call by ajax --}}
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    {{-- Modal import CSV --}}
    <div class="modal fade" id="import" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="col-12" id="optionnya">
                        <div class="row">
                            <div class="col-md mb-3 mb-md-2">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioHome"
                                        onclick="pilihaksi(1)">
                                        <span class="custom-option-body">
                                            <i class="bx bx-plus"></i>
                                            <span class="custom-option-title my-2">Add Bulk Order</span>
                                            <span> Add new order with scv/excel files </span>
                                        </span>
                                        <input name="customRadioIcon" class="form-check-input" type="radio" value=""
                                            id="customRadioHome" checked />
                                    </label>
                                </div>
                            </div>
                            <div class="col-md mb-3 mb-md-2">
                                <div class="form-check custom-option custom-option-icon">
                                    <label class="form-check-label custom-option-content" for="customRadioOffice"
                                        onclick="pilihaksi(2)">
                                        <span class="custom-option-body">
                                            <i class="bx bx-edit"></i>
                                            <span class="custom-option-title my-2"> Edit Bulk Order </span>
                                            <span> Edit new order with scv/excel files </span>
                                        </span>
                                        <input name="customRadioIcon" class="form-check-input" type="radio" value=""
                                            id="customRadioOffice" />
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="addOrder" style="display: none">
                        <div class="text-center mb-4">
                            <h3 class="mb-4">Import Bulk Orders With CSV</h3>
                        </div>
                        <p>This feature will help u to add much order with 1 action</p>
                        <form class="row g-3 mt-3" method="POST" action="{{ route('order.importOrder') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-12">
                                <div class="text-center">
                                    <a href="{{ route('downloadAddOrder') }}"
                                        class="btn btn-primary me-1 me-sm-3 mt-2 mb-2 text-center">Download
                                        Template</a>
                                </div>
                                <label class="form-label" for="modalEnableOTPPhone">Pick CSV files to add new bulk
                                    order</label>
                                <div class="input-group input-group-merge">
                                    <input type="file" name="file" class="form-control" id="csv" required>
                                    <input type="hidden" name="flag" value="1">
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary me-1 me-sm-3">Submit</button>
                            </div>
                            <div class="col-4">
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-warning" id="backOption" onclick=back()>Option</button>
                            </div>
                        </form>
                    </div>
                    <div id="editOrder" style="display: none">
                        <div class="text-center mb-4">
                            <h3 class="mb-4">Import Bulk Orders With CSV to edit order</h3>
                        </div>
                        <p>This feature will help u to edit much order with 1 action</p>
                        <form class="row g-3 mt-3" method="POST" action="{{ route('order.importOrder') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-12">
                                <div class="text-center">
                                    <a href="{{ route('downloadEditOrder') }}"
                                        class="btn btn-primary me-1 me-sm-3 mt-2 mb-2 text-center">Download
                                        Template</a>
                                </div>
                                <label class="form-label" for="modalEnableOTPPhone">Pick CSV files to edit bulk
                                    order</label>
                                <div class="input-group input-group-merge">
                                    <input type="file" name="file" class="form-control" id="csv" required>
                                    <input type="hidden" name="flag" value="2">
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary me-1 me-sm-3">Submit</button>
                            </div>
                            <div class="col-4">
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Cancel
                                </button>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-warning" id="backOption" onclick=back()>Option</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>
    {{-- {{dd(Session::has('store'))}} --}}
    @if (Session::has('store'))
        <script type="text/javascript">
            $.ajax({
                processing: true,
                serverSide: true,
                url: "{{ url('/updateLogBulk') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                context: document.body,
                success: function(data) {
                    var json = data;
                    obj = JSON.parse(json);
                } //ajax post data
            });
            swal("", "Berhasil menambah data order", "success");
        </script>
    @endif

    @if (Session::has('update'))
        <input type="hidden" value="{{ Session::get('update') }}" id="temp_import_update">
        <script type="text/javascript">
            var data = $('#temp_import_update').val()

            $.ajax({
                processing: true,
                serverSide: true,
                url: "{{ url('/updateLogBulkAfterImport') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    data: data
                },
                context: document.body,
                success: function(data) {
                    var json = data;
                    obj = JSON.parse(json);
                } //ajax post data
            });

            swal("", "Berhasil ubah data order", "success");
        </script>
    @endif

    @if (Session::has('no_order'))
        <script type="text/javascript">
            swal("", "Belum ada data order", "error");
        </script>
    @endif

@stop
@section('fungsi')
    <script type="text/javascript">
        $(document).ready(function() {
            dataOrder();
        });

        function back() {
            $('#addOrder').hide();
            $('#editOrder').hide();
            $('#optionnya').show();
        }

        function pilihaksi(params) {
            console.log('masuk')
            console.log(params)

            if (params == 1) {
                $('#addOrder').show();
                $('#editOrder').hide();
                $('#optionnya').hide();
            } else {
                $('#editOrder').show();
                $('#addOrder').hide();
                $('#optionnya').hide();
            }
        }

        function addOrder(params) {
            window.location.href = '{{ route('order.add') }}';
        }

        function editOrder(id) {
            window.location.href = '/orders/detail/' + id;
        }

        function dataOrder(params) {
            console.log('client')
            $.ajax({
                processing: true,
                serverSide: true,
                url: "{{ url('/orders/get-order') }}",
                type: "get",
                context: document.body,
                success: function(data) {
                    var json = data;
                    obj = JSON.parse(json);

                    var order = "";

                    $.each(obj.data, function(k, v) {
                        order += `<tr>
                        <td>${k+1}</td>
                        <td>${v.awb}</td>
                        <td>${v.account_name}</td>
                        <td>${v.type}</td>
                        <td>${v.service}</td>
                        <td>${v.collection_scheduled_date}</td>
                        <td>${v.delivery_scheduled_date}</td>
                        <td><span class="badge badge-dot bg-${v.warna} me-1"></span> ${v.status}</td>
                        <td>${v.created_date}</td>
                        <td>
                            <div class="d-flex">
                                @foreach (session('akses') as $menu)
                                    @if ($menu->id_menu_function == 2 && $menu->menu_name == 'order-edit')
                                        <a href="javascript:void(0);" onclick=editOrder(${v.id}) class="me-4 action"><i class="bx bx-edit"
                                                style='color:#decb20'></i></a>
                                    @endif

                                    @if ($menu->id_menu_function == 2 && $menu->menu_name == 'order-delete')
                                        <a href="javascript:void(0);" onclick=deleted(${v.id}) class="action"><i class="bx bxs-trash-alt"
                                                style='color:#fb0303'></i></a>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                      </tr>`;
                    });

                    $('#bodyOrder').html(order);
                    $('#order').DataTable({
                        "scrollX": true,
                    });

                } //ajax post data
            });
        }

        function deleted(id) {

            event.preventDefault();
            swal({
                title: "",
                text: "Apa anda yakin untuk menghapus data order",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ url('/orders/delete') }}",
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                        },
                        success: function(data) {
                            var json = data;
                            obj = JSON.parse(json);

                            swal({
                                title: "",
                                text: obj.message,
                                icon: "success",
                                showCancelButton: false, // There won't be any cancel button
                                showConfirmButton: true
                            }).then(function(isConfirm) {
                                if (isConfirm) {
                                    $('#order').DataTable().destroy();
                                    dataOrder();
                                } else {
                                    //if no clicked => do something else
                                }
                            });
                        },
                        error: function() {
                            swal(obj.error, 'error');
                        }
                    });
                }
            });
        }
    </script>
@stop
