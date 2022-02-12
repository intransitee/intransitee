<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ClientController extends Controller
{
    public function index()
    {
        return view('admin.master.master')->nest('child', 'admin.client.list_client');
    }

    public function add()
    {
        return view('admin.master.master')->nest('child', 'admin.client.add_client');
    }

    public function edit(Request $request)
    {
        $data['id'] = $request->id;

        return view('admin.master.master')->nest('child', 'admin.client.edit_client', $data);
    }

    public function insert(Request $request)
    {
        $data = array(
            "account_name" => $request->account_name,
            "clients_category" => (int)$request->client_category,
            "pic_email" => $request->pic_email,
            "pic_name" => $request->pic_name,
            "pic_number" => $request->pic_number,
            "sales_agent" => $request->sales_agent,
            "id_pricing" => 99,
            "cod_fee" => $request->cod_fee,
            "insurance_fee" => $request->insurance_fee,
        );

        $insert = DB::table('tb_client')->insert($data);

        if ($insert) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil simpan client"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal simpan client"
            );

            return json_encode($data_result);
        }
    }

    public function update(Request $request)
    {
        $data = array(
            "account_name" => $request->account_name,
            "clients_category" => (int)$request->client_category,
            "pic_email" => $request->pic_email,
            "pic_name" => $request->pic_name,
            "pic_number" => $request->pic_number,
            "sales_agent" => $request->sales_agent,
            "id_pricing" => 99,
            "cod_fee" => $request->cod_fee,
            "insurance_fee" => $request->insurance_fee,
        );

        $insert = DB::table('tb_client')->where('id', $request->id_client)->update($data);

        if ($insert) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ubah data client"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ubah data client"
            );

            return json_encode($data_result);
        }
    }

    public function getClient()
    {

        $client = DB::table('tb_client')->get()->toArray();

        if ($client) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil client",
                'data' => $client
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil client"
            );

            return json_encode($data_result);
        }
    }

    public function reffClientCategory()
    {

        $category = DB::table('reff_client_category')->get()->toArray();

        if ($category) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil category",
                'data' => $category
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil client"
            );

            return json_encode($data_result);
        }
    }

    public function detailClient(Request $request)
    {

        $client = DB::table('tb_client')->where('id', $request->id)->first();

        if ($client) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil client",
                'data' => $client
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil client"
            );

            return json_encode($data_result);
        }
    }

    public function delete(Request $request)
    {
        $delete = DB::table('tb_client')->where('id', $request->id)->delete();

        if ($delete) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil hapus client",
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal hapus client"
            );

            return json_encode($data_result);
        }
    }
}
