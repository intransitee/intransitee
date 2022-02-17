@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
      <span class="text-muted fw-light">Forms/</span> Add Access
    </h4>

    <!-- Basic Layout -->
    <div class="row">
    <input type="hidden" id="id_role" value="{{$id_role}}">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add Access</h5>
          </div>
          <div class="card-body">
            <form id="addmenu">
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" aria-label="Default select example">
                        <option selected disabled>Pilih Role</option>
                    </select>
                    <small style="color: red">Field role is auto by sistem</small>
                </div>
                <div class="mb-3">
                    <label for="menu_function" class="form-label">Menu Function</label>
                    <select class="form-select" id="menu_function" aria-label="Default select example">
                        <option selected disabled>Pilih Menu Function</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="menu_name" class="form-label">Menu Name</label>
                    <input type="text" class="form-control" id="menu_name">
                </div>
              <button type="button" onclick="addMenu()" class="btn btn-primary validasi">Simpan</button>
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
        menu_function();
    });

    function roles() {
    var id = $('#id_role').val();
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/reffRoles')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	roles = '';

                $.each(obj.data, function (k, v) {
                    roles += `<option disabled value="${v.id}">${v.roles}</option>`
                });

                $('#role').append(roles);
                $('#role').val(id);
            } //ajax post data
        });
   }

    function menu_function() {
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/reffMenuFunction')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	menu_function = '';

                $.each(obj.data, function (k, v) {
                    menu_function += `<option value="${v.id}">${v.deskripsi}</option>`
                });

                $('#menu_function').append(menu_function);
            } //ajax post data
        });
   }

    function addMenu(params) {
        var id = $('#id_role').val();
        var	menu_function = $('#menu_function').val();
        var	menu_name = $('#menu_name').val();

        $('.validasi').addClass('disabled')

        $.ajax({
            type: "POST",
            url: "{{url('/menus/insert')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                role:id,
                menu_function:menu_function,
                menu_name:menu_name,
            },
            dataType: "text",
            success: function(data){
            var json = data;
            obj = JSON.parse(json);

            if (obj.status == true) {
                $("#addmenu")[0].reset();
                $('.validasi').removeClass('disabled')
                window.history.back();
            } else {
                $("#addmenu")[0].reset();
                $('.validasi').removeClass('disabled')
            }

            }//ajax post data
		});
    }

</script>
@stop
