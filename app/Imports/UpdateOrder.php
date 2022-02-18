<?php

namespace App\Imports;

use DB;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UpdateOrder implements ToModel, WithStartRow
{

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $ship_temp_area = DB::table('reff_area')->where('id_area', $row[8])->first();
        $ship_temp_district = DB::table('reff_area')->where('id_district', $row[9])->first();

        $recip_temp_area = DB::table('reff_area')->where('id_area', $row[14])->first();
        $recip_temp_district = DB::table('reff_area')->where('id_district', $row[15])->first();

        // return new Order([
        //     'awb' => $row[0],
        //     'reff_id' => $row[25],
        //     'id_client' => $row[1],
        //     'id_type' => $row[2],
        //     "id_service" => $row[3],
        //     "shipper_name" => $row[4],
        //     "shipper_phone" => $row[5],
        //     "shipper_address" => $row[6],
        //     "shipper_zipcode" => $row[7],
        //     "shipper_area" => $row[8],
        //     "shipper_temp_area" => $ship_temp_area->area,
        //     "shipper_district" => $row[9],
        //     "shipper_temp_district" => $ship_temp_district->district,
        //     "recipient_name" => $row[10],
        //     "recipient_phone" => $row[11],
        //     "recipient_address" => $row[12],
        //     "recipient_zip_code" => $row[13],
        //     "recipient_area" => $row[14],
        //     "recipient_temp_area" => $recip_temp_area->area,
        //     "recipient_district" => $row[15],
        //     "recipient_temp_district" => $recip_temp_district->district,
        //     "weight" => $row[16],
        //     "value_of_goods" => $row[17],
        //     "id_status" => 1,
        //     "is_cod" => $row[18],
        //     "is_insured" => $row[19],
        //     "insurance_fee" => $row[20],
        //     "cod_fee" => $row[21],
        //     "total_fee" => $row[22],
        //     "collection_scheduled_date" => $row[23],
        //     "delivery_scheduled_date" => $row[24],
        //     "bulk_log_status" => 0
        // ]);


        // return DB::table('reff_order_logs')->insert($data_log);
        // return DB::table('tb_order')->insert($data);
    }
}
