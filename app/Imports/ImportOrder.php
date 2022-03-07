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
        $check = DB::table('tb_order_backup')->orderBy('id', 'DESC')->first();
        // dd($check);
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
        // $ship_temp_area = DB::table('reff_area')->where('id_area', $row[7])->first();
        // $ship_temp_district = DB::table('reff_area')->where('id_district', $row[8])->first();

        // $recip_temp_area = DB::table('reff_area')->where('id_area', $row[13])->first();
        // $recip_temp_district = DB::table('reff_area')->where('id_district', $row[14])->first();
        // dd($row);
        return new Order([
            'awb' => $awb,
            'reff_id' => $row[20],
            'id_client' => $row[0],
            'id_type' => $row[1],
            "id_service" => $row[2],
            "shipper_name" => $row[3],
            "shipper_phone" => $row[4],
            "shipper_address" => $row[5],
            "shipper_pricing_area" => $row[6],
            "recipient_name" => $row[7],
            "recipient_phone" => $row[8],
            "recipient_address" => $row[9],
            "recipient_pricing_area" => $row[10],
            "weight" => $row[11],
            "value_of_goods" => $row[12],
            "id_status" => 1,
            "is_cod" => $row[13],
            "is_insured" => $row[14],
            "insurance_fee" => $row[15],
            "cod_fee" => $row[16],
            "total_fee" => $row[17],
            "collection_scheduled_date" => $row[18],
            "delivery_scheduled_date" => $row[19],
            "bulk_log_status" => 0,
            "delivery_fee" => $row[21]
        ]);

        // return DB::table('reff_order_logs')->insert($data_log);
        // return DB::table('tb_order')->insert($data);
    }
}
