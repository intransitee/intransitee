<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Orders;
use App\Imports\ImportOrder;
use App\Imports\Tes;
use App\Imports\UpdateOrder;
use Session;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('preventBackHistory');
    }

    public function index()
    {
        return view('admin.master.master')->nest('child', 'admin.order.list_order');
    }

    public function detail($id)
    {
        return view('admin.master.master')->nest('child', 'admin.order.detail_order');
    }

    public function add()
    {
        return view('admin.master.master')->nest('child', 'admin.order.add_order');
    }

    public function insert(Request $request)
    {
        $check = DB::table('tb_order_backup')->orderBy('id', 'DESC')->first();

        $res = $check->id + 1;

        if ($res < 10) {
            # code...
            $number = str_pad($res, 3, "0", STR_PAD_LEFT);
        } elseif ($res > 9 && $res < 100) {
            # code...
            $number = str_pad($res, 3, "0", STR_PAD_LEFT);
        } else {
            $number = str_pad($res, 3, "0", STR_PAD_LEFT);
        }

        $generateawb = 'IN' . date("Y-m-d") . $number;
        $awb = str_replace('-', '', $generateawb);
        $shipper_price = explode("#", $request->shipper_pricing_area);
        $recipient_price = explode("#", $request->recipient_pricing_area);

        // $ship_temp_area = DB::table('reff_area')->where('id_area', $request->shipper_area)->first();
        // $ship_temp_district = DB::table('reff_area')->where('id_district', $request->shipper_district)->first();

        // $recip_temp_area = DB::table('reff_area')->where('id_area', $request->recipient_area)->first();
        // $recip_temp_district = DB::table('reff_area')->where('id_district', $request->recipient_district)->first();

        if (session('role') == 3) {
            # code...
            $client = session('client');
        } else {
            $client = $request->id_client;
        }

        $data = array(
            'awb' => $awb,
            'reff_id' => $request->reff_id,
            'id_client' => $client,
            'id_type' => $request->id_type,
            "id_service" => $request->id_service,
            "shipper_name" => $request->shipper_name,
            "shipper_phone" => $request->shipper_phone,
            "shipper_address" => $request->shipper_address,
            "shipper_pricing_area" => $shipper_price[0],
            "recipient_name" => $request->recipient_name,
            "recipient_phone" => $request->recipient_phone,
            "recipient_address" => $request->recipient_address,
            "recipient_pricing_area" => $recipient_price[0],
            "delivery_fee" => $request->delivery_fee,
            "weight" => $request->weight,
            "value_of_goods" => $request->value_of_goods,
            "id_status" => 1,
            "is_cod" => $request->is_cod,
            "is_insured" => $request->is_insured,
            "insurance_fee" => $request->insurance_fee,
            "cod_fee" => $request->cod_fee,
            "total_fee" => $request->total_fee,
            "collection_scheduled_date" => $request->collection_date,
            "delivery_scheduled_date" => $request->delivery_date,
            "bulk_log_status" => 1
        );
        // dd($data);
        $insert = DB::table('tb_order_backup')->insert($data);

        if ($insert) {
            # code...

            $log_id = DB::table('tb_order_backup')->orderBy('id', 'DESC')->first();

            $data_log = array(
                'id_order' => $log_id->id,
                'id_status' => 1,
                'deskripsi' => session('username') . " membuat data order baru",
                'id_user' => session('id'),
            );

            $insert_log = DB::table('reff_order_logs')->insert($data_log);

            $data_result = array(
                'status' => true,
                'message' => "Berhasil simpan order baru"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal simpan order baru"
            );

            return json_encode($data_result);
        }
    }

    public function updateStatus(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $update_time = date('Y/m/d h:i:s', time());

        if ($request->id_status == 2) {
            # code...
            $update_order = array(
                'pending_date' => $update_time
            );
        } elseif ($request->id_status == 3) {
            # code...
            $update_order = array(
                'in_transit_date' => $update_time
            );
        } elseif ($request->id_status == 4) {
            # code...
            $update_order = array(
                'completed_date' => $update_time
            );
        } elseif ($request->id_status == 8) {
            # code...
            $update_order = array(
                'fail_attempt_1_date' => $update_time
            );
        } elseif ($request->id_status == 5 || $request->id_status == 6 || $request->id_status == 7) {
            # code...
            $update_order = array(
                'fail_date' => $update_time
            );
        } elseif ($request->id_status == 9) {
            # code...
            $update_order = array(
                'cancelled_date' => $update_time
            );
        }

        $data = array(
            "id_status" => $request->id_status,
            "last_updated" => $update_time
        );

        $update = DB::table('tb_order_backup')->where('id', $request->id_order)->update($data);

        if ($update) {
            # code...
            // update status yang di tb order
            $update = DB::table('tb_order_backup')->where('id', $request->id_order)->update($update_order);

            // update log
            $data_log = array(
                'id_order' => $request->id_order,
                'id_status' => $request->id_status,
                'deskripsi' => $request->catatan,
                'id_user' => session('id'),
            );

            $insert_log = DB::table('reff_order_logs')->insert($data_log);


            $data_result = array(
                'status' => true,
                'message' => "Berhasil ubah data order"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ubah data order"
            );

            return json_encode($data_result);
        }
    }

    public function getOrder()
    {

        if (session('role') != 3) {
            # code...
            $order = DB::table('tb_order_backup')
                ->select('tb_order_backup.id', 'awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'collection_scheduled_date', 'delivery_scheduled_date', 'reff_status.status', 'created_date', 'reff_status.warna')
                ->join('tb_client', 'tb_client.id', '=', 'tb_order_backup.id_client')
                ->join('reff_type', 'reff_type.id', '=', 'tb_order_backup.id_type')
                ->join('reff_service', 'reff_service.id', '=', 'tb_order_backup.id_service')
                ->join('reff_status', 'reff_status.id', '=', 'tb_order_backup.id_status')
                ->orderBy('id', 'DESC')
                ->get()->toArray();
        } else {
            $order = DB::table('tb_order_backup')
                ->select('tb_order_backup.id', 'awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'collection_scheduled_date', 'delivery_scheduled_date', 'reff_status.status', 'created_date', 'reff_status.warna')
                ->join('tb_client', 'tb_client.id', '=', 'tb_order_backup.id_client')
                ->join('reff_type', 'reff_type.id', '=', 'tb_order_backup.id_type')
                ->join('reff_service', 'reff_service.id', '=', 'tb_order_backup.id_service')
                ->join('reff_status', 'reff_status.id', '=', 'tb_order_backup.id_status')
                ->where('id_client', session('client'))
                ->orderBy('id', 'DESC')
                ->get()->toArray();
        }


        foreach ($order as $key => $value) {
            # code...
            $order[$key]->collection_scheduled_date = tanggal_local(date("Y-m-d", strtotime($value->collection_scheduled_date)));
            $order[$key]->delivery_scheduled_date = tanggal_local(date("Y-m-d", strtotime($value->delivery_scheduled_date)));
            $order[$key]->created_date = tanggal_local(date("Y-m-d", strtotime($value->created_date)));
        }

        if ($order) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil order",
                'data' => $order
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil order"
            );

            return json_encode($data_result);
        }
    }

    public function getDetail(Request $request)
    {

        $order = DB::table('tb_order_backup')
            ->select('tb_order_backup.id', 'awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'collection_scheduled_date', 'delivery_scheduled_date', 'reff_status.status', 'created_date', 'shipper_name', 'shipper_phone', 'shipper_address', 'recipient_name', 'recipient_phone', 'recipient_address', 'weight', 'value_of_goods', 'is_insured', 'is_cod', 'tb_order_backup.insurance_fee', 'tb_order_backup.cod_fee', 'total_fee', 'reff_status.status', 'shipper_pricing_area')
            ->join('tb_client', 'tb_client.id', '=', 'tb_order_backup.id_client')
            ->join('reff_type', 'reff_type.id', '=', 'tb_order_backup.id_type')
            ->join('reff_service', 'reff_service.id', '=', 'tb_order_backup.id_service')
            ->join('reff_status', 'reff_status.id', '=', 'tb_order_backup.id_status')
            ->where('tb_order_backup.id', $request->id)
            ->first();

        $shipper = DB::table('tb_order_backup')
            ->select('nama_provinsi', 'nama_kota', 'nama_kecamatan', 'kelurahan', 'kode_pos')
            ->join('tb_pricing', 'tb_pricing.id', '=', 'tb_order_backup.shipper_pricing_area')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
            ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
            ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
            ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
            ->where('tb_order_backup.id', $request->id)
            ->first();

        $recipt = DB::table('tb_order_backup')
            ->select('nama_provinsi', 'nama_kota', 'nama_kecamatan', 'kelurahan', 'kode_pos')
            ->join('tb_pricing', 'tb_pricing.id', '=', 'tb_order_backup.recipient_pricing_area')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
            ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
            ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
            ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
            ->where('tb_order_backup.id', $request->id)
            ->first();

        // $shipper_area = DB::table('reff_area')->select('area')->where('id_area', $order->shipper_area)->first();
        // $shipper_district = DB::table('reff_area')->select('district')->where('id_district', $order->shipper_district)->first();
        // $recip_area = DB::table('reff_area')->select('area')->where('id_area', $order->recipient_area)->first();
        // $recip_district = DB::table('reff_area')->select('district')->where('id_district', $order->recipient_district)->first();

        // $bill = array(
        //     'shipper_area' => $shipper_area->area,
        //     'shipper_district' => $shipper_district->district,
        //     'recip_area' => $recip_area->area,
        //     'recip_district' => $recip_district->district,
        // );

        $bill_ship = array(
            "nama_provinsi" => $shipper->nama_provinsi,
            "nama_kota" => $shipper->nama_kota,
            "nama_kecamatan" => $shipper->nama_kecamatan,
            "kelurahan" => $shipper->kelurahan,
            "kode_pos" => $shipper->kode_pos,
        );

        $bill_recipt = array(
            "nama_provinsi" => $recipt->nama_provinsi,
            "nama_kota" => $recipt->nama_kota,
            "nama_kecamatan" => $recipt->nama_kecamatan,
            "kelurahan" => $recipt->kelurahan,
            "kode_pos" => $recipt->kode_pos,
        );

        # code...
        $order->collection_scheduled_date = tanggal_local(date("Y-m-d", strtotime($order->collection_scheduled_date)));
        $order->delivery_scheduled_date = tanggal_local(date("Y-m-d", strtotime($order->delivery_scheduled_date)));
        $order->created_date = tanggal_local(date("Y-m-d", strtotime($order->created_date)));

        $getLog = DB::table('reff_order_logs')
            ->select('reff_order_logs.id', 'status', 'reff_order_logs.deskripsi', 'created_at', 'warna')
            ->join('reff_status', 'reff_status.id', '=', 'reff_order_logs.id_status')
            ->where('id_order', $request->id)->get()->toArray();

        // foreach ($getLog as $key => $value) {
        //     $getLog[$key]->created_at = tanggal_local(date("Y-m-d", strtotime($value->created_at)));
        // }

        if ($order) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil order",
                'data' => $order,
                'bill' => $bill_ship,
                'bill2' => $bill_recipt,
                'log' => $getLog
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil order"
            );

            return json_encode($data_result);
        }
    }

    public function delete(Request $request)
    {
        $delete = DB::table('tb_order_backup')->where('id', $request->id)->delete();


        if ($delete) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil hapus order",
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal hapus order"
            );

            return json_encode($data_result);
        }
    }

    public function getType()
    {

        $type = DB::table('reff_type')->select('id', 'type')->get()->toArray();

        if ($type) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil type",
                'data' => $type
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil type"
            );

            return json_encode($data_result);
        }
    }

    public function export()
    {
        $check = DB::table('tb_order_backup')->count();

        if ($check < 1) {
            # code...
            return redirect()->route('order.order')->with('no_order', 'Data order tidak ada');
        } else {
            return Excel::download(new Orders, rand() . 'export-order.xlsx');
        }
    }

    public function import(Request $request)
    {
        if ($request->flag == 1) {
            # code...
            ini_set('memory_limit', '512M');
            $file = $request->file('file');
            $nama_file = rand() . $file->getClientOriginalName();
            $file->move('import', $nama_file);

            Excel::import(new ImportOrder, public_path('/import/' . $nama_file));

            // FOR TEST IMPORRT DATA 10K +++
            // Excel::import(new Tes, public_path('/import/' . $nama_file));

            return redirect()->route('order.order')->with('store', 'Berhasil tambah order');
        } else {
            $file = $request->file('file');
            $nama_file = rand() . $file->getClientOriginalName();
            $file->move('import', $nama_file);

            $data = Excel::toArray(new UpdateOrder, public_path('/import/' . $nama_file));

            $bulk = [];

            $c = collect(head($data));

            // create bulk array
            foreach ($c as $key => $value) {
                $bulk[] = array(
                    'awb' => $value[0],
                    'id_status' => $value[1],
                );
                # code...
            }

            foreach ($bulk as $k => $val) {
                if ($val['awb'] == null) {
                    // remove orange apps
                    unset($bulk[$k]);
                }
            }

            $res = [];
            foreach ($bulk as $num => $item) {
                $update = DB::table('tb_order_backup')->where('awb', $item['awb'])->update($item);
                $t = array(
                    'awb' => $item['awb'],
                    'status' => $item['id_status']
                );

                array_push($res, $t);
            }

            $temp = json_encode($res);

            return redirect()->route('order.order')->with('update', $temp);
        }
    }

    public function downloadAddOrder(Request $request)
    {
        $path = public_path() . "/template/bulk-add-order.xlsx";

        $filename = 'format_import_add_order.xlsx';
        // Download file with custom headers
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function downloadEditOrder(Request $request)
    {
        $path = public_path() . "/template/bulk-edit-order.xlsx";

        $filename = 'format_import_edit_order.xlsx';
        // Download file with custom headers
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function updateLogBulk()
    {
        $check = DB::table('tb_order_backup')->where('bulk_log_status', 0)->get();
        // dd($check);
        foreach ($check as $key => $value) {
            # code...
            $data = array(
                'id_order' => $value->id,
                'id_status' => 1,
                'deskripsi' => session('username') . " membuat data order baru",
                'id_user' => session('id'),
            );

            $logging = DB::table('reff_order_logs')->insert($data);

            //Update bulk log
            $bulkUpdate = array(
                'bulk_log_status' => 1
            );

            $udpate = DB::table('tb_order_backup')->where('id', $value->id)->update($bulkUpdate);
        }

        if ($check) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil update logs",
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal update logs"
            );

            return json_encode($data_result);
        }
    }

    public function updateLogBulkAfterImport(Request $request)
    {
        $dataku = json_decode($request->data);

        foreach ($dataku as $key => $value) {
            $check = DB::table('tb_order_backup')->where('awb', $value->awb)->get();
            # code...
            $data = array(
                'id_order' => $check[$key]->id,
                'id_status' => $value->status,
                'deskripsi' => session('username') . " membuat data order baru",
                'id_user' => session('id'),
            );

            $logging = DB::table('reff_order_logs')->insert($data);

            if ($check[$key]->bulk_log_status == 0) {
                # code...
                //Update bulk log
                $bulkUpdate = array(
                    'bulk_log_status' => 1
                );
                $udpate = DB::table('tb_order_backup')->where('id', $check[$key]->id)->update($bulkUpdate);
            }
            return;
        }


        $data_result = array(
            'status' => true,
            'message' => "Berhasil update logs",
        );
    }

    public function reffClient()
    {

        $client = DB::table('tb_client')->select('id', 'account_name')->get()->toArray();

        if ($client) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil order",
                'data' => $client
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil order"
            );

            return json_encode($data_result);
        }
    }

    public function reffService()
    {

        $service = DB::table('reff_service')->select('id', 'service')->get()->toArray();

        if ($service) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil service",
                'data' => $service
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil service"
            );

            return json_encode($data_result);
        }
    }

    public function reffZipcode()
    {

        $area = DB::table('reff_area')->get()->toArray();

        if ($area) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil area",
                'data' => $area
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil area"
            );

            return json_encode($data_result);
        }
    }

    public function zipcodeOrder(Request $request)
    {
        $area = DB::table('tb_pricing')
            ->join('reff_area', 'reff_area.id', '=', 'tb_pricing.id_area')
            ->where('id_client', $request->client)->get()->toArray();

        if ($area) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil area",
                'data' => $area
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil area"
            );

            return json_encode($data_result);
        }
    }

    public function getArea(Request $request)
    {
        $area = DB::table('reff_area')->select('id_area', 'area')->where('postal_code', $request->zipcode)->groupBy('id_area', 'area')->get()->toArray();

        if ($area) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil area",
                'data' => $area
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil area"
            );

            return json_encode($data_result);
        }
    }

    public function getAreaByProvince(Request $request, $Prov, $zipcode)
    {
        // dd($Prov);
        $area = DB::table('reff_area')->select('id_area', 'area')->where('id_province', $Prov)->where('postal_code', $zipcode)->groupBy('id_area', 'area')->get()->toArray();

        if ($area) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil area",
                'data' => $area
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil area"
            );

            return json_encode($data_result);
        }
    }

    public function getDistrictByArea(Request $request, $zipcode, $prov, $area)
    {
        // dd($Prov);
        $district = DB::table('reff_area')->select('id_district', 'district')->where('postal_code', $zipcode)->where('id_province', $prov)->where('id_area', $area)->groupBy('id_district', 'district')->get()->toArray();

        if ($district) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil district",
                'data' => $district
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil district"
            );

            return json_encode($data_result);
        }
    }

    public function getSubDistrictByArea(Request $request, $zipcode, $prov, $area, $district)
    {
        // dd($Prov);
        $subdistrict = DB::table('reff_area')->select('id_subdistrict', 'subdistrict')->where('postal_code', $zipcode)->where('id_province', $prov)->where('id_area', $area)->where('id_district', $district)->groupBy('id_subdistrict', 'subdistrict')->get()->toArray();

        if ($subdistrict) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil subdistrict",
                'data' => $subdistrict
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil subdistrict"
            );

            return json_encode($data_result);
        }
    }

    public function getProvince(Request $request, $zipcode)
    {
        $province = DB::table('reff_area')->select('id_province', 'province')->where('postal_code', $zipcode)->groupBy('id_province', 'province')->get()->toArray();

        if ($province) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil province",
                'data' => $province
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil province"
            );

            return json_encode($data_result);
        }
    }

    public function getStatus()
    {
        $status = DB::table('reff_status')->get()->toArray();

        if ($status) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil status",
                'data' => $status
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil status"
            );

            return json_encode($data_result);
        }
    }

    public function getDistrict(Request $request)
    {
        $district = DB::table('reff_area')->select('id_district', 'district')->where('id_area', $request->area)->groupBy('id_district', 'district')->get()->toArray();

        if ($district) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil district",
                'data' => $district
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil district"
            );

            return json_encode($data_result);
        }
    }

    public function calculate_cod_fee(Request $request)
    {

        if (session('client') == 0) {
            # code...
            $client  = $request->id_client;
        } else {
            $client  = session('client');
        }

        if ($request->is_cod == 1) {
            # code...
            $client = DB::table('tb_client')->where('id', $client)->first();
            if ($client) {
                # code...
                $data_result = array(
                    'status' => true,
                    'message' => "Berhasil ambil harga cod client",
                    'data' => $client
                );

                return json_encode($data_result);
            } else {
                $data_result = array(
                    'status' => false,
                    'message' => "Gagal ambil harga cod client"
                );

                return json_encode($data_result);
            }
        } else {
            $data_result = array(
                'status' => false,
                'message' => "No Cod"
            );

            return json_encode($data_result);
        }
    }

    public function calculate_insurance_fee(Request $request)
    {
        if (session('client') == 0) {
            # code...
            $client  = $request->id_client;
        } else {
            $client  = session('client');
        }

        if ($request->insurance == 1) {
            # code...
            $client = DB::table('tb_client')->where('id', $client)->first();
            if ($client) {
                # code...
                $data_result = array(
                    'status' => true,
                    'message' => "Berhasil ambil harga insurance",
                    'data' => $client
                );

                return json_encode($data_result);
            } else {
                $data_result = array(
                    'status' => false,
                    'message' => "Gagal ambil harga insurance"
                );

                return json_encode($data_result);
            }
        } else {
            $data_result = array(
                'status' => false,
                'message' => "No Cod"
            );

            return json_encode($data_result);
        }
    }





    // REFF AREA
    public function reff_provinsi(Request $request)
    {
        $provinsi = DB::table('tb_provinsi')->select('id_provinsi', 'nama_provinsi')->get()->toArray();

        if ($provinsi) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil provinsi",
                'data' => $provinsi
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil provinsi"
            );

            return json_encode($data_result);
        }
    }

    public function reff_kota(Request $request)
    {
        $kota = DB::table('tb_kota')->select('id_kota', 'nama_kota')->where('id_provinsi', $request->provinsi)->get()->toArray();

        if ($kota) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil kota",
                'data' => $kota
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil kota"
            );

            return json_encode($data_result);
        }
    }

    public function reff_kecamatan(Request $request)
    {
        $kecamatan = DB::table('tb_kecamatan')->select('id_kecamatan', 'nama_kecamatan')->where('id_kota', $request->kota)->get()->toArray();

        if ($kecamatan) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil kecamatan",
                'data' => $kecamatan
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil kecamatan"
            );

            return json_encode($data_result);
        }
    }

    public function reff_kelurahan(Request $request)
    {
        $kelurahan = DB::table('tb_kelurahan')->select('id_kelurahan', 'kelurahan')->where('id_kecamatan', $request->kecamatan)->get()->toArray();

        if ($kelurahan) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil kelurahan",
                'data' => $kelurahan
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil kelurahan"
            );

            return json_encode($data_result);
        }
    }

    public function reff_kodepos(Request $request)
    {
        $pos = DB::table('tb_kodepos')->select('id_kodepos', 'kode_pos')->where('id_kelurahan', $request->kelurahan)->get()->toArray();

        if ($pos) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil kodepos",
                'data' => $pos
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil kodepos"
            );

            return json_encode($data_result);
        }
    }

    public function reff_all_kota(Request $request)
    {
        $allkota = DB::table('tb_kota')->get()->toArray();

        if ($allkota) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil kota",
                'data' => $allkota
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil kota"
            );

            return json_encode($data_result);
        }
    }

    public function reff_all_kecamatan(Request $request)
    {
        $allkecamatan = DB::table('tb_kecamatan')->get()->toArray();

        if ($allkecamatan) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil kecamatan",
                'data' => $allkecamatan
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil kecamatan"
            );

            return json_encode($data_result);
        }
    }

    public function reff_all_kelurahan(Request $request)
    {
        $allkelurahan = DB::table('tb_kelurahan')->get()->toArray();

        if ($allkelurahan) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil kelurahan",
                'data' => $allkelurahan
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil kelurahan"
            );

            return json_encode($data_result);
        }
    }

    public function reff_all_kodepos(Request $request)
    {
        $allkodepos = DB::table('tb_kodepos')->get()->toArray();

        if ($allkodepos) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil kodepos",
                'data' => $allkodepos
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil kodepos"
            );

            return json_encode($data_result);
        }
    }

    public function provclient(Request $request)
    {

        $pricing = DB::table('tb_pricing')->select('tb_pricing.id', 'tb_client.account_name', 'reff_service.service', 'reff_type.type', 'price', 'tb_provinsi.nama_provinsi', 'tb_kota.nama_kota', 'tb_kecamatan.nama_kecamatan', 'tb_kelurahan.kelurahan', 'kode_pos')
            ->join('tb_client', 'tb_client.id', '=', 'tb_pricing.id_client')
            ->join('reff_service', 'reff_service.id', '=', 'tb_pricing.id_service')
            ->join('reff_type', 'reff_type.id', '=', 'tb_pricing.id_type')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
            ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
            ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
            ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
            ->orderBy('tb_pricing.id', 'DESC')
            ->where('id_client', $request->id_client)
            ->where('id_type', $request->id_type)
            ->where('id_service', $request->id_service)
            ->get()->toArray();

        if ($pricing) {
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil pricing",
                'data' => $pricing
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "gagal ambil pricing",
            );

            return json_encode($data_result);
        }

        // $pricing = DB::table('tb_provinsi')->select('id_provinsi', 'nama_provinsi')->get()->toArray();
    }
}
