<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
    public function up()
    {
        // kategori produk
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'             => ['type' => 'varchar', 'constraint' => 255],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('produk_kategori', true);


        // Gudang
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'id_provinsi'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_kota'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_kecamatan'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_kelurahan'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'detail_alamat'    => ['type' => 'varchar', 'constraint' => 255],
            'no_telp'          => ['type' => 'varchar', 'constraint' => 20],
            'keterangan'       => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nama');
        $this->forge->createTable('gudang', true);


        // Produk
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_kategori'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'sku'                   => ['type' => 'varchar', 'constraint' => 80],
            'hs_code'               => ['type' => 'varchar', 'constraint' => 80],
            'nama'                  => ['type' => 'varchar', 'constraint' => 80],
            'slug'                  => ['type' => 'varchar', 'constraint' => 255],
            'satuan'                => ['type' => 'enum', 'constraint' => ['Pcs', 'Unit'], 'default' => 'Pcs'],
            'tipe'                  => ['type' => 'enum', 'constraint' => ['UNKNOWN', 'SET', 'SINGLE', 'ECER'], 'default' => 'UNKNOWN'],
            'jenis'                 => ['type' => 'enum', 'constraint' => ['Produk Digital', 'Produk Fisik'], 'default' => 'Produk Digital'],
            'hg_produk_penyusun'    => ['type' => 'int', 'unsigned' => true, 'default' => 0],
            'harga_beli'            => ['type' => 'int', 'unsigned' => true],
            'harga_jual'            => ['type' => 'int', 'unsigned' => true],
            'stok'                  => ['type' => 'int', 'constraint' => 11,],
            'berat'                 => ['type' => 'decimal', 'constraint' => 3, 1],
            'panjang'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'lebar'                 => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'tinggi'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'minimal_penjualan'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'kelipatan_penjualan'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'status_marketing'      => ['type' => 'enum', 'constraint' => ['Belum desain', 'Sudah desain', 'Sudah dipost',], 'default' => 'Belum desain'],
            'note'                  => ['type' => 'varchar', 'constraint' => 255],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nama');
        $this->forge->addForeignKey('id_kategori', 'produk_kategori', 'id', '', 'CASCADE');
        $this->forge->createTable('produk', true);


        // Produk Plan
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_produk_jadi'        => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_produk_bahan'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'qty_bahan'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_produk_jadi', 'produk', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk_bahan', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('produk_plan', true);
    }

    public function down()
    {
        $this->forge->dropTable('produk_kategori');
        $this->forge->dropTable('gudang');
        $this->forge->dropTable('produk');
        $this->forge->dropTable('produk_plan');
    }
}
