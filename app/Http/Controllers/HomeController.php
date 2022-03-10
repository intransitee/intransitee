<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('landingpage.app');
        $get_all_province = DB::table('test_import')
            ->select('province', 'province_name', 'area', 'area_name')
            ->groupBy('province', 'province_name', 'area', 'area_name')
            ->get()->toArray();

        $get_kota_by_province = DB::table('test_import')
            ->select('province', 'province_name', 'area', 'area_name', 'district_name')
            ->groupBy('province', 'province_name', 'area', 'area_name', 'district_name')
            ->where('area', 85) //ambil dari tb test_import
            ->get()->toArray();
        // dd($get_all_province);
        // UPLOAD PROV
        // foreach ($get_all_province as $key => $value) {
        //     # code...

        //     $data = array(
        //         'nama_provinsi' => $value->province_name
        //     );

        //     $set_kecamatan = DB::table('tb_provinsi')->insert($data);
        // }


        // UPLOAD KOTA
        // foreach ($get_all_province as $key => $value) {
        //     # code...
        //     $get_prov_exit = DB::table('tb_provinsi')->where('nama_provinsi', $value->province_name)->first();
        //     $data = array(
        //         'id_provinsi' => $get_prov_exit->id_provinsi,
        //         'nama_kota' => $value->area_name
        //     );

        //     $set_kecamatan = DB::table('tb_kota')->insert($data);
        // }

        // ========================================================================================================

        // UPLOAD KECAMATAN
        // foreach ($get_kota_by_province as $key => $value) {
        //     # code...
        //     $data = array(
        //         'id_kota' => 11, //ambil dari tb_kota
        //         'nama_kecamatan' => $value->district_name
        //     );

        //     $set_kecamatan = DB::table('tb_kecamatan')->insert($data);
        // }
        // dd('berhasil');
        // =========================================================================================================

        $kecamatan_existing = DB::table('tb_kecamatan')
            ->where('id_kota', 11) //ambil dari tb_kota
            ->get()->toArray();
        // dd($kecamatan_existing);
        // UPLOAD KELURAHAN
        foreach ($kecamatan_existing as $key => $value) {
            # code...

            // GET KELURAHAN
            $get_kelurahan = DB::table('test_import')->where('district_name', $value->nama_kecamatan)->get()->toArray();
            $get_kelurahan_exist = DB::table('tb_kelurahan')->where('id_kecamatan', $value->id_kecamatan)->get()->toArray();
            // dd($get_kelurahan);
            foreach ($get_kelurahan as $i => $val) {
                # code...
                $data = array(
                    'id_kecamatan' => $value->id_kecamatan,
                    'kelurahan' => $val->subdistrict_name
                );
                // $set_kelurahan = DB::table('tb_kelurahan')->insert($data);
            }
            // ========================================================================

            foreach ($get_kelurahan_exist as $k => $kel) {
                # code...

                $kel = array(
                    'id_kelurahan' => $kel->id_kelurahan,
                    'kode_pos' => $get_kelurahan[$k]->postal_code
                );
                // $set_kodepos = DB::table('tb_kodepos')->insert($kel);
            }
        }


        // dd('berhasil');
    }

    public function dashboard()
    {
        return view('admin.master.master')->nest('child', 'admin.home');
    }
}
