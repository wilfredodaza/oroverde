<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $company = [
            "type_document_id"  => 3,
            "name"              => "Oro Verde",
            "number_nit"        => 987654321,
            "dv"                => 8,
            "origin"            => "Bogotá",
            "business_number"   => 685264529,

            "propierty"         => "Wilfredo Daza",
            "issued"            => "Bogotá",
            "ubication"         => "Bogotá",
            "number_document"   => 123456789,
        ];
        $c_model = new Company();
        $c_model->save($company);
    }
}
