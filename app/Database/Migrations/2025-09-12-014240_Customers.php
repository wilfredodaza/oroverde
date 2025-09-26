<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Customers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'state_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'type_document_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'name'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'number_document'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'issued'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],

            'created_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('state_id', 'states', 'id');
        $this->forge->addForeignKey('type_document_id', 'type_documents', 'id');
        $this->forge->createTable('customers');
    }

    public function down()
    {
        $this->forge->dropTable('customers');
    }
}
