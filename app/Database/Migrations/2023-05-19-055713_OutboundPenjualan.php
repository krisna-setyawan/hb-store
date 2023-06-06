<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OutboundPenjualan extends Migration
{
    public function up()
    {
        // outbound penjualan
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_penjualan'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_gudang'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_pj'                 => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'no_outbound'           => ['type' => 'varchar', 'constraint' => 30],
            'tanggal'               => ['type' => 'date'],
            'status_simpan'         => ['type' => 'enum', 'constraint' => ['Unsave', 'Saved'], 'default' => 'Unsave']
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penjualan', 'penjualan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_gudang', 'gudang', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_pj', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('outbound_penjualan', true);



        // detail outbound penjualan
        $fields = [
            'id'                        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_penjualan'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_outbound_penjualan'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_produk'                 => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'qty_beli'                  => ['type' => 'int', 'unsigned' => true],
            'qty_dikirim_sebelumnya'    => ['type' => 'int', 'unsigned' => true],
            'qty_dikirim_sekarang'      => ['type' => 'int', 'unsigned' => true],
            'qty_kurang'                => ['type' => 'int', 'unsigned' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penjualan', 'penjualan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_outbound_penjualan', 'outbound_penjualan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('outbound_penjualan_detail', true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('outbound_penjualan');
        $this->forge->dropTable('outbound_penjualan_detail');
    }
}
