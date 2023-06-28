<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixingPemesanan extends Migration
{
    public function up()
    {
        // Fixing Pemesanan
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pemesanan'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_supplier'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_user'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_gudang'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'jenis_supplier'        => ['type' => 'enum', 'constraint' => ['Non-Haebot', 'Haebot'], 'default' => 'Non-Haebot'],
            'id_perusahaan'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'invoice'               => ['type' => 'varchar', 'constraint' => 30],
            'no_pemesanan'          => ['type' => 'varchar', 'constraint' => 30],
            'kode_trx_api'          => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'tanggal'               => ['type' => 'date'],
            'status'                => ['type' => 'enum', 'constraint' => ['Fixing', 'Waiting', 'Nego', 'Ok', 'Batal', 'Pembelian'], 'default' => 'Fixing'],
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
        $this->forge->addForeignKey('id_pemesanan', 'pemesanan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_supplier', 'supplier', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_gudang', 'gudang', 'id', '', 'CASCADE');
        $this->forge->createTable('pemesanan_fixing', true);



        // pemesanan fixing List Produk
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pemesanan_fixing'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_produk'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'sku'                   => ['type' => 'varchar', 'constraint' => 80],
            'qty'                   => ['type' => 'int', 'unsigned' => true],
            'harga_satuan'          => ['type' => 'int', 'unsigned' => true],
            'total_harga'           => ['type' => 'int', 'unsigned' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pemesanan_fixing', 'pemesanan_fixing', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('pemesanan_fixing_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('pemesanan_fixing_detail');
        $this->forge->dropTable('pemesanan_fixing');
    }
}
