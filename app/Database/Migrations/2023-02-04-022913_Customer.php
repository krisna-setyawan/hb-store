<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Customer extends Migration
{
    public function up()
    {
        // Customer
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_customer'      => ['type' => 'varchar', 'constraint' => 80],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'slug'             => ['type' => 'varchar', 'constraint' => 255],
            'no_telp'          => ['type' => 'varchar', 'constraint' => 20],
            'email'            => ['type' => 'varchar', 'constraint' => 50],
            'status'           => ['type' => 'enum', 'constraint' => ['Active', 'Inactive'], 'default' => 'Active'],
            'saldo_utama'      => ['type' => 'decimal', 'constraint' => 10, 2, 'default' => 0],
            'saldo_belanja'    => ['type' => 'decimal', 'constraint' => 10, 2, 'default' => 0],
            'saldo_lain'       => ['type' => 'decimal', 'constraint' => 10, 2, 'default' => 0],
            'tgl_registrasi'   => ['type' => 'date', 'null' => true],
            'note'             => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('id_customer');
        $this->forge->addUniqueKey('nama');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('customer', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer');
    }
}
