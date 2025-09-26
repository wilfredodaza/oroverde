<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Projects extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'state_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'name'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'date'              => ['type' => 'DATE', 'null' => FALSE],
            'percentage_profit' => ['type' => 'DECIMAL(5, 2)', 'default' => 0, 'null' => TRUE],
            'farm'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'ubication'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'project_years'     => ['type' => 'INT', 'constraint' => 11, 'null' => FALSE],

            'created_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('state_id', 'states', 'id');
        $this->forge->createTable('projects');
    }
    
    public function down()
    {
        $this->forge->dropTable('projects');
    }
}
