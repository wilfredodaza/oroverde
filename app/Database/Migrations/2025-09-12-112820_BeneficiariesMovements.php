<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BeneficiariesMovements extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'movement_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
            'beneficiary_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'state_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],

            'created_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('movement_id', 'movements', 'id');
        $this->forge->addForeignKey('state_id', 'states', 'id');
        $this->forge->addForeignKey('beneficiary_id', 'beneficiaries', 'id');
        $this->forge->createTable('beneficiaries_movements');
    }

    public function down()
    {
        $this->forge->dropTable('beneficiaries_movements');
    }
}
