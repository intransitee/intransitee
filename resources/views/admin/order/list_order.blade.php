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
            <button type="button" class="btn btn-primary mt-3" style="float: right; margin-right: 1%"
                onclick="addOrder()">Add new order</button>
        </div>

        <div class="card-datatable table-responsive pt-0 text-nowrap" style="clear: both">
            <table class="table" id="order">
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
                        <th>Actions</th>
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
                                <a href="javascript:void(0);" onclick=editOrder(${v.id}) class="me-4 action"><i class="bx bx-edit" style='color:#decb20'></i></a>
                                <a href="javascript:void(0);" onclick=deleted(${v.id}) class="action"><i class="bx bxs-trash-alt" style='color:#fb0303'></i></a>
                            </div>
                        </td>
                      </tr>`;
                });

                $('#bodyOrder').html(order);
                $('#order').DataTable({
                    "scrollY": true,
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
