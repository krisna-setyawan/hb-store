<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Supplier extends Migration
{
    public function up()
    {
        // Supplier
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'origin'           => ['type' => 'varchar', 'constraint' => 80],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'slug'             => ['type' => 'varchar', 'constraint' => 255],
            'pemilik'          => ['type' => 'varchar', 'constraint' => 50],
            'no_telp'          => ['type' => 'varchar', 'constraint' => 20],
            'saldo'            => ['type' => 'decimal', 'constraint' => 10, 2],
            'status'           => ['type' => 'enum', 'constraint' => ['Active', 'Inactive'], 'default' => 'Active'],
            'note'             => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nama');
        $this->forge->createTable('supplier', true);
    }

    public function down()
    {
        $this->forge->dropTable('supplier');
    }
}
