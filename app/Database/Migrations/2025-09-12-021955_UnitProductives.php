<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnitProductives extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'state_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'unit_age_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'code'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            // 'value'         => ['type' => 'DECIMAL(20, 2)', 'constraint' => 255, 'null' => TRUE],

            'created_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('state_id', 'states', 'id');
        $this->forge->addForeignKey('unit_age_id', 'unit_ages', 'id');
        $this->forge->createTable('unit_productives');
    }
    
    public function down()
    {
        $this->forge->dropTable('unit_productives');
    }
}
