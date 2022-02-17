<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('preventBackHistory');
    }

    public function index()
    {
        return view('admin.master.master')->nest('child', 'admin.role.list_role');
    }

    public function add()
    {
        return view('admin.master.master')->nest('child', 'admin.role.add_role');
    }

    public function detail(Request $request, $id)
    {
        $data['id'] = $request->id;
        return view('admin.master.master')->nest('child', 'admin.role.detail_role', $data);
    }

    public function getDetail(Request $request)
    {
        $role = DB::table('reff_roles')
            ->where('id', $request->id)
            ->first();

        if ($role) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil role",
                'data' => $role,
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil role"
            );

            return json_encode($data_result);
        }
    }

    public function update(Request $request)
    {
        $data = array(
            "roles" => $request->roles,
        );

        $update = DB::table('reff_roles')->where('id', $request->id)->update($data);

        if ($update) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ubah data role"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ubah data role"
            );

            return json_encode($data_result);
        }
    }

    public function delete(Request $request)
    {
        $delete = DB::table('reff_roles')->where('id', $request->id)->delete();


        if ($delete) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil hapus role",
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal hapus role"
            );

            return json_encode($data_result);
        }
    }

    public function insert(Request $request)
    {
        $data = array(
            "roles" => $request->role,
        );

        $insert = DB::table('reff_roles')->insert($data);

        if ($insert) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil simpan roles"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal simpan roles"
            );

            return json_encode($data_result);
        }
    }

    public function getRole()
    {

        $role = DB::table('reff_roles')->get()->toArray();

        if ($role) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil role",
                'data' => $role
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil role"
            );

            return json_encode($data_result);
        }
    }
}
