@section('content')
<style>
     .action:hover{
            opacity:0.5;
        }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
        <span class="text-muted fw-light">Access /</span> Daftar Access
    </h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <input type="hidden" id="id_role" value="{{$id_role}}">
        <div>
            <h5 class="card-header" style="float: left">Daftar Access</h5>
            @foreach(session('akses') as $menu)
            @if($menu->id_menu_function == 2 && $menu->menu_name == 'permissions-add')
            <button type="button" class="btn btn-primary mt-3" style="float: right; margin-right: 1%" onclick="addMenu()">Add new access</button>
            @endif
            @endforeach
        </div>

        <div class="card-datatable table-responsive pt-0 text-nowrap" style="clear: both">
            <table class="table" id="menu">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Role</th>
                        <th>Menu Function</th>
                        <th>Menu Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="bodyMenu">
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
        dataMenu();
    });

    function addMenu() {
        var id = $('#id_role').val();
        console.log(id);
        window.location.href = '/menus/add/'+id;
    }

    function dataMenu(params) {
        var id = $('#id_role').val();
        $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/menus/get-menu')}}",
            type: "get",
            data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);

                var role = "";

                $.each(obj.data, function (k, v) {
                    role += `<tr>
                        <td>${k+1}</td>
                        <td>${v.roles}</td>
                        <td>${v.deskripsi}</td>
                        <td>${v.menu_name}</td>
                        <td>
                            <div class="d-flex">
                                @foreach(session('akses') as $menu)

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'permissions-edit')
                                <a href="javascript:void(0);" onclick=editmenu(${v.id}) class="me-4 action"><i class="bx bx-edit" style='color:#decb20'></i></a>
                                @endif

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'permissions-delete')
                                <a href="javascript:void(0);" onclick=deleted(${v.id}) class="action"><i class="bx bxs-trash-alt" style='color:#fb0303'></i></a>
                                @endif

                                @endforeach
                            </div>
                        </td>
                      </tr>`;
                });

                $('#bodyMenu').html(role);
                $('#menu').DataTable({
                    destroy: true,
                    "scrollX": true,
                });

            } //ajax post data
        });
    }

    function editmenu(id) {
        var id_role = $('#id_role').val();
        window.location.href = '/menus/detail/'+id+ '/'+id_role;
    }

    function deleted(id) {

event.preventDefault();
swal({
        title: "",
        text: "Apa anda yakin untuk menghapus data access",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "{{url('/menus/delete')}}",
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
                            $('#menu').DataTable().destroy();
                            dataMenu();
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
