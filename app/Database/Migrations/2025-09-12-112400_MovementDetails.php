<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MovementDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'movement_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
            'state_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'unit_productive_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'unit_measurement_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
             
            'value'                 => ['type' => 'DECIMAL(20, 2)', 'null' => TRUE],
            'quantity'          => ['type' => 'INT', 'constraint' => 11, 'null' => TRUE],

            'created_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('movement_id', 'movements', 'id');
        $this->forge->addForeignKey('state_id', 'states', 'id');
        $this->forge->addForeignKey('unit_productive_id', 'unit_productives', 'id');
        $this->forge->addForeignKey('unit_measurement_id', 'unit_measurements', 'id');
        $this->forge->createTable('movement_details');
    }

    public function down()
    {
        $this->forge->dropTable('movement_details');
    }
}
