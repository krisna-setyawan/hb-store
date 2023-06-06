<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penjualan extends Migration
{
    public function up()
    {
        // Penjualan
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_penawaran'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_customer'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'id_user'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'no_penjualan'          => ['type' => 'varchar', 'constraint' => 30],
            'tanggal'               => ['type' => 'date'],
            'status'                => ['type' => 'enum', 'constraint' => ['Fixing', 'Request Outbound', 'Pengiriman', 'Diterima', 'Komplain', 'Return', 'Refund', 'Selesai', 'Dihapus'], 'default' => 'Fixing'],
            'status_pembayaran'     => ['type' => 'enum', 'constraint' => ['Belum dibayar', 'Lunas'], 'default' => 'Belum dibayar'],
            'status_outbound'       => ['type' => 'enum', 'constraint' => ['Belum dikirim', 'Dikirim Sebagian', 'Dikirim Semua'], 'default' => 'Belum dikirim'],
            'panjang'               => ['type' => 'int', 'constraint' => 11],
            'lebar'                 => ['type' => 'int', 'constraint' => 11],
            'tinggi'                => ['type' => 'int', 'constraint' => 11],
            'berat'                 => ['type' => 'int', 'constraint' => 11],
            'carton_koli'           => ['type' => 'int', 'constraint' => 11],

            'total_harga_produk'    => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'ongkir'                => ['type' => 'int', 'constraint' => 11, 'null' => true],
            'jasa_kirim'            => ['type' => 'varchar', 'constraint' => 80, 'null' => true],
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
            'alasan_dihapus'        => ['type' => 'varchar', 'constraint' => 150, 'null' => true],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('no_penjualan');
        $this->forge->addForeignKey('id_customer', 'customer', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', '', 'CASCADE');
        // $this->forge->addForeignKey('id_provinsi', 'provinsi', 'id', '', 'CASCADE');
        // $this->forge->addForeignKey('id_kota', 'kota', 'id', '', 'CASCADE');
        // $this->forge->addForeignKey('id_kecamatan', 'kecamatan', 'id', '', 'CASCADE');
        // $this->forge->addForeignKey('id_kelurahan', 'kelurahan', 'id', '', 'CASCADE');
        $this->forge->createTable('penjualan', true);



        // Penjualan List Produk
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_penjualan'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_produk'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
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
        $this->forge->addForeignKey('id_penjualan', 'penjualan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('penjualan_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('penjualan');
        $this->forge->dropTable('penjualan_detail');
    }
}
