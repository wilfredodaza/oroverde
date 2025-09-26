<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Banner extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'reference' => ['type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE],
            'type'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'title'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'sub_title' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'image'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('reference', 'menus', 'id');
		$this->forge->createTable('banners');
    }

    public function down()
    {		
        $this->forge->dropTable('banners');
    }
}
