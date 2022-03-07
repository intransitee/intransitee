<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Pricing;
use App\Imports\ImportPricing;

class PricingController extends Controller
{

    public function __construct()
    {
        $this->middleware('preventBackHistory');
    }

    public function list_pricing(Request $request)
    {
        return view('admin.master.master')->nest('child', 'admin.pricing.list_pricing');
    }

    public function editPrice(Request $request)
    {
        return view('admin.master.master')->nest('child', 'admin.pricing.edit_pricing');
    }

    public function add(Request $request)
    {
        return view('admin.master.master')->nest('child', 'admin.pricing.add_pricing');
    }

    public function insert(Request $request)
    {

        $data = array(
            'id_client' => $request->client,
            'id_service' => $request->service,
            'id_type' => $request->type,
            'id_provinsi' => $request->province,
            'id_kota' => $request->kota,
            'id_kecamatan' => $request->kecamatan,
            'id_kelurahan' => $request->kelurahan,
            'kode_pos' => $request->kodepos,
            'price' => (int)$request->pricing,
        );

        $insert = DB::table('tb_pricing')->insert($data);

        if ($insert) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil simpan pricing"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal simpan pricing"
            );

            return json_encode($data_result);
        }
    }

    public function update(Request $request)
    {
        $area = DB::table('reff_area')->select('id', 'pricing')->where('postal_code', $request->zipcode)->where('id_province', $request->province)->where('id_area', $request->area)->where('id_district', $request->district)->where('id_subdistrict', $request->subdistrict)->first();

        $data = array(
            'id_service' => $request->service,
            'id_type' => $request->type,
            'id_provinsi' => $request->province,
            'id_kota' => $request->kota,
            'id_kecamatan' => $request->kecamatan,
            'id_kelurahan' => $request->kelurahan,
            'kode_pos' => $request->kodepos,
            'price' => (int)$request->pricing,
        );
        // dd($data);
        $update = DB::table('tb_pricing')->where('id', $request->id)->update($data);

        if ($update) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil update pricing"
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal update pricing"
            );

            return json_encode($data_result);
        }
    }

    public function get_pricing(Request $request)
    {
        // dd($request->client);
        $pricing = DB::table('tb_pricing')->select('tb_pricing.id', 'tb_client.account_name', 'reff_service.service', 'reff_type.type', 'price', 'tb_provinsi.nama_provinsi', 'tb_kota.nama_kota', 'tb_kecamatan.nama_kecamatan', 'tb_kelurahan.kelurahan', 'kode_pos')
            ->join('tb_client', 'tb_client.id', '=', 'tb_pricing.id_client')
            ->join('reff_service', 'reff_service.id', '=', 'tb_pricing.id_service')
            ->join('reff_type', 'reff_type.id', '=', 'tb_pricing.id_type')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
            ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
            ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
            ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
            ->where('tb_pricing.id_client', $request->client)
            ->orderBy('tb_pricing.id', 'DESC')
            ->get()->toArray();

        if ($pricing) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil pricing",
                'data' => $pricing
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil pricing"
            );

            return json_encode($data_result);
        }
    }
    public function get_edit_detail(Request $request, $id)
    {
        // dd($request->client);
        $pricing = DB::table('tb_pricing')->select('tb_pricing.id', 'tb_client.account_name', 'reff_service.id as id_service', 'reff_type.id as id_type', 'price', 'tb_provinsi.id_provinsi', 'tb_kota.id_kota', 'tb_kecamatan.id_kecamatan', 'tb_kelurahan.id_kelurahan', 'kode_pos')
            ->join('tb_client', 'tb_client.id', '=', 'tb_pricing.id_client')
            ->join('reff_service', 'reff_service.id', '=', 'tb_pricing.id_service')
            ->join('reff_type', 'reff_type.id', '=', 'tb_pricing.id_type')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
            ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
            ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
            ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
            ->where('tb_pricing.id', $id)
            ->get()->toArray();

        if ($pricing) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil ambil pricing",
                'data' => $pricing
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal ambil pricing"
            );

            return json_encode($data_result);
        }
    }

    public function delete(Request $request)
    {
        $delete = DB::table('tb_pricing')->where('id', $request->id)->delete();


        if ($delete) {
            # code...
            $data_result = array(
                'status' => true,
                'message' => "Berhasil hapus pricing",
            );

            return json_encode($data_result);
        } else {
            $data_result = array(
                'status' => false,
                'message' => "Gagal hapus pricing"
            );

            return json_encode($data_result);
        }
    }

    public function exportPricing($client)
    {
        $check = DB::table('tb_pricing')->count();

        if ($check < 1) {
            # code...
            return redirect()->back()->with('no_pricing', 'Data pricing tidak ada');
        } else {
            return Excel::download(new Pricing($client), rand() . 'export-pricing.xlsx');
        }
    }

    public function importPricing(Request $request)
    {
        $file = $request->file('file');

        $nama_file = rand() . $file->getClientOriginalName();

        $file->move('import_price', $nama_file);

        Excel::import(new ImportPricing, public_path('/import_price/' . $nama_file));

        return redirect()->back()->with('store', 'Berhasil tambah pricing');
    }
}
