@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="breadcrumb-wrapper py-3 mb-4">
            <span class="text-muted fw-light">Forms/</span> Add pricing
        </h4>

        <!-- Basic Layout -->
        <input type="hidden" value="{{ Request::segment(3) }}" id="id_client">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Add pricing</h5>
                    </div>
                    <div class="card-body">
                        <form id="addpricing">
                            <div class="mb-3">
                                <label class="form-label" for="client">Client</label>
                                <select class="form-select" id="client" aria-label="Default select example">
                                    <option selected disabled>Pilih Client</option>
                                </select>
                                <small style="color: red">Field client is auto by sistem</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="service">Service</label>
                                <select class="select2 form-select form-select-lg" id="service"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option selected disabled>Pilih Service</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="type">Type</label>
                                <select class="select2 form-select form-select-lg" id="type"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option selected disabled>Pilih Type</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="province">Province</label>
                                <select class="select2 form-select form-select-lg" id="province"
                                    aria-label="Default select example" data-allow-clear="true" onchange="getKota()">
                                    <option selected disabled>Pilih province</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="city">City</label>
                                <select class="select2 form-select form-select-lg" id="city"
                                    aria-label="Default select example" data-allow-clear="true" onchange="getDistrict()">
                                    <option selected disabled>Choose a city</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="district">District</label>
                                <select class="select2 form-select form-select-lg" id="district"
                                    aria-label="Default select example" data-allow-clear="true" onchange="getSubDistrict()">
                                    <option selected disabled>Choose a district</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="subdistrict">Subdistrict</label>
                                <select class="select2 form-select form-select-lg" id="subdistrict"
                                    aria-label="Default select example" data-allow-clear="true" onchange="getKodepos()">
                                    <option selected disabled>Choose a subdistrict</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="kodepos">Postal Code</label>
                                <select class="select2 form-select form-select-lg" id="kodepos"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option selected disabled>Choose a postal code</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="pricing">Pricing</label>
                                <input type="text" class="form-control" id="pricing">
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
                client();
                service();
                type();
                province();
            });

            function client() {
                var id_client = $('#id_client').val();
                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/reffClient') }}",
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var pricing = '';

                        $.each(obj.data, function(k, v) {
                            pricing += `<option value="${v.id}" disabled>${v.account_name}</option>`
                        });

                        $('#client').append(pricing);
                        $('#client').val(id_client);

                    } //ajax post data
                });
            }

            function getKota(params) {
                var provinsi = $('#province').val();
                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: `{{ url('/reff_kota') }}`,
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        provinsi: provinsi,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);
                        console.log(obj);
                        var kota = '';

                        kota += `<option value="0">Choose a city</option>`;

                        $.each(obj.data, function(k, v) {
                            kota += `<option value="${v.id_kota}">${v.nama_kota}</option>`
                        });

                        $('#city').html(kota);
                    } //ajax post data
                });
            }

            function getDistrict(params) {
                var kota = $('#city').val();
                console.log(kota)
                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: `{{ url('/reff_kecamatan') }}`,
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kota: kota,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var district = '';

                        district += `<option value="0">Choose a district</option>`;

                        $.each(obj.data, function(k, v) {
                            district += `<option value="${v.id_kecamatan}">${v.nama_kecamatan}</option>`
                        });

                        $('#district').html(district);
                    } //ajax post data
                });
            }

            function getSubDistrict(params) {
                var kecamatan = $('#district').val();

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: `{{ url('/reff_kelurahan') }}`,
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kecamatan: kecamatan,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var subdistrict = '';

                        subdistrict += `<option value="0">Choose a subdistrict</option>`;

                        $.each(obj.data, function(k, v) {
                            subdistrict += `<option value="${v.id_kelurahan}">${v.kelurahan}</option>`
                        });

                        $('#subdistrict').html(subdistrict);
                    } //ajax post data
                });
            }

            function getKodepos(params) {
                var kelurahan = $('#subdistrict').val();

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: `{{ url('/reff_kodepos') }}`,
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kelurahan: kelurahan,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var kodepos = '';

                        // kodepos += `<option value="0">Choose a postal code</option>`;

                        $.each(obj.data, function(k, v) {
                            kodepos += `<option value="${v.kode_pos}">${v.kode_pos}</option>`
                        });

                        $('#kodepos').html(kodepos);
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

            function province() {

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/reff_provinsi') }}",
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var provinsi = '';

                        $.each(obj.data, function(k, v) {
                            provinsi += `<option value="${v.id_provinsi}">${v.nama_provinsi}</option>`
                        });

                        $('#province').append(provinsi);
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

                var client = $('#id_client').val();
                var service = $('#service').val();
                var type = $('#type').val();
                var province = $('#province').val();
                var kota = $('#city').val();
                var kecamatan = $('#district').val();
                var kelurahan = $('#subdistrict').val();
                var kodepos = $('#kodepos').val();
                var pricing = $('#pricing').val();

                $('.validasi').addClass('disabled')

                $.ajax({
                    type: "POST",
                    url: "{{ url('/pricings/insert') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        client: client,
                        service: service,
                        type: type,
                        province: province,
                        kota: kota,
                        kecamatan: kecamatan,
                        kelurahan: kelurahan,
                        kodepos: kodepos,
                        pricing: pricing
                    },
                    dataType: "text",
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        if (obj.status == true) {
                            $("#addpricing")[0].reset();
                            $('.validasi').removeClass('disabled')

                            Swal.fire({
                                text: obj.message,
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then(okay => {
                                if (okay) {
                                    window.history.back();
                                }
                            });
                        } else {
                            $("#addpricing")[0].reset();
                            $('.validasi').removeClass('disabled')

                            Swal.fire({
                                text: obj.message,
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                        }

                    } //ajax post data
                });
            }
        </script>
    @stop
