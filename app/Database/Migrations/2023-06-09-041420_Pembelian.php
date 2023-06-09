<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembelian extends Migration
{
    public function up()
    {
        // Pembelian
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pemesanan'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_pemesanan_fixing'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_supplier'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_user'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_gudang'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'jenis_supplier'        => ['type' => 'enum', 'constraint' => ['Non-Haebot', 'Haebot'], 'default' => 'Non-Haebot'],
            'id_perusahaan'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'no_pembelian'          => ['type' => 'varchar', 'constraint' => 30],
            'invoice'               => ['type' => 'varchar', 'constraint' => 30],
            'tanggal'               => ['type' => 'date'],
            'status'                => ['type' => 'enum', 'constraint' => ['Diproses', 'Dikirim', 'Sampai', 'Gagal'], 'default' => 'Diproses'],
            'status_pembayaran'     => ['type' => 'enum', 'constraint' => ['Belum dibayar', 'Dibayar Sebagian', 'Lunas'], 'default' => 'Belum dibayar'],
            'status_inbound'        => ['type' => 'enum', 'constraint' => ['Belum diterima', 'Diterima Sebagian', 'Diterima Semua'], 'default' => 'Belum diterima'],
            'panjang'               => ['type' => 'int', 'constraint' => 11],
            'lebar'                 => ['type' => 'int', 'constraint' => 11],
            'tinggi'                => ['type' => 'int', 'constraint' => 11],
            'berat'                 => ['type' => 'int', 'constraint' => 11],
            'carton_koli'           => ['type' => 'int', 'constraint' => 11],
            'exw'                   => ['type' => 'int', 'constraint' => 11],
            'hf'                    => ['type' => 'int', 'constraint' => 11],
            'ppn_hf'                => ['type' => 'int', 'constraint' => 11],
            'ongkir_port'           => ['type' => 'int', 'constraint' => 11],
            'ongkir_laut_udara'     => ['type' => 'int', 'constraint' => 11],
            'ongkir_transit'        => ['type' => 'int', 'constraint' => 11],
            'ongkir_gudang'         => ['type' => 'int', 'constraint' => 11],
            'bm'                    => ['type' => 'int', 'constraint' => 11],
            'ppn'                   => ['type' => 'int', 'constraint' => 11],
            'pph'                   => ['type' => 'int', 'constraint' => 11],
            'grand_total'           => ['type' => 'int', 'constraint' => 11],
            'catatan'               => ['type' => 'varchar', 'constraint' => 250, 'null' => true],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('no_pembelian');
        $this->forge->addForeignKey('id_pemesanan', 'pemesanan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_pemesanan_fixing', 'pemesanan_fixing', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_supplier', 'supplier', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_gudang', 'gudang', 'id', '', 'CASCADE');
        $this->forge->createTable('pembelian', true);



        // Pembelian List Produk
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pembelian'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_produk'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'qty'                   => ['type' => 'int', 'unsigned' => true],
            'harga_satuan'          => ['type' => 'int', 'unsigned' => true],
            'total_harga'           => ['type' => 'int', 'unsigned' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pembelian', 'pembelian', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('pembelian_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('pembelian_detail');
        $this->forge->dropTable('pembelian');
    }
}
