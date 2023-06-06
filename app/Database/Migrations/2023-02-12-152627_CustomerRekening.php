<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CustomerRekening extends Migration
{
    public function up()
    {
        // Customer Rekening
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_customer'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'atas_nama'        => ['type' => 'varchar', 'constraint' => 80],
            'bank'             => ['type' => 'varchar', 'constraint' => 30],
            'no_rekening'      => ['type' => 'varchar', 'constraint' => 50],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_customer', 'customer', 'id', '', 'CASCADE');
        $this->forge->createTable('customer_no_rekening', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_no_rekening');
    }
}
