<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UnitMeasurement;

class UnitMeasurementSeeder extends Seeder
{
    public function run()
    {
        $unit_measurements = [
            ['state_id' => 1, 'name' => 'Kilogramo', 'code' => 'Kg'],
            ['state_id' => 1, 'name' => 'Unidades', 'code' => 'Und'],
        ];

        $um_model = new UnitMeasurement();

        foreach ($unit_measurements as $key => $unit_measurement) {
            $um_model->save($unit_measurement);
        }
    }
}
