<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PriceAges extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'unit_productive_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'age'                   => ['type' => 'INT', 'constraint' => 11, 'null' => TRUE],
            'value'                 => ['type' => 'DECIMAL(20, 2)', 'null' => TRUE],

            'created_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('unit_productive_id', 'unit_productives', 'id');
        $this->forge->createTable('price_ages');
    }

    public function down()
    {
        $this->forge->dropTable('price_ages');
    }
}
