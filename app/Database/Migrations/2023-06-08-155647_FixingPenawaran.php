<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixingPenawaran extends Migration
{
    public function up()
    {
        // Fixing Penawaran
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_penawaran'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_customer'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_user'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'tanggal'               => ['type' => 'date'],
            'status'                => ['type' => 'enum', 'constraint' => ['Fixing', 'Waiting', 'Nego', 'Ok', 'Batal', 'Penjualan'], 'default' => 'Fixing'],
            'panjang'               => ['type' => 'int', 'constraint' => 11],
            'lebar'                 => ['type' => 'int', 'constraint' => 11],
            'tinggi'                => ['type' => 'int', 'constraint' => 11],
            'berat'                 => ['type' => 'int', 'constraint' => 11],
            'carton_koli'           => ['type' => 'int', 'constraint' => 11],

            'total_harga_produk'    => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'diskon'                => ['type' => 'int', 'constraint' => 11],
            'grand_total'           => ['type' => 'int', 'constraint' => 11],

            'nama_alamat'           => ['type' => 'varchar', 'constraint' => 80, 'null' => true],
            'id_provinsi'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_kota'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_kecamatan'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_kelurahan'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'detail_alamat'         => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'penerima'              => ['type' => 'varchar', 'constraint' => 80, 'null' => true],
            'no_telp'               => ['type' => 'varchar', 'constraint' => 20, 'null' => true],

            'kode_promo'            => ['type' => 'varchar', 'constraint' => 250, 'null' => true],
            'catatan'               => ['type' => 'varchar', 'constraint' => 250, 'null' => true],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_customer', 'customer', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('penawaran_fixing', true);



        // Penjualan List Produk
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_penawaran_fixing'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_produk'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'sku'                   => ['type' => 'varchar', 'constraint' => 80],
            'qty'                   => ['type' => 'int', 'unsigned' => true],
            'harga_satuan'          => ['type' => 'int', 'unsigned' => true],
            'diskon'                => ['type' => 'int', 'unsigned' => true],
            'biaya_tambahan'        => ['type' => 'int', 'unsigned' => true],
            'total_harga'           => ['type' => 'int', 'unsigned' => true],
            'berat'                 => ['type' => 'varchar', 'constraint' => 80, 'null' => true],
            'catatan'               => ['type' => 'varchar', 'constraint' => 250, 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penawaran_fixing', 'penawaran_fixing', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('penawaran_fixing_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('penawaran_fixing_detail');
        $this->forge->dropTable('penawaran_fixing');
    }
}
