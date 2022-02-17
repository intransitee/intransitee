@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
      <span class="text-muted fw-light">Forms/</span> Add client
    </h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add client</h5>
          </div>
          <div class="card-body">
            <form id="addclient">
              <div class="mb-3">
                <label class="form-label" for="account_name">Account name</label>
                <input type="text" class="form-control" id="account_name" placeholder="John Doe" />
              </div>

              <div class="mb-3">
                <label class="form-label" for="client_category">Client category</label>
                <select class="form-select" id="client_category" aria-label="Default select example">
                    <option selected disabled>Pilih Client Category</option>
                  </select>
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
              <button type="button" onclick="addClient()" class="btn btn-primary validasi">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@stop
@section('fungsi')
<script type="text/javascript">
    $(document).ready(function () {
        client_category();
    });

    function client_category() {
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/reffClientCategory')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	category = '';

                $.each(obj.data, function (k, v) {
                    category += `<option value="${v.id}">${v.client_category}</option>`
                });

                $('#client_category').append(category);
            } //ajax post data
        });
   }

    function addClient(params) {
        window.location.href = '{{ route('client.add') }}';
    }

    function addClient(params) {
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
            url: "{{url('/clients/insert')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
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
