@section('content')

    <style>
        /* .select2-container {
                                                                                                                                                                width: 100% !important;
                                                                                                                                                                background-color: #283144;
                                                                                                                                                            }

                                                                                                                                                            .select2-search--dropdown .select2-search__field {
                                                                                                                                                                width: 100%;
                                                                                                                                                                background-color: #283144;
                                                                                                                                                            }

                                                                                                                                                            .select2-selection__rendered {
                                                                                                                                                                line-height: 31px !important;
                                                                                                                                                            }

                                                                                                                                                            .select2-container .select2-selection--single {
                                                                                                                                                                height: 35px !important;
                                                                                                                                                                background-color: #283144;
                                                                                                                                                            }

                                                                                                                                                            .select2-selection__arrow {
                                                                                                                                                                height: 34px !important;
                                                                                                                                                            }

                                                                                                                                                            .select2-container--default .select2-selection--multiple {
                                                                                                                                                                background-color: #283144;
                                                                                                                                                            }

                                                                                                                                                            .select2-search {
                                                                                                                                                                background-color: #283144;
                                                                                                                                                            }

                                                                                                                                                            .select2-search input {
                                                                                                                                                                background-color: #283144;
                                                                                                                                                            }

                                                                                                                                                            .select2-results {
                                                                                                                                                                background-color: #283144;
                                                                                                                                                            } */

    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="breadcrumb-wrapper py-3 mb-4">
            <span class="text-muted fw-light">Forms/</span> Add order
        </h4>

        <!-- Basic Layout -->
        @if (session('client') != 0)
            <input type="hidden" value="{{ session('client') }}" id="myClient">
        @endif
        <input type="hidden" value="{{ session('client') }}" id="is_client">
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
                                    <select class="select2 form-select form-select-lg" id="id_client"
                                        aria-label="Default select example" data-allow-clear="true">
                                        <option selected disabled>Pilih Client</option>
                                    </select>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="id_type" class="form-label">Type</label>
                                <select class="select2 form-select form-select-lg" id="id_type"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option selected disabled>Pilih Type</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_service" class="form-label">Service</label>
                                <select class="select2 form-select form-select-lg" id="id_service"
                                    aria-label="Default select example" onchange="provClient()" data-allow-clear="true">
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
                                <label for="shipper_pricing_area" class="form-label">Shipper Pricing Area</label>
                                <select class="select2 form-select form-select-lg" id="shipper_pricing_area"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option selected disabled>Choose a pricing area</option>
                                </select>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="shipper_zipcode" class="form-label">Shipper zipcode</label>
                                <select class="form-select" id="shipper_zipcode" aria-label="Default select example"
                                    onchange="ShipArea(this);">
                                    <option selected disabled>Pilih Zipcode</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="shipper_area" class="form-label">Shipper area</label>
                                <select class="form-select" id="shipper_area" aria-label="Default select example"
                                    onchange="ShipDistrict(this);">
                                    <option selected disabled>Pilih area</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="shipper_district" class="form-label">Shipper district</label>
                                <select class="form-select" id="shipper_district" aria-label="Default select example">
                                    <option selected disabled>Pilih district</option>
                                </select>
                            </div> --}}
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
                                <label for="recipient_pricing_area" class="form-label">Shipper Pricing Area</label>
                                <select class="select2 form-select form-select-lg" id="recipient_pricing_area"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option selected disabled>Choose a pricing area</option>
                                </select>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="recipient_zipcode" class="form-label">Recipient zipcode</label>
                                <select class="form-select" id="recipient_zipcode" aria-label="Default select example"
                                    onchange="RecipArea(this);">
                                    <option selected disabled>Pilih Zipcode</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="recipient_area" class="form-label">Recipient area</label>
                                <select class="form-select" id="recipient_area" aria-label="Default select example"
                                    onchange="RecipDistrict(this);">
                                    <option selected disabled>Pilih Area</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="recipient_district" class="form-label">Recipient district</label>
                                <select class="form-select" id="recipient_district" aria-label="Default select example">
                                    <option selected disabled>Pilih Area</option>
                                </select>
                            </div> --}}
                            <div class="mb-3">
                                <label for="weight" class="form-label">Weight</label>
                                <input type="text" class="form-control" id="weight">
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Delivery Fee</label>
                                <div class="input-group">
                                    <input type="hidden" id="is_akumulasi" value="0">
                                    <input type="text" class="form-control" id="delivery_fee" placeholder="Delivery Fee"
                                        aria-label="Delivery Fee" aria-describedby="button-addon2" />
                                    <div id="akmls">
                                        <button class="btn btn-outline-primary get_akumulasi"
                                            onclick="akumulasi_delivery_fee()" type="button"
                                            id="button-addon2">Akumulasikan</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="value_of_goods" class="form-label">Value of goods</label>
                                <input type="text" class="form-control" onkeypress="return hanyaAngka(event)"
                                    id="value_of_goods">
                            </div>
                            <div class="mb-3">
                                <label for="is_cod" class="form-label">Is cod</label>
                                <select class="form-select" id="is_cod" aria-label="Default select example"
                                    onchange="iscod()">
                                    <option selected disabled>Is cod</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="is_insured" class="form-label">Is insured</label>
                                <select class="form-select" id="is_insured" aria-label="Default select example"
                                    onchange="isinsurance()">
                                    <option selected disabled>Is insured</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="insurance_fee" class="form-label">Insurance fee</label>
                                <input type="text" class="form-control" id="insurance_fee" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="cod_fee" class="form-label">Cod fee</label>
                                <input type="text" class="form-control" id="cod_fee" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="total_fee" class="form-label">Total fee</label>
                                {{-- <input type="text" class="form-control" id="total_fee"> --}}
                                <input type="hidden" id="is_akumulasi_total" value="0">
                                <input type="text" class="form-control" id="total_fee" placeholder="total_fee"
                                    aria-label="Delivery Fee" aria-describedby="button-addon2" readonly />
                                <button class="btn btn-outline-primary" onclick="hitung_total()" type="button"
                                    id="button-addon2">Akumulasikan</button>
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

        <script src="{{ asset('sweetalert/sweetalert.min.js') }}"></script>
    @stop
    @section('fungsi')
        <script type="text/javascript">
            $(document).ready(function() {
                client();
                service();
                zipcode();
                type();

                // INIT SELECT2
                $('#id_client').select2({
                    width: 'resolve' // need to override the changed default
                });
            });

            function provClient(params) {
                var is_client = $('#is_client').val();

                if (is_client != 0) {
                    var id_client = $('#myClient').val();
                } else {
                    var id_client = $('#id_client').val();
                }

                var id_type = $('#id_type').val();
                var id_service = $('#id_service').val();

                if (id_type == null) {
                    swal("", "Silahkan pilih client, Type & Service terlebih dahulu", "error");
                    return;
                }

                if (id_client == null) {
                    swal("", "Silahkan pilih client, Type & Service terlebih dahulu", "error");
                    return;
                }

                if (id_service == null) {
                    swal("", "Silahkan pilih client, Type & Service terlebih dahulu", "error");
                    return;
                }

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/provclient') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_service: id_service,
                        id_client: id_client,
                        id_type: id_type
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);
                        console.log(obj)
                        if (obj.status == true) {
                            var pricing = '';
                            pricing +=
                                `<option value="">===Choose a pricing===</option>`
                            $.each(obj.data, function(k, v) {
                                pricing +=
                                    `<option value="${v.id}#${v.price}">${v.nama_provinsi} - ${v.nama_kota} - ${v.nama_kecamatan} - ${v.kelurahan} - ${v.kode_pos}</option>`
                            });

                            $('#shipper_pricing_area').html(pricing);
                            $('#recipient_pricing_area').html(pricing);
                        } else {
                            swal("", "Tidak ada area yang terdaftar berdasarkan type & service pada client",
                                "error");
                        }


                    } //ajax post data
                });

            }

            function id_type(params) {
                var tipe = $('#id_type').val();

                // if (tipe == 3) {

                // }
            }

            function hitung_total(params) {

                var cod_fee = $('#cod_fee').val();
                var insurance_fee = $('#insurance_fee').val();
                var delivery_fee = $('#delivery_fee').val();
                if (!cod_fee) {
                    var cod_fee = 0;
                } else {
                    var cod_fee = $('#cod_fee').val();
                }

                if (!insurance_fee) {
                    var insurance_fee = 0;
                } else {
                    var insurance_fee = $('#insurance_fee').val();
                }

                var res = parseInt(cod_fee) + parseInt(insurance_fee) + parseInt(delivery_fee);
                $('#total_fee').val(res);
                $('#is_akumulasi_total').val(1);
            }

            function reset_akumulasi(params) {
                var bt_akumulasi =
                    '<button class="btn btn-outline-primary get_akumulasi" onclick="akumulasi_delivery_fee()" type="button" id="button-addon2">Akumulasikan</button>'
                $('#delivery_fee').val(0);
                $('#akmls').html(bt_akumulasi);
            }

            function akumulasi_delivery_fee(params) {

                var type = $('#id_type').val();
                var pricing = '';

                if (type == 3) {
                    var client_price = $('#shipper_pricing_area').val();
                    var price = client_price.split('#');

                    pricing += price[1];
                } else {
                    var client_price = $('#recipient_pricing_area').val();
                    var price = client_price.split('#');

                    pricing += price[1];
                }

                var weight = $('#weight').val();

                var res = parseInt(weight) * parseInt(pricing);
                console.log(formatMoney(res))
                $('#delivery_fee').val(res);
                $('#is_akumulasi').val(1);

                var bt_akumulasi =
                    '<button class="btn btn-outline-danger get_akumulasi" onclick="reset_akumulasi()" type = "button" id="button-addon2">Reset</button>'

                $('#akmls').html(bt_akumulasi);
            }

            function iscod(params) {
                var cod = $('#is_cod').val();
                var id_client = $('#id_client').val();

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/orders/calculate_cod_fee') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        is_cod: cod,
                        id_client: id_client,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        if (obj.status == true) {
                            var vgood = parseInt($('#value_of_goods').val());
                            var cod_fee = obj.data.cod_fee;

                            var res = cod_fee / 100 * vgood;
                            $('#cod_fee').val(res);
                        } else {
                            $('#cod_fee').val(0);
                        }
                    } //ajax post data
                });
            }

            function isinsurance(params) {
                var insurance = $('#is_insured').val();
                var id_client = $('#id_client').val();

                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/orders/calculate_insurance_fee') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        insurance: insurance,
                        id_client: id_client,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        if (obj.status == true) {
                            var vgood = parseInt($('#value_of_goods').val());
                            var insurance = obj.data.insurance_fee;

                            var res = insurance / 100 * vgood;
                            $('#insurance_fee').val(res);
                        } else {
                            $('#insurance_fee').val(0);
                        }
                    } //ajax post data
                });
            }

            function client() {
                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/reffClient') }}",
                    type: "get",
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var client = '';

                        $.each(obj.data, function(k, v) {
                            client += `<option value="${v.id}">${v.account_name}</option>`
                        });

                        $('#id_client').append(client);
                    } //ajax post data
                });
            }

            function zipcode() {
                var client = $('#myClient').val();
                $.ajax({
                    processing: true,
                    serverSide: true,
                    url: "{{ url('/reffZipcode') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        client: client,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var shipper = '';

                        $.each(obj.data, function(k, v) {
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
                    url: "{{ url('/getArea') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        zipcode: zipcode,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var area = '';

                        $.each(obj.data, function(k, v) {
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
                    url: "{{ url('/getDistrict') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        area: area,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var district = '';

                        $.each(obj.data, function(k, v) {
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
                    url: "{{ url('/getDistrict') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        area: area,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var district = '';

                        $.each(obj.data, function(k, v) {
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
                    url: "{{ url('/getArea') }}",
                    type: "get",
                    data: {
                        _token: "{{ csrf_token() }}",
                        zipcode: zipcode,
                    },
                    context: document.body,
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        var area = '';

                        $.each(obj.data, function(k, v) {
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

                        $('#id_service').append(service);
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

                        $('#id_type').append(type);
                    } //ajax post data
                });
            }

            function addOrder(params) {
                var reff_id = $('#reff_id').val();
                var id_client = $('#id_client').val();
                var id_type = $('#id_type').val();
                var id_service = $('#id_service').val();
                var shipper_name = $('#shipper_name').val();
                var shipper_phone = $('#shipper_phone').val();
                var shipper_address = $('#shipper_address').val();
                var shipper_zipcode = $('#shipper_zipcode').val();
                var shipper_area = $('#shipper_area').val();
                var shipper_district = $('#shipper_district').val();
                var recipient_name = $('#recipient_name').val();
                var recipient_phone = $('#recipient_phone').val();
                var recipient_address = $('#recipient_address').val();
                var recipient_zipcode = $('#recipient_zipcode').val();
                var recipient_area = $('#recipient_area').val();
                var recipient_district = $('#recipient_district').val();
                var weight = $('#weight').val();
                var value_of_goods = $('#value_of_goods').val();
                var is_cod = $('#is_cod').val();
                var is_insured = $('#is_insured').val();
                var insurance_fee = $('#insurance_fee').val();
                var cod_fee = $('#cod_fee').val();
                var total_fee = $('#total_fee').val();
                var collection_date = $('#collection_date').val();
                var delivery_date = $('#delivery_date').val();
                var is_akumulasi = $('#is_akumulasi').val();
                var is_akumulasi_total = $('#is_akumulasi_total').val();
                var delivery_fee = $('#delivery_fee').val();
                var shipper_pricing_area = $('#shipper_pricing_area').val();
                var recipient_pricing_area = $('#recipient_pricing_area').val();

                if (is_akumulasi == 0) {
                    swal('', 'Delivery fee wajib di akumulasikan', 'error');
                }

                if (is_akumulasi_total == 0) {
                    swal('', 'Total fee wajib di akumulasikan', 'error');
                }

                // $('.validasi').addClass('disabled')

                $.ajax({
                    type: "POST",
                    url: "{{ url('/orders/insert') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        reff_id: reff_id,
                        id_client: id_client,
                        id_type: id_type,
                        id_service: id_service,
                        shipper_name: shipper_name,
                        shipper_phone: shipper_phone,
                        shipper_address: shipper_address,
                        shipper_pricing_area: shipper_pricing_area,
                        recipient_name: recipient_name,
                        recipient_phone: recipient_phone,
                        recipient_address: recipient_address,
                        recipient_pricing_area: recipient_pricing_area,
                        delivery_fee: delivery_fee,
                        weight: weight,
                        value_of_goods: value_of_goods,
                        is_cod: is_cod,
                        is_insured: is_insured,
                        insurance_fee: insurance_fee,
                        cod_fee: cod_fee,
                        total_fee: total_fee,
                        collection_date: collection_date,
                        delivery_date: delivery_date,
                    },
                    dataType: "text",
                    success: function(data) {
                        var json = data;
                        obj = JSON.parse(json);

                        if (obj.status == true) {
                            $("#addorder")[0].reset();
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
                                    window.location.href = '{{ route('order.order') }}';
                                }
                            });
                        } else {
                            $("#addorder")[0].reset();
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
