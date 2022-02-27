<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Pricing implements FromCollection, WithCustomCsvSettings, WithHeadings
{

    protected $id_client;

    function __construct($id_client)
    {
        $this->client = $id_client;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return ["id", "Account Name", "Province", "Area", "District", "Subdistrict", "Postal code", "Service", "Type", "Price", "Created at"];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $pricing = DB::table('tb_pricing')->select('tb_pricing.id', 'tb_client.account_name', 'reff_area.province', 'reff_area.area', 'reff_area.district', 'reff_area.subdistrict', 'reff_area.postal_code', 'reff_service.service', 'reff_type.type', 'price', 'tb_pricing.created_at')
            ->join('tb_client', 'tb_client.id', '=', 'tb_pricing.id_client')
            ->join('reff_area', 'reff_area.id', '=', 'tb_pricing.id_area')
            ->join('reff_service', 'reff_service.id', '=', 'tb_pricing.id_service')
            ->join('reff_type', 'reff_type.id', '=', 'tb_pricing.id_type')
            ->where('tb_pricing.id_client', $this->client)
            ->orderBy('tb_pricing.id', 'DESC')
            ->get();

        return $pricing;
    }
}
