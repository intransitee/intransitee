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
        if ($check == null) {
            # code...
            $res = 1;
        } else {
            $res = $check->id + 1;
        }


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

        if ($row[1] == 2) {
            # code...
            $harga_pricing = $row[10];
        } else {
            $harga_pricing = $row[6];
        }

        $harga_dari_pricing = DB::table('tb_pricing')->where('id', $harga_pricing)->first();

        $delivery_fee = (int)$row[11] * (int)$harga_dari_pricing->price;


        if ($row[13] == 1) {
            # code...
            $client = DB::table('tb_client')->where('id', $row[0])->first();
            $harga_cod = $client->cod_fee / 100 * (int)$row[12];
        } else {
            $harga_cod = 0;
        }

        if ($row[14 == 1]) {
            # code...
            $client = DB::table('tb_client')->where('id', $row[0])->first();
            $harga_insurance = $client->insurance_fee / 100 * (int)$row[12];
        } else {
            $harga_insurance = $client->insurance_fee / 100 * (int)$row[12];
        }

        $total_harga = $harga_cod + $harga_insurance + $delivery_fee;

        return new Order([
            'awb' => $awb,
            'reff_id' => $row[17],
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
            "insurance_fee" => $harga_insurance,
            "cod_fee" => $harga_cod,
            "total_fee" => (int)$total_harga,
            "collection_scheduled_date" => $row[15],
            "delivery_scheduled_date" => $row[16],
            "bulk_log_status" => 0,
            "delivery_fee" => $delivery_fee
        ]);
    }
}
