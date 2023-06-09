<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pemesanan extends Migration
{
    public function up()
    {
        // Pemesanan
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_supplier'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_user'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_gudang'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'no_pemesanan'          => ['type' => 'varchar', 'constraint' => 30],
            'tanggal'               => ['type' => 'date'],
            'total_harga_produk'    => ['type' => 'int', 'unsigned' => true],
            'status'                => ['type' => 'enum', 'constraint' => ['Pending', 'Ordered', 'Waiting', 'Ditolak', 'Fixing', 'Pembelian', 'Dikirim', 'Sampai', 'Batal', 'Dihapus'], 'default' => 'Pending'],
            'alasan_dihapus'        => ['type' => 'varchar', 'constraint' => 250, 'null' => true],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('no_pemesanan');
        $this->forge->addForeignKey('id_supplier', 'supplier', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_gudang', 'gudang', 'id', '', 'CASCADE');
        $this->forge->createTable('pemesanan', true);



        // Pemesanan List Produk
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pemesanan'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_produk'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'sku'                   => ['type' => 'varchar', 'constraint' => 80],
            'qty'                   => ['type' => 'int', 'unsigned' => true],
            'harga_satuan'          => ['type' => 'int', 'unsigned' => true],
            'total_harga'           => ['type' => 'int', 'unsigned' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pemesanan', 'pemesanan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('pemesanan_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemesanan_detail');
        $this->forge->dropTable('pemesanan');
    }
}
