@section('content')
    <style>
        .res {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

    </style>

    <input type="hidden" id="id_order" value="{{ Request::segment(3) }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-12 col-md-8 col-xl-9 mb-4 mb-md-0">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div
                            class="d-flex flex-column flex-sm-row flex-md-column flex-xl-row justify-content-between p-0 p-sm-3">
                            <div class="mb-4 mb-xl-0">
                                <div class="svg-illustration gap-2 d-flex mb-3">

                                    <title>icon</title>
                                    <img src="{{ asset('logo/Logo2.png') }}" width="50" alt="">
                                    <span class="app-brand-text h3 fw-bold mb-0">Intransitee</span>
                                </div>
                                <p class="mb-1">Terarah MTH Square GF A4/A, Jl Letjen M.T.</p>
                                <p class="mb-1">Haryono No.Kav 10, Bidara Cina, Kec. Jatinegara</p>
                                <p class="mb-1">Kota Adm. Jakarta Timur, Provinsi DKI Jakarta, Indonesia 13330</p>
                                <p class="mb-0">021-50106260 ext 509</p>
                            </div>
                            <div>
                                <div id="awb">
                                    {{-- <h4>AWB #3492</h4> --}}
                                </div>
                                <div class="mb-2">
                                    <span class="me-1">Collection date:</span>
                                    {{-- <div> --}}
                                    <span class="fw-semibold" id="collection_scheduled_date"></span>
                                    {{-- </div> --}}
                                </div>
                                <div>
                                    <span class="me-1">Delivery date:</span>
                                    {{-- <div> --}}
                                    <span class="fw-semibold" id="delivery_scheduled_date"></span>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row p-0 p-sm-3">
                            <div class="col-12 col-sm-5 col-md-12 col-xl-6 mb-4 mb-sm-0 mb-md-4 mb-xl-0">
                                <h6 class="pb-2">Shipper:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-3">Name:</td>
                                            <td id="shipper_name"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Phone:</td>
                                            <td id="shipper_phone"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Address:</td>
                                            <td id="shipper_address"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Province:</td>
                                            <td id="shipper_provinsi"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">City:</td>
                                            <td id="shipper_kota"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">District:</td>
                                            <td id="shipper_kecamatan"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Subdistrict:</td>
                                            <td id="shipper_kelurahan"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Zipcode:</td>
                                            <td id="shipper_zipcode"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 col-sm-7 col-md-12 col-xl-6">
                                <h6 class="pb-2">Recipient:</h6>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-3">Name:</td>
                                            <td id="recip_name"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Phone:</td>
                                            <td id="recip_phone"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Address:</td>
                                            <td id="recip_address"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Province:</td>
                                            <td id="recip_provinsi"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">City:</td>
                                            <td id="recip_kota"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">District:</td>
                                            <td id="recip_kecamatan"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Subdistrict:</td>
                                            <td id="recip_kelurahan"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-3">Zipcode:</td>
                                            <td id="recip_zipcode"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table border-top m-0">
                            <thead>
                                <tr>
                                    <th>Weight</th>
                                    <th>Value of goods</th>
                                    <th>Is Insured</th>
                                    <th>Is Cod</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-nowrap" id="weight"></td>
                                    <td class="text-nowrap" id="value_of_goods"></td>
                                    <td id="is_insured"></td>
                                    <td id="is_cod"></td>
                                    <td id="status"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="align-top py-5 px-4">
                                        <p class="mb-2">
                                            <span class="fw-semibold me-1">Client:</span>
                                            <span id="client"></span>
                                        </p>
                                        <span>Thanks for your business</span>
                                    </td>
                                    <td class="text-end py-5 px-4">
                                        <p class="mb-2 res">Insurance fee:</p>
                                        <p class="mb-2 res">Cod fee:</p>
                                        <p class="mb-0 res">Total:</p>
                                    </td>
                                    <td class="py-5 px-4">
                                        <p class="fw-semibold mb-2" id="insurance_fee"></p>
                                        <p class="fw-semibold mb-2" id="cod_fee"></p>
                                        <p class="fw-semibold mb-0" id="total"></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <span class="fw-semibold">Note:</span>
                                <span>It was a pleasure working with you and your team. We hope you will keep us in mind for
                                    future freelance projects. Thank You!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice -->

            <!-- Invoice Actions -->
            <div class="invoice-actions col-12 col-md-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary d-grid w-100 mb-3" data-bs-toggle="offcanvas"
                            data-bs-target="#ubahstatus" aria-controls="offcanvasEnd">
                            <span class="d-flex justify-content-center align-items-center text-nowrap"><i
                                    class="bx bx-paper-plane bx-xs me-3"></i>Update status</span>
                        </button>
                        <button class="btn btn-warning d-grid w-100 mb-3" data-bs-toggle="offcanvas"
                            data-bs-target="#logHistory">
                            <span class="d-flex justify-content-center align-items-center text-nowrap text-dark"><i
                                    class="bx bx-paper-plane bx-xs me-3"></i>Log History</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
    </div>




    {{-- status --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="ubahstatus" aria-labelledby="ubahstatusLabel">
        <div class="offcanvas-header">
            <h5 id="ubahstatusLabel" class="offcanvas-title">Update Status</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-0 my-auto mx-0">
            <p class="text-center">
                This function will help u to update status of order
            </p>
            <form id="changeStatus">
                <div class="mb-3">
                    <label for="currentStatus" class="form-label">Current Status</label>
                    <input type="text" disabled value="" class="form-control" id="currentStatus">
                </div>
                <div class="mb-3">
                    <label for="new_status" class="form-label">Status</label>
                    <select class="form-select" id="new_status" aria-label="Default select example">
                        <option selected disabled>Choose Status</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="new_status" class="form-label">Catatan</label>
                    <textarea id="catatan" cols="30" class="form-control" rows="10"></textarea>
                </div>
            </form>
            <button type="button" class="btn btn-primary d-grid w-100 mb-2 validasi"
                onclick="updateStatus();">Continue</button>
            <button type="button" class="btn btn-label-secondary d-grid w-100 tutupah" data-bs-dismiss="offcanvas">
                Cancel
            </button>
        </div>
    </div>

    {{-- Log History --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="logHistory" aria-labelledby="logHistoryLabel">
        <div class="offcanvas-header">
            <h5 id="logHistoryLabel" class="offcanvas-title">log History</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body flex-grow-0 my-auto mx-0">
            <p class="text-center">
                This function will help u to monitoring log of order
            </p>
            <h5 class="card-header">Order Activity Timeline</h5>
            <div class="card-body">
                <ul class="timeline" id="logs">
                </ul>
            </div>
        </div>
        <!-- /Activity Timeline -->
        <button type="button" class="btn btn-label-secondary d-grid w-100" data-bs-dismiss="offcanvas">Close</button>
    </div>
    </div>
@stop
@section('fungsi')
    <script type="text/javascript">
        $(document).ready(function() {
            reload();
            status();
        });

        function status() {
            $.ajax({
                processing: true,
                serverSide: true,
                url: "{{ url('/getStatus') }}",
                type: "get",
                context: document.body,
                success: function(data) {
                    var json = data;
                    obj = JSON.parse(json);


                    var status = '';

                    $.each(obj.data, function(k, v) {
                        status += `<option value="${v.id}">${v.status}</option>`
                    });

                    $('#new_status').append(status);
                } //ajax post data
            });
        }

        function updateStatus(params) {

            var status = $('#new_status').val();
            var id = $('#id_order').val();
            var catatan = $('#catatan').val()

            $('.validasi').addClass('disabled')

            $.ajax({
                type: "POST",
                url: "{{ url('/orders/updateStatus') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id_order: id,
                    id_status: status,
                    catatan: catatan,
                },
                dataType: "text",
                success: function(data) {
                    var json = data;
                    obj = JSON.parse(json);

                    if (obj.status == true) {
                        $("#changeStatus")[0].reset();
                        $('.validasi').removeClass('disabled')
                        reload();
                        $('.tutupah').trigger('click');
                    } else {
                        $("#changeStatus")[0].reset();
                        $('.validasi').removeClass('disabled')
                    }

                } //ajax post data
            });
        }

        function reload(params) {
            var id = $('#id_order').val();

            $.ajax({
                processing: true,
                serverSide: true,
                url: "{{ url('/orders/getDetail') }}",
                type: "get",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                context: document.body,
                success: function(data) {
                    var json = data;
                    obj = JSON.parse(json);
                    console.log(obj)
                    var awb = `<h4>AWB #${obj.data.awb}</h4>`;
                    var collection_date = `${obj.data.collection_scheduled_date}`;
                    var delivery_date = `${obj.data.delivery_scheduled_date}`;
                    var shipper_name = `${obj.data.shipper_name}`;
                    var shipper_phone = `${obj.data.shipper_phone}`;
                    var shipper_address = `${obj.data.shipper_address}`;
                    var shipper_provinsi = `${obj.bill.nama_provinsi}`;
                    var shipper_kota = `${obj.bill.nama_kota}`;
                    var shipper_kecamatan = `${obj.bill.nama_kecamatan}`;
                    var shipper_kelurahan = `${obj.bill.kelurahan}`;
                    var shipper_kodepos = `${obj.bill.kode_pos}`;
                    var recip_name = `${obj.data.recipient_name}`;
                    var recip_phone = `${obj.data.recipient_phone}`;
                    var recip_address = `${obj.data.recipient_address}`;
                    var recip_provinsi = `${obj.bill2.nama_provinsi}`;
                    var recip_kota = `${obj.bill2.nama_kota}`;
                    var recip_kecamatan = `${obj.bill2.nama_kecamatan}`;
                    var recip_kelurahan = `${obj.bill2.kelurahan}`;
                    var recip_kodepos = `${obj.bill2.kode_pos}`;


                    if (obj.data.is_insured == 1) {
                        var is_insured = `yes`;
                    } else {
                        var is_insured = `No`;
                    }

                    if (obj.data.is_cod == 1) {
                        var is_cod = `yes`;
                    } else {
                        var is_cod = `No`;
                    }

                    var weight = `${obj.data.weight}`;
                    var value_of_goods = `${obj.data.value_of_goods}`;
                    var status = `${obj.data.status}`;

                    if (obj.data.insurance_fee != 0) {
                        var insurance_fee = `${obj.data.insurance_fee}`;
                    } else {
                        var insurance_fee = `0`;
                    }
                    if (obj.data.cod_fee != 0) {
                        var cod_fee = `${obj.data.cod_fee}`;
                    } else {
                        var cod_fee = `0`;
                    }

                    var total = `${obj.data.total_fee}`;
                    var client = `${obj.data.account_name}`;


                    $('#awb').html(awb);
                    $('#collection_scheduled_date').html(collection_date);
                    $('#delivery_scheduled_date').html(delivery_date);
                    $('#shipper_name').html(shipper_name);
                    $('#shipper_phone').html(shipper_phone);
                    $('#shipper_address').html(shipper_address);
                    $('#shipper_provinsi').html(shipper_provinsi);
                    $('#shipper_kota').html(shipper_kota);
                    $('#shipper_kecamatan').html(shipper_kecamatan);
                    $('#shipper_kelurahan').html(shipper_kelurahan);
                    $('#shipper_zipcode').html(shipper_kodepos);

                    $('#recip_name').html(recip_name);
                    $('#recip_phone').html(recip_phone);
                    $('#recip_address').html(recip_address);
                    $('#recip_provinsi').html(recip_provinsi);
                    $('#recip_kota').html(recip_kota);
                    $('#recip_kecamatan').html(recip_kecamatan);
                    $('#recip_kelurahan').html(recip_kelurahan);
                    $('#recip_zipcode').html(recip_kodepos);

                    $('#is_insured').html(is_insured);
                    $('#is_cod').html(is_cod);
                    $('#weight').html(weight);
                    $('#value_of_goods').html(value_of_goods);
                    $('#status').html(status);
                    $('#insurance_fee').html(insurance_fee);
                    $('#cod_fee').html(cod_fee);
                    $('#total').html(total);
                    $('#client').html(client);
                    $('#currentStatus').val(status);


                    var loghistory = '';

                    $.each(obj.log, function(k, v) {
                        loghistory += `
                       <li class="timeline-item timeline-item-transparent">
                          <span class="timeline-point timeline-point-${v.warna}"></span>
                          <div class="timeline-event">
                            <div class="timeline-header mb-1">
                              <h6 class="mb-0">${v.status}</h6>
                            </div>
                            <p class="mb-2">${v.deskripsi}</p>
                            <small class="text-muted">${v.created_at}</small>
                          </div>
                        </li>
                    `;
                    });

                    loghistory += ` <li class="timeline-end-indicator">
                            <i class="bx bx-check-circle"></i>
                        </li>`;

                    $('#logs').html(loghistory);
                } //ajax post data
            });
        }
    </script>
@stop
