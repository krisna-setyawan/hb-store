<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SupplierCS extends Migration
{
    public function up()
    {
        // Supplier CS
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_supplier'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'no_telp'             => ['type' => 'varchar', 'constraint' => 255],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_supplier', 'supplier', 'id', '', 'CASCADE');
        $this->forge->createTable('supplier_cs', true);
    }

    public function down()
    {
        $this->forge->dropTable('supplier_cs');
    }
}
