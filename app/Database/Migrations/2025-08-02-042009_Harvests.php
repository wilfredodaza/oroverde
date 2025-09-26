<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Harvests extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'product_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
            'year'          => ['type' => 'INT', 'null' => FALSE],
            'production'         => ['type' => 'INT', 'null' => TRUE],
            'position'      => ['type' => 'INT', 'constraint' => 3, 'null' => TRUE],
            'status'        => ['type' => 'ENUM("active", "inactive")',  'default' => 'active'],
            'created_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'    => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('product_id', 'products', 'id');
        $this->forge->createTable('harvests');
    }

    public function down()
    {
        $this->forge->dropTable('harvests');
    }
}
