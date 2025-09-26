<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ConfigPage extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'meta_description'          => ['type' => 'TEXT', 'null' => TRUE],
            'meta_keywords'             => ['type' => 'TEXT', 'null' => TRUE],
            'favicon'                   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'name_app'                  => ['type' => 'VARCHAR', 'constraint' => 45],
        ]);
        $this->forge->addKey('id', TRUE);
		$this->forge->createTable('config_page');
    }

    public function down()
    {
		$this->forge->dropTable('config_page');
    }
}
