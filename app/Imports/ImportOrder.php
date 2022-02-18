<?php

namespace App\Imports;

use DB;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportOrder implements ToModel, WithStartRow
{

    public function startRow(): int
    {
        return 2;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $check = DB::table('tb_order')->orderBy('id', 'DESC')->first();

        $res = $check->id + 1;

        if ($res < 10) {
            # code...
            $number = str_pad($res, 3, "0", STR_PAD_LEFT);
        } elseif ($res > 9 && $res < 100) {
            # code...
            $number = str_pad($res, 3, "0", STR_PAD_LEFT);
        } else {
            $number = str_pad($res, 3, "0", STR_PAD_LEFT);
        }

        $generateawb = 'IN' . date("Y-m-d") . $number;
        $awb = str_replace('-', '', $generateawb);
        // dd($awb);
        $ship_temp_area = DB::table('reff_area')->where('id_area', $row[7])->first();
        $ship_temp_district = DB::table('reff_area')->where('id_district', $row[8])->first();

        $recip_temp_area = DB::table('reff_area')->where('id_area', $row[13])->first();
        $recip_temp_district = DB::table('reff_area')->where('id_district', $row[14])->first();

        return new Order([
            'awb' => $awb,
            'reff_id' => $row[24],
            'id_client' => $row[0],
            'id_type' => $row[1],
            "id_service" => $row[2],
            "shipper_name" => $row[3],
            "shipper_phone" => $row[4],
            "shipper_address" => $row[5],
            "shipper_zipcode" => $row[6],
            "shipper_area" => $row[7],
            "shipper_temp_area" => $ship_temp_area->area,
            "shipper_district" => $row[8],
            "shipper_temp_district" => $ship_temp_district->district,
            "recipient_name" => $row[9],
            "recipient_phone" => $row[10],
            "recipient_address" => $row[11],
            "recipient_zip_code" => $row[12],
            "recipient_area" => $row[13],
            "recipient_temp_area" => $recip_temp_area->area,
            "recipient_district" => $row[14],
            "recipient_temp_district" => $recip_temp_district->district,
            "weight" => $row[15],
            "value_of_goods" => $row[16],
            "id_status" => 1,
            "is_cod" => $row[17],
            "is_insured" => $row[18],
            "insurance_fee" => $row[19],
            "cod_fee" => $row[20],
            "total_fee" => $row[21],
            "collection_scheduled_date" => $row[22],
            "delivery_scheduled_date" => $row[23],
            "bulk_log_status" => 0
        ]);

        // return DB::table('reff_order_logs')->insert($data_log);
        // return DB::table('tb_order')->insert($data);
    }
}
