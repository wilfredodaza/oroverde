<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contracts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => FALSE],
            'version'       => ['type' => 'INT', 'constraint' => 11, 'null' => FALSE],
            'description'   => ['type' => 'TEXT', 'null' => TRUE],

            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('contracts');
    }

    public function down()
    {
        $this->forge->dropTable('contracts');
    }
}
