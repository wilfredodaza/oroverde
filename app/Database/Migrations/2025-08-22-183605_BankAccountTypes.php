<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BankAccountTypes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'state_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'code'          => ['type' => 'VARCHAR', 'constraint' => 255],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('state_id', 'states', 'id');
		$this->forge->createTable('bank_account_types');
    }

    public function down()
    {
		$this->forge->dropTable('bank_account_types');
    }
}
