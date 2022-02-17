<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Orders implements FromCollection, WithCustomCsvSettings, WithHeadings
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ["Awb", "Client", "Type", "Service", "Shipper name", "Shipper phone", "Shipper address", "Shipper zipcode", "Shipper area", "Shipper district", "Recipient name", "Recipient phone", "Recipient address", "Recipient zipcode", "Recipient area", "Recipient district", "Weight", " Value Of Good", "Status", "Is insured", "Is cod", "Insurance fee", "Cod fee", "Total fee", "Schedule collection", "Schedule delivery", "Created at", "Last Updated"];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        if (session('role') != 3) {
            # code...
            $order = DB::table('tb_order')
                ->select('awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'shipper_name', 'shipper_phone', 'shipper_address', 'shipper_zipcode', 'shipper_temp_area', 'shipper_temp_district', 'recipient_name', 'recipient_phone', 'recipient_address', 'recipient_zip_code', 'recipient_temp_area', 'recipient_temp_district', 'weight', 'value_of_goods', 'reff_status.status', 'is_insured', 'is_cod', 'tb_order.insurance_fee', 'tb_order.cod_fee', 'total_fee', 'collection_scheduled_date', 'delivery_scheduled_date', 'created_date', 'last_updated')
                ->join('tb_client', 'tb_client.id', '=', 'tb_order.id_client')
                ->join('reff_type', 'reff_type.id', '=', 'tb_order.id_type')
                ->join('reff_service', 'reff_service.id', '=', 'tb_order.id_service')
                ->join('reff_status', 'reff_status.id', '=', 'tb_order.id_status')
                ->orderBy('tb_order.id', 'DESC')
                ->get();
        } else {
            $order = DB::table('tb_order')
                ->select('awb', 'tb_client.account_name', 'reff_type.type', 'reff_service.service', 'shipper_name', 'shipper_phone', 'shipper_address', 'shipper_zipcode', 'shipper_temp_area', 'shipper_temp_district', 'recipient_name', 'recipient_phone', 'recipient_address', 'recipient_zip_code', 'recipient_temp_area', 'recipient_temp_district', 'weight', 'value_of_goods', 'reff_status.status', 'is_insured', 'is_cod', 'tb_order.insurance_fee', 'tb_order.cod_fee', 'total_fee', 'collection_scheduled_date', 'delivery_scheduled_date', 'created_date', 'last_updated')
                ->join('tb_client', 'tb_client.id', '=', 'tb_order.id_client')
                ->join('reff_type', 'reff_type.id', '=', 'tb_order.id_type')
                ->join('reff_service', 'reff_service.id', '=', 'tb_order.id_service')
                ->join('reff_status', 'reff_status.id', '=', 'tb_order.id_status')
                ->where('id_client', session('client'))
                ->orderBy('tb_order.id', 'DESC')
                ->get();
        }



        // $export = collect($data);

        // dd($export);
        return $order;
        // return DB::table('tb_user')->select('username', 'email')->get();
    }
}
