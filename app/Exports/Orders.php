<?php

namespace App\Exports;

use App\User;
use DB;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class Orders implements FromArray, WithCustomCsvSettings, WithHeadings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ["Awb", "Client", "Type", "Service", "Shipper name", "Shipper phone", "Shipper address", "Shipper provinsi", "Shipper kota", "Shipper kecamatan", "Shipper Kelurahan", "Shipper postal code", "Recipient name", "Recipient phone", "Recipient address", "Recipient zipcode", "Recipient area", "Recipient district", "Weight", " Value Of Good", "Status", "Is insured", "Is cod", "Insurance fee", "Cod fee", "Total fee", "Schedule collection", "Schedule delivery", "Created at", "Last Updated", "Pending Date", "Intransit Date", "Completed Date", "Fail attempt 1 Date", "Failed Date", "Cancelled Date"];
    }

    public function array(): array
    {

        if (session('role') != 3) {
            # code...
            $order = DB::table('tb_order_backup')
                ->select('tb_order_backup.id', 'tb_order_backup.awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'shipper_name', 'shipper_phone', 'shipper_address', 'nama_provinsi', 'nama_kota', 'nama_kecamatan', 'kelurahan', 'kode_pos', 'recipient_name', 'recipient_phone', 'recipient_address', 'weight', 'value_of_goods', 'reff_status.status', 'is_insured', 'is_cod', 'tb_order_backup.insurance_fee', 'tb_order_backup.cod_fee', 'total_fee', 'collection_scheduled_date', 'delivery_scheduled_date', 'created_date', 'last_updated', 'pending_date', 'in_transit_date', 'completed_date', 'fail_attempt_1_date', 'fail_date', 'cancelled_date')
                ->join('tb_client', 'tb_client.id', '=', 'tb_order_backup.id_client')
                ->join('reff_type', 'reff_type.id', '=', 'tb_order_backup.id_type')
                ->join('reff_service', 'reff_service.id', '=', 'tb_order_backup.id_service')
                ->join('reff_status', 'reff_status.id', '=', 'tb_order_backup.id_status')
                ->join('tb_pricing', 'tb_pricing.id', '=', 'tb_order_backup.shipper_pricing_area')
                ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
                ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
                ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
                ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
                ->orderBy('tb_order_backup.id', 'DESC')
                ->get();

            $data = [];

            foreach ($order as $key => $value) {
                # code...
                $recipt = DB::table('tb_order_backup')
                    ->select('nama_provinsi', 'nama_kota', 'nama_kecamatan', 'kelurahan', 'kode_pos')
                    ->join('tb_pricing', 'tb_pricing.id', '=', 'tb_order_backup.recipient_pricing_area')
                    ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
                    ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
                    ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
                    ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
                    ->where('tb_order_backup.id', $value->id)
                    ->first();

                $data[] = [
                    "Awb" => $value->awb,
                    "Client" => $value->account_name,
                    "Type" => $value->type,
                    "Service" => $value->service,
                    "Shipper name" => $value->shipper_name,
                    "Shipper phone" => $value->shipper_phone,
                    "Shipper address" => $value->shipper_address,
                    "Shipper provinsi" => $value->nama_provinsi,
                    "Shipper kota" => $value->nama_kota,
                    "Shipper kecamatan" => $value->nama_kecamatan,
                    "Shipper kelurahan" => $value->kelurahan,
                    "Shipper kode pos" => $value->kode_pos,
                    "Recipient name" => $value->recipient_name,
                    "Recipient phone" => $value->recipient_phone,
                    "Recipient address" => $value->recipient_address,
                    "Recipient provinsi" => $recipt->nama_provinsi,
                    "Recipient kota" => $recipt->nama_kota,
                    "Recipient kecamatan" => $recipt->nama_kecamatan,
                    "Recipient kelurahan" => $recipt->kelurahan,
                    "Recipient kode pos" => $recipt->kode_pos,
                    "Weight" => $value->weight,
                    "Value Of Good" => $value->value_of_goods,
                    "Status" => $value->status,
                    "Is insured" => $value->is_insured,
                    "Is cod" => $value->is_cod,
                    "Total fee" => $value->total_fee,
                    "Schedule collection" => $value->collection_scheduled_date,
                    "Schedule delivery" => $value->delivery_scheduled_date,
                    "Created at" => $value->created_date,
                    "Last Updated" => $value->last_updated,
                    "Pending Date" => $value->pending_date,
                    "Intransit Date" => $value->in_transit_date,
                    "Completed Date" => $value->completed_date,
                    "Fail attempt 1 Date" => $value->fail_attempt_1_date,
                    "Failed Date" => $value->fail_date,
                    "Cancelled Date" => $value->cancelled_date,
                ];
            }

            return $data;
        } else {
            $order = DB::table('tb_order_backup')
                ->select('tb_order_backup.id', 'tb_order_backup.awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'shipper_name', 'shipper_phone', 'shipper_address', 'nama_provinsi', 'nama_kota', 'nama_kecamatan', 'kelurahan', 'kode_pos', 'recipient_name', 'recipient_phone', 'recipient_address', 'weight', 'value_of_goods', 'reff_status.status', 'is_insured', 'is_cod', 'tb_order_backup.insurance_fee', 'tb_order_backup.cod_fee', 'total_fee', 'collection_scheduled_date', 'delivery_scheduled_date', 'created_date', 'last_updated', 'pending_date', 'in_transit_date', 'completed_date', 'fail_attempt_1_date', 'fail_date', 'cancelled_date')
                ->join('tb_client', 'tb_client.id', '=', 'tb_order_backup.id_client')
                ->join('reff_type', 'reff_type.id', '=', 'tb_order_backup.id_type')
                ->join('reff_service', 'reff_service.id', '=', 'tb_order_backup.id_service')
                ->join('reff_status', 'reff_status.id', '=', 'tb_order_backup.id_status')
                ->join('tb_pricing', 'tb_pricing.id', '=', 'tb_order_backup.shipper_pricing_area')
                ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
                ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
                ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
                ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
                ->orderBy('tb_order_backup.id', 'DESC')
                ->where('tb_order_backup.id_client', session('client'))
                ->get();

            $data = [];

            foreach ($order as $key => $value) {
                # code...
                $recipt = DB::table('tb_order_backup')
                    ->select('nama_provinsi', 'nama_kota', 'nama_kecamatan', 'kelurahan', 'kode_pos')
                    ->join('tb_pricing', 'tb_pricing.id', '=', 'tb_order_backup.recipient_pricing_area')
                    ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
                    ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
                    ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
                    ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
                    ->where('tb_order_backup.id', $value->id)
                    ->first();

                $data[] = [
                    "Awb" => $value->awb,
                    "Client" => $value->account_name,
                    "Type" => $value->type,
                    "Service" => $value->service,
                    "Shipper name" => $value->shipper_name,
                    "Shipper phone" => $value->shipper_phone,
                    "Shipper address" => $value->shipper_address,
                    "Shipper provinsi" => $value->nama_provinsi,
                    "Shipper kota" => $value->nama_kota,
                    "Shipper kecamatan" => $value->nama_kecamatan,
                    "Shipper kelurahan" => $value->kelurahan,
                    "Shipper kode pos" => $value->kode_pos,
                    "Recipient name" => $value->recipient_name,
                    "Recipient phone" => $value->recipient_phone,
                    "Recipient address" => $value->recipient_address,
                    "Recipient provinsi" => $recipt->nama_provinsi,
                    "Recipient kota" => $recipt->nama_kota,
                    "Recipient kecamatan" => $recipt->nama_kecamatan,
                    "Recipient kelurahan" => $recipt->kelurahan,
                    "Recipient kode pos" => $recipt->kode_pos,
                    "Weight" => $value->weight,
                    "Value Of Good" => $value->value_of_goods,
                    "Status" => $value->status,
                    "Is insured" => $value->is_insured,
                    "Is cod" => $value->is_cod,
                    "Total fee" => $value->total_fee,
                    "Schedule collection" => $value->collection_scheduled_date,
                    "Schedule delivery" => $value->delivery_scheduled_date,
                    "Created at" => $value->created_date,
                    "Last Updated" => $value->last_updated,
                    "Pending Date" => $value->pending_date,
                    "Intransit Date" => $value->in_transit_date,
                    "Completed Date" => $value->completed_date,
                    "Fail attempt 1 Date" => $value->fail_attempt_1_date,
                    "Failed Date" => $value->fail_date,
                    "Cancelled Date" => $value->cancelled_date,
                ];
            }

            return $data;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     if (session('role') != 3) {
    //         # code...
    //         // $order = DB::table('tb_order')
    //         //     ->select('awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'shipper_name', 'shipper_phone', 'shipper_address', 'shipper_zipcode', 'shipper_temp_area', 'shipper_temp_district', 'recipient_name', 'recipient_phone', 'recipient_address', 'recipient_zip_code', 'recipient_temp_area', 'recipient_temp_district', 'weight', 'value_of_goods', 'reff_status.status', 'is_insured', 'is_cod', 'tb_order.insurance_fee', 'tb_order.cod_fee', 'total_fee', 'collection_scheduled_date', 'delivery_scheduled_date', 'created_date', 'last_updated', 'pending_date', 'in_transit_date', 'completed_date', 'fail_attempt_1_date', 'fail_date', 'cancelled_date')
    //         //     ->join('tb_client', 'tb_client.id', '=', 'tb_order.id_client')
    //         //     ->join('reff_type', 'reff_type.id', '=', 'tb_order.id_type')
    //         //     ->join('reff_service', 'reff_service.id', '=', 'tb_order.id_service')
    //         //     ->join('reff_status', 'reff_status.id', '=', 'tb_order.id_status')
    //         //     ->orderBy('tb_order.id', 'DESC')
    //         //     ->get();

    //         $order = DB::table('tb_order_backup')
    //             ->select('tb_order_backup.awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'shipper_name', 'shipper_phone', 'shipper_address', 'nama_provinsi', 'nama_kota', 'nama_kecamatan', 'kelurahan', 'kode_pos', 'recipient_name', 'recipient_phone', 'recipient_address')
    //             ->join('tb_client', 'tb_client.id', '=', 'tb_order_backup.id_client')
    //             ->join('reff_type', 'reff_type.id', '=', 'tb_order_backup.id_type')
    //             ->join('reff_service', 'reff_service.id', '=', 'tb_order_backup.id_service')
    //             ->join('reff_status', 'reff_status.id', '=', 'tb_order_backup.id_status')
    //             ->join('tb_pricing', 'tb_pricing.id', '=', 'tb_order_backup.shipper_pricing_area')
    //             ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
    //             ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
    //             ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
    //             ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
    //             ->orderBy('tb_order_backup.id', 'DESC')
    //             ->get()->toArray();
    //         // dd($order);
    //     } else {
    //         $order = DB::table('tb_order_backup')
    //             ->select('tb_order_backup.id', 'awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'collection_scheduled_date', 'delivery_scheduled_date', 'reff_status.status', 'created_date', 'reff_status.warna')
    //             ->join('tb_client', 'tb_client.id', '=', 'tb_order_backup.id_client')
    //             ->join('reff_type', 'reff_type.id', '=', 'tb_order_backup.id_type')
    //             ->join('reff_service', 'reff_service.id', '=', 'tb_order_backup.id_service')
    //             ->join('reff_status', 'reff_status.id', '=', 'tb_order_backup.id_status')
    //             ->where('id_client', session('client'))
    //             ->orderBy('id', 'DESC')
    //             ->get();

    //         // $order = DB::table('tb_order')
    //         //     ->select('awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'shipper_name', 'shipper_phone', 'shipper_address', 'shipper_zipcode', 'shipper_temp_area', 'shipper_temp_district', 'recipient_name', 'recipient_phone', 'recipient_address', 'recipient_zip_code', 'recipient_temp_area', 'recipient_temp_district', 'weight', 'value_of_goods', 'reff_status.status', 'is_insured', 'is_cod', 'tb_order.insurance_fee', 'tb_order.cod_fee', 'total_fee', 'collection_scheduled_date', 'delivery_scheduled_date', 'created_date', 'last_updated')
    //         //     ->join('tb_client', 'tb_client.id', '=', 'tb_order.id_client')
    //         //     ->join('reff_type', 'reff_type.id', '=', 'tb_order.id_type')
    //         //     ->join('reff_service', 'reff_service.id', '=', 'tb_order.id_service')
    //         //     ->join('reff_status', 'reff_status.id', '=', 'tb_order.id_status')
    //         //     ->where('id_client', session('client'))
    //         //     ->orderBy('tb_order.id', 'DESC')
    //         //     ->get();
    //     }

    //     $data = array(
    //         "awb" => "IN20220303003",
    //         "account_name" => "PT Mayora, Tbk",
    //         "type" => "Delivery",
    //         "service" => "REG",
    //         "shipper_name" => "Manca",
    //         "shipper_phone" => "0877654321",
    //         "shipper_address" => "Puri krakatau hijau blok D5 no 19",
    //         "nama_provinsi" => "Banten",
    //         "nama_kota" => "Kota Cilegon",
    //         "nama_kecamatan" => "Pulomerak",
    //         "kelurahan" => "Lebakgede (Lebak Gede)",
    //         "kode_pos" => 42431,
    //         "recipient_name" => "Agus",
    //         "recipient_phone" => "897675767",
    //         "recipient_address" => "Puri krakatau hijau blok D5 no 19"
    //     );
    //     // $datas = Team::where('reg', 1)->get(['name', 'email']);

    //     // dd($datas);

    //     // dd($export);
    //     return $order;
    //     // return DB::table('tb_user')->select('username', 'email')->get();
    // }
}
