<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\BankAccountType;

class BanksAccountTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            array('name' => 'Cta Ahorros','code' => 'CA'),
            array('name' => 'Cta Corriente','code' => 'CC')
        ];
        $bat_model = new BankAccountType();
        foreach ($types as $key => $type) {
            $type['state_id'] = 1;
            $bat_model->save($type);
        }
    }
}
