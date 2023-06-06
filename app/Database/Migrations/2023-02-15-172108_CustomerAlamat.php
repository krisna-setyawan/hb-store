<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CustomerAlamat extends Migration
{
    public function up()
    {
        // customer alamat
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_customer'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'id_provinsi'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_kota'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_kecamatan'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_kelurahan'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'detail_alamat'    => ['type' => 'varchar', 'constraint' => 255],
            'penerima'         => ['type' => 'varchar', 'constraint' => 80],
            'no_telp'          => ['type' => 'varchar', 'constraint' => 20],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_customer', 'customer', 'id', '', 'CASCADE');
        // $this->forge->addForeignKey('id_provinsi', 'provinsi', 'id', '', 'CASCADE');
        // $this->forge->addForeignKey('id_kota', 'kota', 'id', '', 'CASCADE');
        // $this->forge->addForeignKey('id_kecamatan', 'kecamatan', 'id', '', 'CASCADE');
        // $this->forge->addForeignKey('id_kelurahan', 'kelurahan', 'id', '', 'CASCADE');
        $this->forge->createTable('customer_alamat', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_alamat');
    }
}
