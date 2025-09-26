<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentMethods extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment'  => TRUE],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'code'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE],
        ]);
        $this->forge->addKey('id', TRUE);
		$this->forge->createTable('payment_methods');
    }

    public function down()
    {
		$this->forge->dropTable('payment_methods');
    }
}
