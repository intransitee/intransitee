@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
      <span class="text-muted fw-light">Forms/</span> Add Role
    </h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add Role</h5>
          </div>
          <div class="card-body">
            <form id="addrole">
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <input type="text" class="form-control" id="role">
                </div>
              <button type="button" onclick="addRole()" class="btn btn-primary validasi">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@stop
@section('fungsi')
<script type="text/javascript">
    $(document).ready(function () {

    });

    function addRole(params) {
        var	role = $('#role').val();

        $('.validasi').addClass('disabled')

        $.ajax({
            type: "POST",
            url: "{{url('/roles/insert')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                role:role,
            },
            dataType: "text",
            success: function(data){
            var json = data;
            obj = JSON.parse(json);

            if (obj.status == true) {
                $("#addrole")[0].reset();
                $('.validasi').removeClass('disabled')
                window.location.href = '{{ route('role.role') }}';
            } else {
                $("#addrole")[0].reset();
                $('.validasi').removeClass('disabled')
            }

            }//ajax post data
		});
    }

</script>
@stop
