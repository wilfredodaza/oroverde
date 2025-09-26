<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

use App\Models\TypeMovement as TypeMovementM;

class TypeMovement extends Seeder
{
    public function run()
    {
        $type_movements = [
            ['state_id' => 1,'name' => 'Carga Inicial', 'abbreviation' => 'load'],
            ['state_id' => 1,'name' => 'Venta', 'abbreviation' => 'sale'],
            ['state_id' => 1,'name' => 'Pago / Abono', 'abbreviation' => 'payments'],
            ['state_id' => 1,'name' => 'Cosecha', 'abbreviation' => 'harvest'],
            ['state_id' => 1,'name' => 'Utilidades', 'abbreviation' => 'utilities'],
        ];
        $tm_model = new TypeMovementM();
        foreach ($type_movements as $key => $type) {
            $tm_model->save($type);
        }
    }
}
