@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="breadcrumb-wrapper py-3 mb-4">
      <span class="text-muted fw-light">Forms/</span> Add order
    </h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add order</h5>
          </div>
          <div class="card-body">
            <form id="addorder">
                <div class="mb-3">
                    <label for="reff_id" class="form-label">Reff id</label>
                    <input type="text" class="form-control" id="reff_id">
                </div>

                @if (session('role') != 3)
                <div class="mb-3">
                    <label for="id_client" class="form-label">Client</label>
                    <select class="form-select" id="id_client" aria-label="Default select example">
                      <option selected disabled>Pilih Client</option>
                    </select>
                </div>
                @endif

                <div class="mb-3">
                    <label for="id_type" class="form-label">Type</label>
                    <select class="form-select" id="id_type" aria-label="Default select example">
                      <option selected disabled>Pilih Type</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="id_service" class="form-label">Service</label>
                    <select class="form-select" id="id_service" aria-label="Default select example">
                      <option selected disabled>Pilih Service</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="shipper_name" class="form-label">Shipper name</label>
                    <input type="text" class="form-control" id="shipper_name">
                </div>
                <div class="mb-3">
                    <label for="shipper_phone" class="form-label">Shipper phone</label>
                    <input type="text" class="form-control" id="shipper_phone">
                </div>
                <div class="mb-3">
                    <label for="shipper_address" class="form-label">Shipper address</label>
                    <input type="text" class="form-control" id="shipper_address">
                </div>
                <div class="mb-3">
                    <label for="shipper_zipcode" class="form-label">Shipper zipcode</label>
                    <select class="form-select" id="shipper_zipcode" aria-label="Default select example" onchange="ShipArea(this);">
                        <option selected disabled>Pilih Zipcode</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="shipper_area" class="form-label">Shipper area</label>
                    <select class="form-select" id="shipper_area" aria-label="Default select example" onchange="ShipDistrict(this);">
                        <option selected disabled>Pilih area</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="shipper_district" class="form-label">Shipper district</label>
                    <select class="form-select" id="shipper_district" aria-label="Default select example">
                        <option selected disabled>Pilih district</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="recipient_name" class="form-label">Recipient name</label>
                    <input type="text" class="form-control" id="recipient_name">
                </div>
                <div class="mb-3">
                    <label for="recipient_phone" class="form-label">Recipient phone</label>
                    <input type="text" class="form-control" id="recipient_phone">
                </div>
                <div class="mb-3">
                    <label for="recipient_address" class="form-label">Recipient address</label>
                    <input type="text" class="form-control" id="recipient_address">
                </div>
                <div class="mb-3">
                    <label for="recipient_zipcode" class="form-label">Recipient zipcode</label>
                    <select class="form-select" id="recipient_zipcode" aria-label="Default select example" onchange="RecipArea(this);">
                        <option selected disabled>Pilih Zipcode</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="recipient_area" class="form-label">Recipient area</label>
                    <select class="form-select" id="recipient_area" aria-label="Default select example" onchange="RecipDistrict(this);">
                        <option selected disabled>Pilih Area</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="recipient_district" class="form-label">Recipient district</label>
                    <select class="form-select" id="recipient_district" aria-label="Default select example">
                        <option selected disabled>Pilih Area</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight</label>
                    <input type="text" class="form-control" id="weight">
                </div>
                <div class="mb-3">
                    <label for="value_of_goods" class="form-label">Value of goods</label>
                    <input type="text" class="form-control" id="value_of_goods">
                </div>
                <div class="mb-3">
                    <label for="is_cod" class="form-label">Is cod</label>
                    <select class="form-select" id="is_cod" aria-label="Default select example">
                        <option selected disabled>Is cod</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="is_insured" class="form-label">Is insured</label>
                    <select class="form-select" id="is_insured" aria-label="Default select example">
                        <option selected disabled>Is insured</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="insurance_fee" class="form-label">Insurance fee</label>
                    <input type="text" class="form-control" id="insurance_fee">
                </div>
                <div class="mb-3">
                    <label for="cod_fee" class="form-label">Cod fee</label>
                    <input type="text" class="form-control" id="cod_fee">
                </div>
                <div class="mb-3">
                    <label for="total_fee" class="form-label">Total fee</label>
                    <input type="text" class="form-control" id="total_fee">
                </div>
                <div class="mb-3">
                    <label for="collection_date" class="form-label">Collection date</label>
                    <input type="date" class="form-control" id="collection_date">
                </div>
                <div class="mb-3">
                    <label for="delivery_date" class="form-label">Delivery date</label>
                    <input type="date" class="form-control" id="delivery_date">
                </div>
              <button type="button" onclick="addOrder()" class="btn btn-primary validasi">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@stop
