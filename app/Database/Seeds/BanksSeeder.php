<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\Bank;

class BanksSeeder extends Seeder
{
    public function run()
    {
        $banks_data = [
            ['name' => 'AGRARIO'],
            ['name' => 'AV VILLAS'],
            ['name' => 'BANCOLOMBIA'],
            ['name' => 'BANCOOMEVA'],
            ['name' => 'BBVA'],
            ['name' => 'BNP PARIBAS'],
            ['name' => 'CAJA SOCIAL BCSC'],
            ['name' => 'CITIBANK'],
            ['name' => 'COLPATRIA'],
            ['name' => 'CONFIAR'],
            ['name' => 'COOPERATIVA FINANCIERA DE ANTIOQUIA'],
            ['name' => 'COOPERATIVO COOPCENTRAL S.A'],
            ['name' => 'CORPBANCA COLOMBIA S.A.'],
            ['name' => 'COTRAFA COOPERATIVA FINANCIERA'],
            ['name' => 'DAVIVIENDA'],
            ['name' => 'BANCO DE BOGOTA'],
            ['name' => 'BANDO DE OCCIDENTE'],
            ['name' => 'FALABELLA S.A.'],
            ['name' => 'FINANCIERA JURISCOOP'],
            ['name' => 'FINANDINA S.A.'],
            ['name' => 'GNB COLOMBIA S.A.'],
            ['name' => 'GNB SUDAMERIS'],
            ['name' => 'HELM BANK S.A'],
            ['name' => 'PICHINCHA'],
            ['name' => 'POPULAR'],
            ['name' => 'PROCREDIT COLOMBIA'],
            ['name' => 'SANTANDER DE NEGOCIOS COLOMBIA S.A'],
            ['name' => 'ITAÚ'],
            ['name' => 'NEQUI'],
            ['name' => 'SIN CUENTA'],
            ['name' => 'BANCOMEVA'],
            ['name' => 'LULO BANK'],
            ['name' => 'BANCO AV VILLAS']
        ];
        $b_model = new Bank();
        foreach ($banks_data as $key => $bank) {
            $bank['state_id'] = 1;
            $b_model->save($bank);
        }
    }
}
