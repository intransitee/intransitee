@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
      <span class="text-muted fw-light">Forms/</span> Edit Role
    </h4>
    <input type="hidden" id="id_role" value="{{$id}}">
    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit role</h5>
          </div>
          <div class="card-body">
            <form id="addrole">
                <form id="updateuserform">
                    <div class="mb-3">
                        <label for="role" class="form-label">Roles</label>
                        <input type="text" class="form-control" id="role">
                    </div>
                  <button type="button" onclick="updateRole()" class="btn btn-primary validasi">Simpan</button>
                </form>
          </div>
        </div>
      </div>
    </div>
@stop
@section('fungsi')
<script type="text/javascript">
    $(document).ready(function () {
        loadData();
    });


function loadData(params) {

var id_role = $('#id_role').val();

$.ajax({
    processing: true,
    serverSide: true,
    url: "{{url('/roles/getDetail')}}",
    type: "get",
    data: {
        _token: "{{ csrf_token() }}",
        id: id_role,
    },
    context: document.body,
    success: function (data) {
        var json = data;
        obj = JSON.parse(json);
        console.log(obj.data)

        $('#role').val(obj.data.roles);
    } //ajax post data
});
}

    function updateRole(params) {
        var id = $('#id_role').val();
        var role = $('#role').val();

        $('.validasi').addClass('disabled')

        $.ajax({
            type: "POST",
            url: "{{url('/roles/update')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id:id,
                roles:role,
            },
            dataType: "text",
            success: function(data){
            var json = data;
            obj = JSON.parse(json);

            if (obj.status == true) {
                $('.validasi').removeClass('disabled')
                window.location.href = '{{ route('role.role') }}';
            } else {
                $('.validasi').removeClass('disabled')
            }

            }//ajax post data
		});
    }

</script>
@stop
