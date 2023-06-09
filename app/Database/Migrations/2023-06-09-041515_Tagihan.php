<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tagihan extends Migration
{
    public function up()
    {
        // tagihan
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pembelian'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'no_tagihan'            => ['type' => 'varchar', 'constraint' => 30],
            'penerima'              => ['type' => 'varchar', 'constraint' => 250],
            'referensi'             => ['type' => 'varchar', 'constraint' => 250],
            'tanggal'               => ['type' => 'date',],
            'asal'                  => ['type' => 'enum', 'constraint' => ['Pembelian'], 'default' => 'Pembelian'],
            'status'                => ['type' => 'enum', 'constraint' => ['Belum dibayar', 'Dibayar Sebagian', 'Lunas'], 'default' => 'Belum dibayar'],
            'jumlah'                => ['type' => 'int', 'constraint' => 11],
            'sisa_tagihan'          => ['type' => 'int', 'constraint' => 11],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pembelian', 'pembelian', 'id', '', 'CASCADE');
        $this->forge->createTable('tagihan', true);



        // rincian tagihan
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_tagihan'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_akun'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'nama_rincian'          => ['type' => 'varchar', 'constraint' => 100],
            'deskripsi'             => ['type' => 'varchar', 'constraint' => 250],
            'jumlah'                => ['type' => 'int', 'constraint' => 11],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_tagihan', 'tagihan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_akun', 'akun', 'id', '', 'CASCADE');
        $this->forge->createTable('tagihan_rincian', true);



        // pembayaran tagihan
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_tagihan'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_user'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_akun_pembayaran'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'tanggal_bayar'         => ['type' => 'date',],
            'jumlah_bayar'          => ['type' => 'int', 'constraint' => 11],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_tagihan', 'tagihan', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_akun_pembayaran', 'akun', 'id', '', 'CASCADE');
        $this->forge->createTable('tagihan_pembayaran', true);
    }

    public function down()
    {
        $this->forge->dropTable('tagihan');
        $this->forge->dropTable('tagihan_rincian');
        $this->forge->dropTable('tagihan_pembayaran');
    }
}
