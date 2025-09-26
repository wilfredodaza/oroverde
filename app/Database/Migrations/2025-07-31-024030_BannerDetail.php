<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BannerDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'reference'     => ['type' => 'INT', 'constraint' => '11', 'unsigned' => TRUE, 'null' => TRUE],
            'type'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'orden'         => ['type' => 'INT', 'default' => 1],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'sub_title'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'description'   => ['type' => 'TEXT', 'null' => TRUE],
            'url'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'file'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('reference', 'banners', 'id');
        $this->forge->createTable('banners_details');
    }

    public function down()
    {
		$this->forge->dropTable('banners_details');
    }
}
