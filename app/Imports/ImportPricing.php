<?php

namespace App\Imports;

use DB;
use App\Models\Pricing;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportPricing implements ToModel, WithStartRow
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
        return new Pricing([
            'id_client' => $row[0],
            'id_provinsi' => $row[1],
            'id_kota' => $row[2],
            'id_kecamatan' => $row[3],
            'id_kelurahan' => $row[4],
            'kode_pos' => $row[5],
            'id_service' => $row[6],
            'id_type' => $row[7],
            "price" => $row[8]
        ]);
    }
}
