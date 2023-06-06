<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penawaran extends Migration
{
    public function up()
    {
        // Penawaran
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_customer'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_user'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'no_penawaran'          => ['type' => 'varchar', 'constraint' => 30],
            'tanggal'               => ['type' => 'date'],
            'total_harga_produk'    => ['type' => 'int', 'unsigned' => true],
            'status'                => ['type' => 'enum', 'constraint' => ['Pending', 'Ordered', 'Fixing', 'Penjualan', 'Pengiriman', 'Diterima', 'Komplain', 'Return', 'Refund', 'Selesai', 'Dihapus'], 'default' => 'Pending'],
            'alasan_dihapus'        => ['type' => 'varchar', 'constraint' => 250, 'null' => true],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('no_penawaran');
        $this->forge->addForeignKey('id_customer', 'customer', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('penawaran', true);



        // Penawaran List Produk
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_penawaran'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_produk'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'qty'                   => ['type' => 'int', 'unsigned' => true],
            'harga_satuan'          => ['type' => 'int', 'unsigned' => true],
            'total_harga'           => ['type' => 'int', 'unsigned' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penawaran', 'penawaran', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('penawaran_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('penawaran_detail');
        $this->forge->dropTable('penawaran');
    }
}
