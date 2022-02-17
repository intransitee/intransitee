@section('content')
<style>
     .action:hover{
            opacity:0.5;
        }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
        <span class="text-muted fw-light">User /</span> Daftar User
    </h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div>
            <h5 class="card-header" style="float: left">Daftar User</h5>
            @foreach(session('akses') as $menu)
            @if($menu->id_menu_function == 2 && $menu->menu_name == 'user-add')
            <button type="button" class="btn btn-primary mt-3" style="float: right; margin-right: 1%" onclick="addUser()">Add new user</button>
            @endif
            @endforeach
        </div>

        <div class="card-datatable table-responsive pt-0 text-nowrap" style="clear: both">
            <table class="table" id="user">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Last Login</th>
                        <th>Created At</th>
                        {{-- @foreach(session('akses') as $menu)
                        @if($menu->id_menu_function == 2 && $menu->menu_name == 'user-edit' || $menu->id_menu_function == 2 && $menu->menu_name == 'user-delete') --}}
                        <th>Actions</th>
                        {{-- @endif
                        @endforeach --}}
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="bodyUser">
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
        dataUser();
    });

    function addUser(params) {
        window.location.href = '{{ route('user.add') }}';
    }

    function dataUser(params) {
        console.log('client')
        $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/users/get-user')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)
                var order = "";

                $.each(obj.data, function (k, v) {
                    order += `<tr>
                        <td>${k+1}</td>
                        <td>${v.username}</td>
                        <td>${v.email}</td>
                        <td>${v.roles}</td>
                        <td>${v.last_login}</td>
                        <td>${v.created_at}</td>

                        <td>
                            <div class="d-flex">
                                @foreach(session('akses') as $menu)

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'user-edit')
                                <a href="javascript:void(0);" onclick=edituser(${v.id}) class="me-4 action"><i class="bx bx-edit" style='color:#decb20'></i></a>
                                @endif

                                @if($menu->id_menu_function == 2 && $menu->menu_name == 'user-delete')
                                <a href="javascript:void(0);" onclick=deleted(${v.id}) class="action"><i class="bx bxs-trash-alt" style='color:#fb0303'></i></a>
                                @endif

                                @endforeach
                            </div>
                        </td>
                      </tr>`;
                });

                $('#bodyUser').html(order);
                $('#user').DataTable({
                    "scrollX": true,
                });

            } //ajax post data
        });
    }

    function edituser(id) {
        window.location.href = '/users/detail/'+id;
    }

    function deleted(id) {

event.preventDefault();
swal({
        title: "",
        text: "Apa anda yakin untuk menghapus data user",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: "{{url('/users/delete')}}",
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
                            $('#user').DataTable().destroy();
                            dataUser();
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
