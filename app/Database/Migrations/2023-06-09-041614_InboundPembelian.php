<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InboundPembelian extends Migration
{
    public function up()
    {
        // Inbound Pembelian
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pembelian'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_pj'                 => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'no_inbound'            => ['type' => 'varchar', 'constraint' => 30],
            'tanggal'               => ['type' => 'date'],
            'status_simpan'         => ['type' => 'enum', 'constraint' => ['Unsave', 'Saved'], 'default' => 'Unsave']
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pembelian', 'pembelian', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_pj', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('inbound_pembelian', true);



        // detail Inbound Pembelian
        $fields = [
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pembelian'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_inbound_pembelian'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_produk'                 => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'qty_beli'                  => ['type' => 'int', 'unsigned' => true],
            'qty_diterima_sebelumnya'   => ['type' => 'int', 'unsigned' => true],
            'qty_diterima_sekarang'     => ['type' => 'int', 'unsigned' => true],
            'qty_kurang'                => ['type' => 'int', 'unsigned' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pembelian', 'pembelian', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_inbound_pembelian', 'inbound_pembelian', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('inbound_pembelian_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('inbound_pembelian');
        $this->forge->dropTable('inbound_pembelian_detail');
    }
}
