<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
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
        $check = DB::table('tb_order')->orderBy('id', 'DESC')->first();

        $res = $check->id + 1;

        if ($res < 10) {
            # code...
            $number = str_pad($res, 3, "0", STR_PAD_LEFT);
        } elseif ($res > 9 && $res < 100) {
            # code...
            $number = str_pad($res, 2, "0", STR_PAD_LEFT);
        } else {
            $number = str_pad($res, 1, "0", STR_PAD_LEFT);
        }

        $generateawb = 'IN' . date("Y-m-d") . $number;
        $awb = str_replace('-', '', $generateawb);

        $data = array(
            'awb' => $awb,
            'id_client' => $request->id_client,
            'id_type' => $request->id_type,
            "id_service" => $request->id_service,
            "shipper_name" => $request->shipper_name,
            "shipper_phone" => $request->shipper_phone,
            "shipper_address" => $request->shipper_address,
            "shipper_zipcode" => $request->shipper_zipcode,
            "shipper_area" => $request->shipper_area,
            "shipper_district" => $request->shipper_district,
            "recipient_name" => $request->recipient_name,
            "recipient_phone" => $request->recipient_phone,
            "recipient_address" => $request->recipient_address,
            "recipient_zip_code" => $request->recipient_zipcode,
            "recipient_area" => $request->recipient_area,
            "recipient_district" => $request->recipient_district,
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
        );

        $insert = DB::table('tb_order')->insert($data);

        if ($insert) {
            # code...

            $log_id = DB::table('tb_order')->orderBy('id', 'DESC')->first();

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
        $data = array(
            "id_status" => $request->id_status,
        );

        $update = DB::table('tb_order')->where('id', $request->id_order)->update($data);

        if ($update) {
            # code...

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

        $order = DB::table('tb_order')
            ->select('tb_order.id', 'awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'collection_scheduled_date', 'delivery_scheduled_date', 'reff_status.status', 'created_date', 'reff_status.warna')
            ->join('tb_client', 'tb_client.id', '=', 'tb_order.id_client')
            ->join('reff_type', 'reff_type.id', '=', 'tb_order.id_type')
            ->join('reff_service', 'reff_service.id', '=', 'tb_order.id_service')
            ->join('reff_status', 'reff_status.id', '=', 'tb_order.id_status')
            ->get()->toArray();

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

        $order = DB::table('tb_order')
            ->select('tb_order.id', 'awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'collection_scheduled_date', 'delivery_scheduled_date', 'reff_status.status', 'created_date', 'shipper_name', 'shipper_phone', 'shipper_address', 'shipper_zipcode', 'shipper_area', 'shipper_district', 'recipient_name', 'recipient_phone', 'recipient_address', 'recipient_zip_code', 'recipient_area', 'recipient_district', 'weight', 'value_of_goods', 'is_insured', 'is_cod', 'tb_order.insurance_fee', 'tb_order.cod_fee', 'total_fee', 'reff_status.status')
            ->join('tb_client', 'tb_client.id', '=', 'tb_order.id_client')
            ->join('reff_type', 'reff_type.id', '=', 'tb_order.id_type')
            ->join('reff_service', 'reff_service.id', '=', 'tb_order.id_service')
            ->join('reff_status', 'reff_status.id', '=', 'tb_order.id_status')
            ->where('tb_order.id', $request->id)
            ->first();

        $shipper_area = DB::table('reff_area')->select('area')->where('id_area', $order->shipper_area)->first();
        $shipper_district = DB::table('reff_area')->select('district')->where('id_district', $order->shipper_district)->first();
        $recip_area = DB::table('reff_area')->select('area')->where('id_area', $order->recipient_area)->first();
        $recip_district = DB::table('reff_area')->select('district')->where('id_district', $order->recipient_district)->first();

        $bill = array(
            'shipper_area' => $shipper_area->area,
            'shipper_district' => $shipper_district->district,
            'recip_area' => $recip_area->area,
            'recip_district' => $recip_district->district,
        );

        # code...
        $order->collection_scheduled_date = tanggal_local(date("Y-m-d", strtotime($order->collection_scheduled_date)));
        $order->delivery_scheduled_date = tanggal_local(date("Y-m-d", strtotime($order->delivery_scheduled_date)));
        $order->created_date = tanggal_local(date("Y-m-d", strtotime($order->created_date)));

        $getLog = DB::table('reff_order_logs')
            ->select('reff_order_logs.id', 'status', 'reff_order_logs.deskripsi', 'created_at', 'warna')
            ->join('reff_status', 'reff_status.id', '=', 'reff_order_logs.id_status')
            ->where('id_order', $request->id)->get()->toArray();

        foreach ($getLog as $key => $value) {
            # code...
            $getLog[$key]->created_at = tanggal_local(date("Y-m-d", strtotime($value->created_at)));
        }

        if ($order) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil order",
                'data' => $order,
                'bill' => $bill,
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
        $delete = DB::table('tb_order')->where('id', $request->id)->delete();


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
}
