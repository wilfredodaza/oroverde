<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TypeDocuments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'state_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'abbreviation'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],

            'created_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('state_id', 'states', 'id');
        $this->forge->createTable('type_documents');
    }

    public function down()
    {
        $this->forge->dropTable('type_documents');
    }
}
