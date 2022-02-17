<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;


class OrdersImport implements ToModel
{
    public function model(array $row)
    {
        dd('cek');
        return new User([
            'name'     => $row[0],
            'email'    => $row[1],
            'password' => \Hash::make($row[2]),
        ]);
    }
}
