<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BanksAccounts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'state_id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'bank_id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'bank_account_type_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => FALSE],
            'customer_id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE],
            'name'                  => ['type' => 'VARCHAR', 'constraint' => 255],
            'number_account'        => ['type' => 'BIGINT', 'null' => FALSE]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('state_id', 'states', 'id');
        $this->forge->addForeignKey('bank_id', 'banks', 'id');
        $this->forge->addForeignKey('bank_account_type_id', 'bank_account_types', 'id');
        $this->forge->addForeignKey('customer_id', 'customers', 'id');
		$this->forge->createTable('banks_accounts');
    }

    public function down()
    {
		$this->forge->dropTable('banks_accounts');
    }
}
