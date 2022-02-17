@section('content')
<style>
     .action:hover{
            opacity:0.5;
        }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
        <span class="text-muted fw-light">Role /</span> Daftar Role
    </h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div>
            <h5 class="card-header" style="float: left">Daftar Role</h5>
            @foreach(session('akses') as $menu)
            @if($menu->id_menu_function == 2 && $menu->menu_name == 'role-add')
            <button type="button" class="btn btn-primary mt-3" style="float: right; margin-right: 1%" onclick="addRole()">Add new role</button>
            @endif
            @endforeach
        </div>

        <div class="card-datatable table-responsive pt-0 text-nowrap" style="clear: both">
            <table class="table" id="role">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Role</th>
                        {{-- @foreach(session('akses') as $menu)
                        @if($menu->id_menu_function == 2 && $menu->menu_name == 'permissions' || $menu->id_menu_function == 2 && $menu->menu_name == 'order-edit' || $menu->id_menu_function == 2 && $menu->menu_name == 'order-delete') --}}
                            <th>Actions</th>
                        {{-- @endif
                        @endforeach --}}
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="bodyRole">
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
        dataRole();
    });

    function addRole(params) {
        window.location.href = '{{ route('role.add') }}';
    }

    function dataRole(params) {
        console.log('client')
        $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/roles/get-role')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);

                var role = "";

                $.each(obj.data, function (k, v) {
                    role += `<tr>
                        <td>${k+1}</td>
                        <td>${v.roles}</td>
                        <td>
                            <div class="d-flex">
                                @foreach(session('akses') as $menu)

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'permissions')
                                    <a href="javascript:void(0);" onclick=manageAccess(${v.id}) class="me-4 action"><i class="bx bxs-lock-open-alt" style='color:##c3e6b3'></i></a>
                                @endif

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'role-edit')
                                    <a href="javascript:void(0);" onclick=editrole(${v.id}) class="me-4 action"><i class="bx bx-edit" style='color:#decb20'></i></a>
                                @endif


                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'role-delete')
                                    <a href="javascript:void(0);" onclick=deleted(${v.id}) class="me-4 action"><i class="bx bxs-trash-alt" style='color:#fb0303'></i></a>
                                @endif

                                @endforeach
                            </div>
                        </td>
                      </tr>`;
                });

                $('#bodyRole').html(role);
                $('#role').DataTable({
                    "scrollX": true,
                });

            } //ajax post data
        });
    }

    function editrole(id) {
        window.location.href = '/roles/detail/'+id;
    }

    function manageAccess(id) {
        window.location.href = '/menus/daftar-menu/'+id;
    }

    function deleted(id) {

event.preventDefault();
swal({
        title: "",
        text: "Apa anda yakin untuk menghapus data role",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "{{url('/roles/delete')}}",
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
                            $('#role').DataTable().destroy();
                            dataRole();
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
