<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\TypeDocument;

class TypeDocuments extends Seeder
{
    public function run()
    {
        $type_documents = [
            ['state_id' => 1, 'name' => 'Registro Civil', 'abbreviation' => 'RC'],
            ['state_id' => 1, 'name' => 'Tarjeta de Identidad', 'abbreviation' => 'TI'],
            ['state_id' => 1, 'name' => 'Cédula de Ciudadania', 'abbreviation' => 'CC'],
            ['state_id' => 1, 'name' => 'Tarjeta de Extranjería', 'abbreviation' => 'TE'],
            ['state_id' => 1, 'name' => 'Cédula de Extranjeria', 'abbreviation' => 'CE'],
            ['state_id' => 1, 'name' => 'NIT', 'abbreviation' => 'NIT'],
            ['state_id' => 1, 'name' => 'Pasaporte', 'abbreviation' => 'PAS'],
            ['state_id' => 1, 'name' => 'Documento de Identificacion Extranjero', 'abbreviation' => 'DIE'],
            ['state_id' => 1, 'name' => 'Nit de otro país', 'abbreviation' => 'NOP'],
            ['state_id' => 1, 'name' => 'NUIP *', 'abbreviation' => 'NUIP'],
            ['state_id' => 1, 'name' => 'PEP', 'abbreviation' => 'PEP']
        ];
        $td_model = new TypeDocument();

        foreach ($type_documents as $key => $type) {
            $td_model->save($type);
        }
    }
}
