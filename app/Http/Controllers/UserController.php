<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('preventBackHistory');
    }

    public function index()
    {
        return view('admin.master.master')->nest('child', 'admin.user.list_user');
    }

    public function add()
    {
        return view('admin.master.master')->nest('child', 'admin.user.add_user');
    }

    public function getUser()
    {

        $user = DB::table('tb_user')
            ->select('tb_user.id', 'username', 'email', 'roles', 'tb_user.created_at', 'last_login', 'id_client')
            ->join('reff_roles', 'reff_roles.id', '=', 'tb_user.id_roles')
            // ->join('tb_client', 'tb_client.id', '=', 'tb_user.id_client')
            ->get()->toArray();

        foreach ($user as $key => $value) {
            # code...
            $client = DB::table('tb_client')->where('id', $value->id_client)->get();

            $user[$key]->created_at = tanggal_local(date("Y-m-d", strtotime($value->created_at)));
            $user[$key]->last_login = tanggal_local(date("Y-m-d", strtotime($value->last_login)));
        }

        if ($user) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil user",
                'data' => $user
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil user"
            );

            return json_encode($data_result);
        }
    }

    public function detail(Request $request, $id)
    {
        $data['id'] = $request->id;
        return view('admin.master.master')->nest('child', 'admin.user.detail_user', $data);
    }

    public function insert(Request $request)
    {
        if ($request->roles == 3) {
            # code...
            $data = array(
                "username" => $request->username,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "id_roles" => $request->roles,
                "is_customer" => 1,
                "id_client" => $request->client
            );
        } else {
            $data = array(
                "username" => $request->username,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "id_roles" => $request->roles,
                "is_customer" => 0,
                "id_client" => 0
            );
        }


        $insert = DB::table('tb_user')->insert($data);

        if ($insert) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil simpan user"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal simpan user"
            );

            return json_encode($data_result);
        }
    }

    public function delete(Request $request)
    {
        $delete = DB::table('tb_user')->where('id', $request->id)->delete();


        if ($delete) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil hapus user",
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal hapus user"
            );

            return json_encode($data_result);
        }
    }

    public function update(Request $request)
    {
        $myid = DB::table('tb_user')->where('id', $request->id)->first();

        if ($request->password == null) {
            # code...
            $password = $myid->password;
        } else {
            $password = Hash::make($request->password);
        }

        if ($request->roles == 3) {
            # code...
            $data = array(
                "username" => $request->username,
                "email" => $request->email,
                "password" => $password,
                "id_roles" => $request->roles,
                "is_customer" => 1,
                "id_client" => $request->client
            );
        } else {
            $data = array(
                "username" => $request->username,
                "email" => $request->email,
                "password" => $password,
                "id_roles" => $request->roles,
                "is_customer" => 0,
                "id_client" => 0
            );
        }

        $update = DB::table('tb_user')->where('id', $request->id)->update($data);

        if ($update) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ubah data user"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ubah data user"
            );

            return json_encode($data_result);
        }
    }

    public function getDetail(Request $request)
    {
        $user = DB::table('tb_user')
            ->select('tb_user.id', 'username', 'email', 'roles', 'id_roles', 'created_at', 'last_login')
            ->join('reff_roles', 'reff_roles.id', '=', 'tb_user.id_roles')
            ->where('tb_user.id', $request->id)
            ->first();

        # code...
        $user->created_at = tanggal_local(date("Y-m-d", strtotime($user->created_at)));
        $user->last_login = tanggal_local(date("Y-m-d", strtotime($user->last_login)));

        if ($user) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil user",
                'data' => $user,
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil user"
            );

            return json_encode($data_result);
        }
    }

    public function reffRoles(Request $request)
    {

        $roles = DB::table('reff_roles')->get()->toArray();

        if ($roles) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil roles",
                'data' => $roles
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
