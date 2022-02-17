@section('content')
<style>
     .action:hover{
            opacity:0.5;
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
            @foreach(session('akses') as $menu)
            @if($menu->id_menu_function == 2 && $menu->menu_name == 'order-add')
            <button type="button" class="btn btn-primary mt-3" style="float: right; margin-right: 1%" onclick="addOrder()">Add new order</button>
            @endif

            @if($menu->id_menu_function == 2 && $menu->menu_name == 'order-import')
            <button type="button" class="btn btn-warning mt-3" style="float: right; margin-right: 1%" data-bs-toggle="modal" data-bs-target="#import">Import CSV</button>
            @endif

            @if($menu->id_menu_function == 2 && $menu->menu_name == 'order-export')
            <a href="{{route('order.exportOrder')}}" target="_blank" class="btn btn-success mt-3" style="float: right; margin-right: 1%">Export CSV</a>
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
                        {{-- @foreach(session('akses') as $menu)
                            @if($menu->id_menu_function == 2 && $menu->menu_name == 'order-edit' || $menu->id_menu_function == 2 && $menu->menu_name == 'order-delete') --}}
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
          <div class="text-center mb-4">
            <h3 class="mb-4">Import Bulk Orders With CSV</h3>
          </div>
          <p>This feature will help u to add much order with 1 action</p>
          <form class="row g-3 mt-3" method="POST" action="{{route('order.importOrder')}}" enctype="multipart/form-data">
            @csrf
            <div class="col-12">
              <label class="form-label" for="modalEnableOTPPhone">Pick CSV files</label>
              <div class="input-group input-group-merge">
              <input type="file" name="file" class="form-control" id="csv">
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary me-1 me-sm-3">Submit</button>
              <button
                type="reset"
                class="btn btn-label-secondary"
                data-bs-dismiss="modal"
                aria-label="Close"
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="{{asset('sweetalert/sweetalert.min.js')}}"></script>
{{-- {{dd(Session::has('store'))}} --}}
@if(Session::has('store'))
<script type="text/javascript">
     $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/updateLogBulk')}}",
            type: "post",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
            } //ajax post data
        });
    swal("", "Berhasil menambah data order", "success");
</script>
@endif

@stop
@section('fungsi')
<script type="text/javascript">
    $(document).ready(function () {
        dataOrder();
    });

    function addOrder(params) {
        window.location.href = '{{ route('order.add') }}';
    }

    function editOrder(id) {
        window.location.href = '/orders/detail/'+id;
    }

    function dataOrder(params) {
        console.log('client')
        $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/orders/get-order')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);

                var order = "";

                $.each(obj.data, function (k, v) {
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
                                @foreach(session('akses') as $menu)

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'order-edit')
                                    <a href="javascript:void(0);" onclick=editOrder(${v.id}) class="me-4 action"><i class="bx bx-edit" style='color:#decb20'></i></a>
                                @endif

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'order-delete')
                                <a href="javascript:void(0);" onclick=deleted(${v.id}) class="action"><i class="bx bxs-trash-alt" style='color:#fb0303'></i></a>
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
                url: "{{url('/orders/delete')}}",
                type: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function (data) {
                    var json = data;
                    obj = JSON.parse(json);

                    swal({
                        title: "",
                        text: obj.message,
                        icon: "success",
                        showCancelButton: false, // There won't be any cancel button
                        showConfirmButton: true
                    }).then(function (isConfirm) {
                        if (isConfirm) {
                            $('#order').DataTable().destroy();
                            dataOrder();
                        } else {
                            //if no clicked => do something else
                        }
                    });
                },
                error: function () {
                    swal(obj.error, 'error');
                }
            });
        }
    });
}

</script>
@stop
