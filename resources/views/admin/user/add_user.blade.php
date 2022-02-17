@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
      <span class="text-muted fw-light">Forms/</span> Add User
    </h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add User</h5>
          </div>
          <div class="card-body">
            <form id="adduser">
                <div class="mb-3">
                    <label for="username" class="form-label">username</label>
                    <input type="text" class="form-control" id="username">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="mb-3">
                    <label for="roles" class="form-label">Roles</label>
                    <select class="form-select" id="roles" onchange="isCustomer(this);" aria-label="Default select example">
                      <option selected disabled>Pilih roles</option>
                    </select>
                </div>
                <div class="mb-3" id="field_client" style="display: none">
                    <label for="client" class="form-label">Client</label>
                    <select class="form-select" id="client" aria-label="Default select example">
                      <option selected disabled>Pilih client</option>
                    </select>
                    <small style="color: red">*Silahkan pilih salah satu client yang akan dipegang oleh customer</small>
                </div>
              <button type="button" onclick="addUser()" class="btn btn-primary validasi">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@stop
@section('fungsi')
<script type="text/javascript">
    $(document).ready(function () {
        roles();
    });

    function editUser(id) {
        window.location.href = '/orders/detail/'+id;
    }

    function isCustomer(params) {
        var role = $('#roles').val();
        var client = '';

        if (role == 3) {
            $('#field_client').show();

            $.ajax({
                processing: true,
                serverSide: true,
                url: "{{url('/reffClient')}}",
                type: "get",
                context: document.body,
                success: function (data) {
                    var json = data;
                    obj = JSON.parse(json);
                    console.log(obj)

                    var	client = '';

                    $.each(obj.data, function (k, v) {
                        client += `<option value="${v.id}">${v.account_name}</option>`
                    });

                    $('#client').append(client);
                } //ajax post data
            });
        }else{
            $('#field_client').hide();
            var	client = '<option selected disabled>Pilih client</option>';
            $('#client').html(client);
        }
    }

   function roles() {
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/reffRoles')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);

                var	roles = '';

                $.each(obj.data, function (k, v) {
                    roles += `<option value="${v.id}">${v.roles}</option>`
                });

                $('#roles').append(roles);
            } //ajax post data
        });
   }

    function addUser(params) {
        var	username = $('#username').val();
        var	email = $('#email').val();
        var	password = $('#password').val();
        var	roles = $('#roles').val();
        var client = $('#client').val();

        $('.validasi').addClass('disabled')

        $.ajax({
            type: "POST",
            url: "{{url('/users/insert')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                username:username,
                email:email,
                password:password,
                roles:roles,
                client: client
            },
            dataType: "text",
            success: function(data){
            var json = data;
            obj = JSON.parse(json);

            if (obj.status == true) {
                $("#adduser")[0].reset();
                $('.validasi').removeClass('disabled')
                window.location.href = '{{ route('user.user') }}';
            } else {
                $("#adduser")[0].reset();
                $('.validasi').removeClass('disabled')
            }

            }//ajax post data
		});
    }

</script>
@stop
