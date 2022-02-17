<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function checkAuth(Request $request)
    {
        $data = array(
            'email' => $request->email,
            'password' => $request->password
        );

        try {

            $existUser = DB::table('tb_user')->where('email', $request->email)->first();

            if ($existUser) {
                // ada email
                # code...
                if (Hash::check($data['password'], $existUser->password)) {
                    // password cocok
                    $getMenu = DB::table('tb_menu')->where('id_role', $existUser->id_roles)->get();

                    $request->session()->put('id', $existUser->id);
                    $request->session()->put('email', $existUser->email);
                    $request->session()->put('username', $existUser->username);
                    $request->session()->put('client', $existUser->id_client);
                    $request->session()->put('role', $existUser->id_roles);
                    $request->session()->put('akses', $getMenu);

                    $data_result = array(
                        'status' => true,
                        'message' => "Berhasil login"
                    );

                    return json_encode($data_result);
                } else {
                    // password salah
                    $data_result = array(
                        'status' => false,
                        'message' => "Password salah!"
                    );

                    return json_encode($data_result);
                }
            } else {
                // no email/username
                $data_result = array(
                    'status' => false,
                    'message' => "Akun tidak ditemukan"
                );

                return json_encode($data_result);
            }
        } catch (BadResponseException $e) {
            $response = json_decode($e->getResponse()->getBody());
            //$bad_response = $this->responseData($e->getCode(), $response);
            return json_encode($response);
        }
    }
}
