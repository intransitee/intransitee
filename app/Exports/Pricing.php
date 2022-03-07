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
        return ["id", "Account Name", "Province", "City", "District", "Subdistrict", "Postal code", "Service", "Type", "Price", "Created at"];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $pricing = DB::table('tb_pricing')->select('tb_pricing.id', 'tb_client.account_name', 'tb_provinsi.nama_provinsi', 'tb_kota.nama_kota', 'tb_kecamatan.nama_kecamatan', 'tb_kelurahan.kelurahan', 'kode_pos', 'reff_service.service', 'reff_type.type', 'price', 'tb_pricing.created_at')
            ->join('tb_client', 'tb_client.id', '=', 'tb_pricing.id_client')
            ->join('reff_service', 'reff_service.id', '=', 'tb_pricing.id_service')
            ->join('reff_type', 'reff_type.id', '=', 'tb_pricing.id_type')
            ->join('tb_provinsi', 'tb_provinsi.id_provinsi', '=', 'tb_pricing.id_provinsi')
            ->join('tb_kota', 'tb_kota.id_kota', '=', 'tb_pricing.id_kota')
            ->join('tb_kecamatan', 'tb_kecamatan.id_kecamatan', '=', 'tb_pricing.id_kecamatan')
            ->join('tb_kelurahan', 'tb_kelurahan.id_kelurahan', '=', 'tb_pricing.id_kelurahan')
            ->where('tb_pricing.id_client', $this->client)
            ->orderBy('tb_pricing.id', 'DESC')
            ->get();

        return $pricing;
    }
}
