<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UnitAge;

class UnitAgeSeeder extends Seeder
{
    public function run()
    {
        $unit_ages = [
            ['state_id' => 1, 'name' => "Dia"],
            ['state_id' => 1, 'name' => "Semana"],
            ['state_id' => 1, 'name' => "Mes"],
            ['state_id' => 1, 'name' => "Año"],
        ];

        $ua_model = new UnitAge();
        foreach ($unit_ages as $key => $unit_age) {
            $ua_model->save($unit_age);
        }
    }
}
