<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\TypeMovement as TypeMovementM;

class TypeMovement extends Seeder
{
    public function run()
    {
        $type_movements = [
            ['state_id' => 1,'name' => 'Carga Inicial', 'abbreviation' => 'load', 'color' => 'indigo', 'code' => 'C/I'],
            ['state_id' => 1,'name' => 'Venta', 'abbreviation' => 'sale', 'color' => 'green', 'code' => 'Ve'],
            ['state_id' => 1,'name' => 'Pago / Abono', 'abbreviation' => 'payments', 'color' => 'orange', 'code' => 'P/A'],
            ['state_id' => 1,'name' => 'Cosecha', 'abbreviation' => 'harvest', 'color'  => 'blue', 'code' => 'Co'],
            ['state_id' => 1,'name' => 'Utilidades', 'abbreviation' => 'utilities', 'color' => 'pink', 'code' => 'Ut'],
        ];
        $tm_model = new TypeMovementM();
        foreach ($type_movements as $key => $type) {
            $tm_model->save($type);
        }
    }
}
