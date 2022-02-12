@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
      <span class="text-muted fw-light">Forms/</span> Edit client
    </h4>
    <input type="hidden" id="id_client" value="{{$id}}">
    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit client</h5>
          </div>
          <div class="card-body">
            <form id="addclient">
              <div class="mb-3">
                <label class="form-label" for="account_name">Account name</label>
                <input type="text" class="form-control" id="account_name" placeholder="John Doe" />
              </div>
              <div class="mb-3">
                <label class="form-label" for="client_category">Client category</label>
                <input type="text" class="form-control" id="client_category" placeholder="ACME Inc." />
              </div>
              <div class="mb-3">
                <label class="form-label" for="pic_email">Pic email</label>
                <input type="text" class="form-control" id="pic_email" placeholder="xyz@gmail.com" />
              </div>
              <div class="mb-3">
                <label class="form-label" for="pic_name">Pic name</label>
                <input type="text" class="form-control" id="pic_name" placeholder="Xyz" />
              </div>
              <div class="mb-3">
                <label class="form-label" for="pic_number">Pic number</label>
                <input type="text" class="form-control" id="pic_number" placeholder="08777xxx" />
              </div>
              <div class="mb-3">
                <label class="form-label" for="sales_agent">Sales Agent</label>
                <input type="text" class="form-control" id="sales_agent" placeholder="Agent zyx" />
              </div>
              <div class="mb-3">
                <label class="form-label" for="cod_fee">Cod Fee</label>
                <input type="text" class="form-control" id="cod_fee" placeholder="8%" />
              </div>
              <div class="mb-3">
                <label class="form-label" for="insurance_fee">Insurance Fee</label>
                <input type="text" class="form-control" id="insurance_fee" placeholder="10%" />
              </div>
              <button type="button" onclick="updateClient()" class="btn btn-primary validasi">Simpan</button>
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

        var id_client = $('#id_client').val();

        $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/clients/detail-client')}}",
            type: "get",
            data: {
                _token: "{{ csrf_token() }}",
                id: id_client,
            },
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj.data)

                var	account_name = $('#account_name').val(obj.data.account_name);
                var	client_category = $('#client_category').val(obj.data.clients_category);
                var	pic_email = $('#pic_email').val(obj.data.pic_email);
                var	pic_name = $('#pic_name').val(obj.data.pic_name);
                var	pic_number = $('#pic_number').val(obj.data.pic_number);
                var	sales_agent = $('#sales_agent').val(obj.data.sales_agent);
                var	cod_fee = $('#cod_fee').val(obj.data.cod_fee);
                var	insurance_fee = $('#insurance_fee').val(obj.data.insurance_fee);

            } //ajax post data
        });
    }

    function updateClient(params) {
        var id_client = $('#id_client').val();
        var	account_name = $('#account_name').val();
        var	client_category = $('#client_category').val();
        var	pic_email = $('#pic_email').val();
        var	pic_name = $('#pic_name').val();
        var	pic_number = $('#pic_number').val();
        var	sales_agent = $('#sales_agent').val();
        var	cod_fee = $('#cod_fee').val();
        var	insurance_fee = $('#insurance_fee').val();

        console.log(account_name)
        console.log(client_category)
        console.log(pic_email)
        console.log(pic_name)
        console.log(pic_number)
        console.log(sales_agent)
        console.log(cod_fee)
        console.log(insurance_fee)

        $('.validasi').addClass('disabled')

        $.ajax({
            type: "POST",
            url: "{{url('/clients/update')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id_client:id_client,
                account_name:account_name,
                client_category:client_category,
                pic_email:pic_email,
                pic_name:pic_name,
                pic_number:pic_number,
                sales_agent:sales_agent,
                cod_fee:cod_fee,
                insurance_fee:insurance_fee
            },
            dataType: "text",
            success: function(data){
            var json = data;
            obj = JSON.parse(json);

            if (obj.status == true) {
                $("#addclient")[0].reset();
                $('.validasi').removeClass('disabled')
                window.location.href = '{{ route('client.client') }}';
            } else {
                $("#addclient")[0].reset();
                $('.validasi').removeClass('disabled')
            }

            }//ajax post data
		});
    }

</script>
@stop
