@section('content')
    <style>
        .action:hover {
            opacity: 0.5;
        }

    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="breadcrumb-wrapper py-3 mb-4">
            <span class="text-muted fw-light">Pricing /</span> Daftar Pricing
        </h4>

        <!-- Basic Bootstrap Table -->
        <input type="hidden" value="{{ app('request')->input('id_client') }}" id="id_client">
        <div class="card">
            <div>
                <h5 class="card-header" style="float: left">Daftar Pricing</h5>
                <a href="{{ route('pricing.exportPricing', app('request')->input('id_client')) }}"
                    class="btn btn-success mt-3" style="float: right; margin-right: 1%">Export CSV</a>
                <button type="button" class="btn btn-warning mt-3" style="float: right; margin-right: 1%"
                    data-bs-toggle="modal" data-bs-target="#import">Import CSV</button>
                <button type="button" class="btn btn-primary mt-3" style="float: right; margin-right: 1%"
                    onclick="addPrice({{ app('request')->input('id_client') }})">Add new pricing</button>
            </div>

            <div class="card-datatable table-responsive pt-0 text-nowrap" style="clear: both">
                <table class="table" id="price">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Account Name</th>
                            <th>Province</th>
                            <th>Area</th>
                            <th>District</th>
                            <th>Subdistrict</th>
                            <th>Postal code</th>
                            <th>Service</th>
                            <th>Type</th>
                            <th>Price</th>
                            {{-- @foreach (session('akses') as $menu)
                        @if (($menu->id_menu_function == 2 && $menu->menu_name == 'client-edit') || ($menu->id_menu_function == 2 && $menu->menu_name == 'client-delete')) --}}
                            <th>Actions</th>
                            {{-- @endif
                        @endforeach --}}
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0" id="bodyPrice">
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
                    <div id="addOrder">
                        <div class="text-center mb-4">
                            <h3 class="mb-4">Import Bulk Pricing With CSV</h3>
                        </div>
                        <p>This feature will help u to add much pricing with 1 action</p>
                        <form class="row g-3 mt-3" method="POST" action="{{ route('pricing.importPricing') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-12">
                                <label class="form-label" for="modalEnableOTPPhone">Pick CSV files to add new bulk
                                    pricing</label>
                                <div class="input-group input-group-merge">
                                    <input type="file" name="file" class="form-control" id="csv" required>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>

    @if (Session::has('store'))
        <script type="text/javascript">
            swal("", "Berhasil menambah data pricing", "success");
        </script>
    @endif

    @if (Session::has('no_pricing'))
        <script type="text/javascript">
            swal("", "Belum ada data pricing", "error");
        </script>
    @endif
@stop
@section('fungsi')
    <script type="text/javascript">
        $(document).ready(function() {
            list_pricing();
        });

        function addPrice(params) {
            window.location.href = '/pricings/add/' + params;
        }

        function editPrice(params) {
            window.location.href = '/pricings/editPrice/' + params;
        }

        function list_pricing(params) {
            var client = $('#id_client').val();
            console.log(client);
            $.ajax({
                processing: true,
                serverSide: true,
                url: "{{ url('/pricings/get-pricing') }}",
                type: "get",
                data: {
                    client: client,
                },
                context: document.body,
                success: function(data) {
                    var json = data;
                    obj = JSON.parse(json);
                    console.log(obj.data)

                    var pricing = "";

                    $.each(obj.data, function(k, v) {
                        pricing += `<tr>
                        <td>${k+1}</td>
                        <td>${v.account_name}</td>
                        <td>${v.province}</td>
                        <td>${v.area}</td>
                        <td>${v.district}</td>
                        <td>${v.subdistrict}</td>
                        <td>${v.postal_code}</td>
                        <td>${v.service}</td>
                        <td>${v.type}</td>
                        <td>${v.price}</td>

                        <td>
                            <div class="d-flex">
                                    <a href="javascript:void(0);" onclick=editPrice(${v.id}) class="me-4 action"><i class="bx bx-edit"
                                            style='color:#decb20'></i></a>
                                    <a href="javascript:void(0);" onclick=deleted(${v.id}) class="action"><i class="bx bxs-trash-alt"
                                            style='color:#fb0303'></i></a>
                            </div>
                        </td>

                      </tr>`;
                    });

                    $('#bodyPrice').html(pricing);
                    $('#price').DataTable({
                        "scrollX": true,
                    });

                } //ajax post data
            });
        }

        function deleted(id) {

            event.preventDefault();
            swal({
                title: "",
                text: "Apa anda yakin untuk menghapus data pricing",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ url('/pricings/delete') }}",
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
                                    $('#price').DataTable().destroy();
                                    list_pricing();
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
