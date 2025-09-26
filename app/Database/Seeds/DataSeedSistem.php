<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeedSistem extends Seeder
{
    public function run()
    {
        $this->call('StateSeeder');
        $this->call('UnitMeasurementSeeder');
        $this->call('UnitAgeSeeder');
        $this->call('TypeDocuments');
        $this->call('TypeMovement');
        $this->call('PaymentMethodSeeder');
        $this->call('CompanySeeder');
        $this->call('BanksSeeder');
        $this->call('BanksAccountTypeSeeder');
    }
}
