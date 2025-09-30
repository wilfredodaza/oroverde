<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'unit_age_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'name'              => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'       => ['type' => 'TEXT', 'null' => TRUE],
            'price'             => ['type' => 'FLOAT', 'null' => TRUE],
            'stock'             => ['type' => 'INT', 'null' => TRUE],
            'sales_percentage'  => ['type' => 'FLOAT', 'null' => TRUE],
            'individual_value'  => ['type' => 'FLOAT', 'null' => TRUE],
            'ipc'               => ['type' => 'FLOAT', 'null' => TRUE],
            'status'            => ['type' => 'ENUM("active", "inactive")',  'default' => 'active'],
            'created_at'        => ['type' => 'DATETIME', 'null' => TRUE],
            'updated_at'        => ['type' => 'DATETIME', 'null' => TRUE],
            'deleted_at'        => ['type' => 'DATETIME', 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('unit_age_id', 'unit_ages', 'id');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
