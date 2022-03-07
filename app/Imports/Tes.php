<?php

namespace App\Imports;

use DB;
use App\Models\Test;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Tes implements ToModel, WithStartRow
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
        return new Test([
            'id' => $row[0],
            'postal_code' => $row[1],
            'province' => $row[2],
            'province_name' => $row[3],
            "area" => $row[4],
            "area_name" => $row[5],
            "district" => $row[6],
            "district_name" => $row[7],
            "subdistrict" => $row[8],
            "subdistrict_name" => $row[9],
            "pricing" => $row[10],
        ]);

        // return DB::table('reff_order_logs')->insert($data_log);
        // return DB::table('tb_order')->insert($data);
    }
}