@section('fungsi')
<script type="text/javascript">
    $(document).ready(function () {
        client();
        service();
        zipcode();
        type();
    });

   function client() {
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

                $('#id_client').append(client);
            } //ajax post data
        });
   }

   function zipcode() {
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/reffZipcode')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	shipper = '';

                $.each(obj.data, function (k, v) {
                    shipper += `<option value="${v.postal_code}">${v.postal_code}</option>`
                });

                $('#shipper_zipcode').append(shipper);
                $('#recipient_zipcode').append(shipper);
            } //ajax post data
        });
   }

   function ShipArea() {
    var zipcode = $('#shipper_zipcode').val();
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/getArea')}}",
            type: "get",
            data: {
                _token: "{{ csrf_token() }}",
                zipcode: zipcode,
            },
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	area = '';

                $.each(obj.data, function (k, v) {
                    area += `<option value="${v.id_area}">${v.area}</option>`
                });

                $('#shipper_area').append(area);
            } //ajax post data
        });
   }

   function ShipDistrict() {
    var area = $('#shipper_area').val();
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/getDistrict')}}",
            type: "get",
            data: {
                _token: "{{ csrf_token() }}",
                area: area,
            },
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	district = '';

                $.each(obj.data, function (k, v) {
                    district += `<option value="${v.id_district}">${v.district}</option>`
                });

                $('#shipper_district').append(district);
            } //ajax post data
        });
   }

   function RecipDistrict() {
    var area = $('#recipient_area').val();
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/getDistrict')}}",
            type: "get",
            data: {
                _token: "{{ csrf_token() }}",
                area: area,
            },
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	district = '';

                $.each(obj.data, function (k, v) {
                    district += `<option value="${v.id_district}">${v.district}</option>`
                });

                $('#recipient_district').append(district);
            } //ajax post data
        });
   }

   function RecipArea() {
    var zipcode = $('#recipient_zipcode').val();
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/getArea')}}",
            type: "get",
            data: {
                _token: "{{ csrf_token() }}",
                zipcode: zipcode,
            },
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	area = '';

                $.each(obj.data, function (k, v) {
                    area += `<option value="${v.id_area}">${v.area}</option>`
                });

                $('#recipient_area').append(area);
            } //ajax post data
        });
   }

   function service() {
    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/reffService')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	service = '';

                $.each(obj.data, function (k, v) {
                    service += `<option value="${v.id}">${v.service}</option>`
                });

                $('#id_service').append(service);
            } //ajax post data
        });
   }

   function type() {

    $.ajax({
            processing: true,
            serverSide: true,
            url: "{{url('/getType')}}",
            type: "get",
            context: document.body,
            success: function (data) {
                var json = data;
                obj = JSON.parse(json);
                console.log(obj)

                var	type = '';

                $.each(obj.data, function (k, v) {
                    type += `<option value="${v.id}">${v.type}</option>`
                });

                 $('#id_type').append(type);
            } //ajax post data
        });
   }

    function addOrder(params) {
        var	reff_id = $('#reff_id').val();
        var	id_client = $('#id_client').val();
        var	id_type = $('#id_type').val();
        var	id_service = $('#id_service').val();
        var	shipper_name = $('#shipper_name').val();
        var	shipper_phone = $('#shipper_phone').val();
        var	shipper_address = $('#shipper_address').val();
        var	shipper_zipcode = $('#shipper_zipcode').val();
        var	shipper_area = $('#shipper_area').val();
        var	shipper_district = $('#shipper_district').val();
        var	recipient_name = $('#recipient_name').val();
        var	recipient_phone = $('#recipient_phone').val();
        var	recipient_address = $('#recipient_address').val();
        var	recipient_zipcode = $('#recipient_zipcode').val();
        var	recipient_area = $('#recipient_area').val();
        var	recipient_district = $('#recipient_district').val();
        var	weight = $('#weight').val();
        var	value_of_goods = $('#value_of_goods').val();
        var	is_cod = $('#is_cod').val();
        var	is_insured = $('#is_insured').val();
        var	insurance_fee = $('#insurance_fee').val();
        var	cod_fee = $('#cod_fee').val();
        var	total_fee = $('#total_fee').val();
        var	collection_date = $('#collection_date').val();
        var	delivery_date = $('#delivery_date').val();

        console.log(id_client)
        console.log(id_type)
        console.log(id_service)
        console.log(shipper_name)
        console.log(shipper_phone)
        console.log(shipper_address)
        console.log(shipper_zipcode)
        console.log(shipper_area)
        console.log(shipper_district)
        console.log(recipient_name)
        console.log(recipient_phone)
        console.log(recipient_address)
        console.log(recipient_zipcode)
        console.log(recipient_area)
        console.log(recipient_district)
        console.log(weight)
        console.log(value_of_goods)
        console.log(is_cod)
        console.log(is_insured)
        console.log(insurance_fee)
        console.log(cod_fee)
        console.log(total_fee)
        console.log(collection_date)
        console.log(delivery_date)

        $('.validasi').addClass('disabled')

        $.ajax({
            type: "POST",
            url: "{{url('/orders/insert')}}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                reff_id:reff_id,
                id_client:id_client,
                id_type:id_type,
                id_service:id_service,
                shipper_name:shipper_name,
                shipper_phone:shipper_phone,
                shipper_address:shipper_address,
                shipper_zipcode:shipper_zipcode,
                shipper_area:shipper_area,
                shipper_district:shipper_district,
                recipient_name:recipient_name,
                recipient_phone:recipient_phone,
                recipient_address:recipient_address,
                recipient_zipcode:recipient_zipcode,
                recipient_area:recipient_area,
                recipient_district:recipient_district,
                weight:weight,
                value_of_goods:value_of_goods,
                is_cod:is_cod,
                is_insured:is_insured,
                insurance_fee:insurance_fee,
                cod_fee:cod_fee,
                total_fee:total_fee,
                collection_date:collection_date,
                delivery_date:delivery_date,
            },
            dataType: "text",
            success: function(data){
            var json = data;
            obj = JSON.parse(json);

            if (obj.status == true) {
                $("#addorder")[0].reset();
                $('.validasi').removeClass('disabled')
                window.location.href = '{{ route('order.order') }}';
            } else {
                $("#addorder")[0].reset();
                $('.validasi').removeClass('disabled')
            }

            }//ajax post data
		});
    }

</script>
@stop
