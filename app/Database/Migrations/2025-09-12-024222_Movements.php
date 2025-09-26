<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Movements extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'type_movement_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'state_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'user_id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'customer_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
            'project_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'movement_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
            'payment_method_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
             
            'resolution'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'value'             => ['type' => 'DECIMAL(20, 2)', 'null' => TRUE],
            'date'              => ['type' => 'DATE', 'null' => FALSE],
            'support'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],

            'percentage_discount'   => ['type' => 'DECIMAL(5, 2)', 'null' => TRUE],
            'payable_amount'        => ['type' => 'DECIMAL(20,2)', 'default' => 0],

            'created_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('type_movement_id', 'type_movements', 'id');
        $this->forge->addForeignKey('state_id', 'states', 'id');
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->addForeignKey('customer_id', 'customers', 'id');
        $this->forge->addForeignKey('project_id', 'projects', 'id');
        $this->forge->addForeignKey('movement_id', 'movements', 'id');
        $this->forge->addForeignKey('payment_method_id', 'payment_methods', 'id');
        $this->forge->createTable('movements');
    }

    public function down()
    {
        $this->forge->dropTable('movements');
    }
}
