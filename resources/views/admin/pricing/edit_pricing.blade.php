@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="breadcrumb-wrapper py-3 mb-4">
            <span class="text-muted fw-light">Forms/</span> Add pricing
        </h4>

        <!-- Basic Layout -->
        <input type="hidden" value="{{ Request::segment(3) }}" id="id_pricing">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit pricing</h5>
                    </div>
                    <div class="card-body">
                        <form id="editpricing">
                            <div class="mb-3">
                                <label class="form-label" for="service">Service</label>
                                <select class="form-select" id="service" aria-label="Default select example">
                                    <option selected disabled>Pilih Service</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="type">Type</label>
                                <select class="form-select" id="type" aria-label="Default select example">
                                    <option selected disabled>Pilih Type</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="zipcode">Zip code</label>
                                <select class="form-select" id="zipcode" aria-label="Default select example"
                                    onchange="getProvince()">
                                    <option selected disabled>Pilih zipcode</option>
                                </select>
                                <small style="color: red">Fill zipcode to update province, area, district &
                                    subdistrict</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="province">Province</label>
                                <select class="form-select" id="province" aria-label="Default select example"
                                    onchange="getArea()">
                                    <option selected disabled>Pilih province</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="area">Area</label>
                                <select class="form-select" id="area" aria-label="Default select example"
                                    onchange="getDistrict()">
                                    <option selected disabled>Pilih area</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="district">District</label>
                                <select class="form-select" id="district" aria-label="Default select example"
                                    onchange="getSubDistrict()">
                                    <option selected disabled>Pilih district</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="subdistrict">Subdistrict</label>
                                <select class="form-select" id="subdistrict" aria-label="Default select example">
                                    <option selected disabled>Pilih subdistrict</option>
                                </select>
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
            $(document).ready(function() {
                edit();
                service();
                type();
                zipcode();
            });

            function edit() {
                var id = $('#id_pricing').val();
                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: `{{ url('/pricings/get_edit_detail/${id}') }}`,
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);
                        console.log(obj)
                        $('#service').val(obj.data[0].id_service);
                        $('#type').val(obj.data[0].id_type);
                        $('#zipcode').val(obj.data[0].postal_code);
                        $('#province').val(obj.data[0].id_province);
                        $('#area').val(obj.data[0].id_area);
                        $('#district').val(obj.data[0].id_district);
                        $('#subdistrict').val(obj.data[0].id_subdistrict);

                    } //ajax post data
                });
            }

            function getProvince(params) {
                var zipcode = $('#zipcode').val();

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: `{{ url('/getProvince/${zipcode}') }}`,
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var province = '';

                        province += `<option value="0">Pilih Province</option>`;

                        $.each(obj.data, function(k, v) {
                            province += `<option value="${v.id_province}">${v.province}</option>`
                        });

                        $('#province').html(province);
                    } //ajax post data
                });
            }

            function getArea(params) {
                var zipcode = $('#zipcode').val();
                var province = $('#province').val();
                console.log(province);
                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: `{{ url('/getAreaByProvince/${province}/${zipcode}') }}`,
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var area = '';

                        area += `<option value="0">Pilih Area</option>`;

                        $.each(obj.data, function(k, v) {
                            area += `<option value="${v.id_area}">${v.area}</option>`
                        });

                        $('#area').html(area);
                    } //ajax post data
                });
            }

            function getDistrict(params) {
                var zipcode = $('#zipcode').val();
                var province = $('#province').val();
                var area = $('#area').val();

                console.log(province);

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: `{{ url('/getDistrictByArea/${zipcode}/${province}/${area}') }}`,
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var district = '';

                        district += `<option value="0">Pilih District</option>`;

                        $.each(obj.data, function(k, v) {
                            district += `<option value="${v.id_district}">${v.district}</option>`
                        });

                        $('#district').html(district);
                    } //ajax post data
                });
            }

            function getSubDistrict(params) {
                var zipcode = $('#zipcode').val();
                var province = $('#province').val();
                var area = $('#area').val();
                var district = $('#district').val();

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: `{{ url('/getSubDistrictByArea/${zipcode}/${province}/${area}/${district}') }}`,
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var subdistrict = '';

                        subdistrict += `<option value="0">Pilih Subdistrict</option>`;

                        $.each(obj.data, function(k, v) {
                            subdistrict += `<option value="${v.id_subdistrict}">${v.subdistrict}</option>`
                        });

                        $('#subdistrict').html(subdistrict);
                    } //ajax post data
                });
            }

            function type() {

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/getType') }}",
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var type = '';

                        $.each(obj.data, function(k, v) {
                            type += `<option value="${v.id}">${v.type}</option>`
                        });

                        $('#type').append(type);
                    } //ajax post data
                });
            }

            function zipcode() {

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/reffZipcode') }}",
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var zipcode = '';

                        $.each(obj.data, function(k, v) {
                            zipcode += `<option value="${v.postal_code}">${v.postal_code}</option>`
                        });

                        $('#zipcode').append(zipcode);
                    } //ajax post data
                });
            }

            function service() {

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/reffService') }}",
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var service = '';

                        $.each(obj.data, function(k, v) {
                            service += `<option value="${v.id}">${v.service}</option>`
                        });

                        $('#service').append(service);
                    } //ajax post data
                });
            }

            function addClient(params) {

                var id = $('#id_pricing').val();
                var service = $('#service').val();
                var type = $('#type').val();
                var zipcode = $('#zipcode').val();
                var province = $('#province').val();
                var area = $('#area').val();
                var district = $('#district').val();
                var subdistrict = $('#subdistrict').val();

                $('.validasi').addClass('disabled')

                $.ajax({
                    type: "POST",
                    url: "{{ url('/pricings/update') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        service: service,
                        type: type,
                        zipcode: zipcode,
                        province: province,
                        area: area,
                        district: district,
                        subdistrict: subdistrict
                    },
                    dataType: "text",
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        if (obj.status == true) {
                            $("#editpricing")[0].reset();
                            $('.validasi').removeClass('disabled')
                            window.location.href = '{{ route('pricing.list_pricing') }}';
                        } else {
                            $("#editpricing")[0].reset();
                            $('.validasi').removeClass('disabled')
                        }

                    } //ajax post data
                });
            }
        </script>
    @stop
