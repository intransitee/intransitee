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
            'id_area' => $row[1],
            'id_service' => $row[2],
            'id_type' => $row[3],
            "price" => $row[4]
        ]);
    }
}
