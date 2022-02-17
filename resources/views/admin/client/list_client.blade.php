@section('content')
<style>
     .action:hover{
            opacity:0.5;
        }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
        <span class="text-muted fw-light">Client /</span> Daftar Client
    </h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div>
            <h5 class="card-header" style="float: left">Daftar Client</h5>
            @foreach(session('akses') as $menu)
                @if($menu->id_menu_function == 2 && $menu->menu_name == 'client-add')
                    <button type="button" class="btn btn-primary mt-3" style="float: right; margin-right: 1%" onclick="addClient()">Add new client</button>
                @endif
            @endforeach
        </div>

        <div class="card-datatable table-responsive pt-0 text-nowrap" style="clear: both">
            <table class="table" id="client">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Account Name</th>
                        <th>Pic name</th>
                        <th>Pic number</th>
                        <th>Pic email</th>
                        <th>Sales agent</th>
                        <th>Cod fee</th>
                        <th>Insurance fee</th>
                        {{-- @foreach(session('akses') as $menu)
                        @if($menu->id_menu_function == 2 && $menu->menu_name == 'client-edit' || $menu->id_menu_function == 2 && $menu->menu_name == 'client-delete') --}}
                        <th>Actions</th>
                        {{-- @endif
                        @endforeach --}}
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="bodyClient">
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
        dataClient();
    });

    function addClient(params) {
        window.location.href = '{{ route('client.add') }}';
    }

    function dataClient(params) {
        console.log('client')
        $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/clients/get-client')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj.data)

                var client = "";

                $.each(obj.data, function (k, v) {
                    client += `<tr>
                        <td>${k+1}</td>
                        <td>${v.account_name}</td>
                        <td>${v.pic_name}</td>
                        <td>${v.pic_number}</td>
                        <td>${v.pic_email}</td>
                        <td>${v.sales_agent}</td>
                        <td>${v.cod_fee}%</td>
                        <td>${v.insurance_fee}%</td>

                        <td>
                            <div class="d-flex">
                                @foreach(session('akses') as $menu)

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'client-edit')
                                <a href="javascript:void(0);" onclick=editClient(${v.id}) class="me-4 action"><i class="bx bx-edit" style='color:#decb20'></i></a>
                                @endif

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'client-delete')
                                <a href="javascript:void(0);" onclick=deleted(${v.id}) class="action"><i class="bx bxs-trash-alt" style='color:#fb0303'></i></a>
                                @endif

                                @endforeach
                            </div>
                        </td>

                      </tr>`;
                });

                $('#bodyClient').html(client);
                $('#client').DataTable({
                    "scrollX": true,
                });

            } //ajax post data
        });
    }

    function editClient(id) {
        window.location.href = '{{route('client.edit')}}?id='+id;
    }

    function deleted(id) {

    event.preventDefault();
    swal({
            title: "",
            text: "Apa anda yakin untuk menghapus data client",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{url('/clients/delete')}}",
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
                                $('#client').DataTable().destroy();
                                dataClient();
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
