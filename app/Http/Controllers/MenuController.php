<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class MenuController extends Controller
{

    public function __construct()
    {
        $this->middleware('preventBackHistory');
    }

    public function index($id)
    {
        $data['id_role'] = $id;
        return view('admin.master.master')->nest('child', 'admin.menu.list_menu', $data);
    }

    public function add($id)
    {
        $data['id_role'] = $id;
        return view('admin.master.master')->nest('child', 'admin.menu.add_menu', $data);
    }

    public function detail($id, $id_role)
    {
        $data['id_menu'] = $id;
        $data['id_role'] = $id_role;

        $data['menu'] = DB::table('tb_menu')->select('id', 'id_menu_function')->first();
        // dd($data['menu']->id_menu_function);
        return view('admin.master.master')->nest('child', 'admin.menu.detail_menu', $data);
    }

    public function reffMenuFunction(Request $request)
    {

        $menu_function = DB::table('reff_menu_function')->get()->toArray();

        if ($menu_function) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil menu function",
                'data' => $menu_function
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil menu function"
            );

            return json_encode($data_result);
        }
    }

    public function getMenu(Request $request)
    {
        $menu = DB::table('tb_menu')
            ->select('tb_menu.id', 'deskripsi', 'menu_name', 'roles')
            ->join('reff_roles', 'reff_roles.id', '=', 'tb_menu.id_role')
            ->join('reff_menu_function', 'reff_menu_function.id', '=', 'tb_menu.id_menu_function')
            ->where('id_role', $request->id)
            ->orderBy('tb_menu.id', 'DESC')
            ->get()->toArray();

        if ($menu) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil menu",
                'data' => $menu
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil menu"
            );

            return json_encode($data_result);
        }
    }

    public function getDetail(Request $request)
    {
        $menu = DB::table('tb_menu')
            ->join('reff_roles', 'reff_roles.id', '=', 'tb_menu.id_role')
            ->join('reff_menu_function', 'reff_menu_function.id', '=', 'tb_menu.id_menu_function')
            ->where('tb_menu.id', $request->id)
            ->first();

        if ($menu) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil menu",
                'data' => $menu,
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil menu"
            );

            return json_encode($data_result);
        }
    }

    public function insert(Request $request)
    {

        $data = array(
            "id_role" => $request->role,
            "id_menu_function" => $request->menu_function,
            "menu_name" => $request->menu_name,
        );

        $insert = DB::table('tb_menu')->insert($data);

        if ($insert) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil simpan access"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal simpan access"
            );

            return json_encode($data_result);
        }
    }

    public function update(Request $request)
    {
        $data = array(
            "id_role" => $request->role,
            "id_menu_function" => $request->menu_function,
            "menu_name" => $request->menu_name,
        );

        $update = DB::table('tb_menu')->where('id', $request->id)->update($data);

        if ($update) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ubah data access"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ubah data access"
            );

            return json_encode($data_result);
        }
    }

    public function delete(Request $request)
    {
        $delete = DB::table('tb_menu')->where('id', $request->id)->delete();


        if ($delete) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil hapus access",
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal hapus access"
            );

            return json_encode($data_result);
        }
    }
}
