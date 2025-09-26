<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class States extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'option_state'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'icon'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'background'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'font'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
            'code'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
		$this->forge->createTable('states');
    }

    public function down()
    {
		$this->forge->dropTable('states');
    }
}
