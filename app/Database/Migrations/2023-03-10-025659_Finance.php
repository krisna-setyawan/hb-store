<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Finance extends Migration
{
    public function up()
    {
        //Kategori Akun
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'deskripsi'        => ['type' => 'varchar', 'constraint' => 255],
            'debit'            => ['type' => 'int', 'constraint' => 2, 'default' => 1],
            'kredit'           => ['type' => 'int', 'constraint' => 2, 'default' => 1],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('akun_kategori', true);


        //Akun
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode'             => ['type' => 'varchar', 'constraint' => 10],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'id_kategori'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_kategori', 'akun_kategori', 'id', '', 'CASCADE');
        $this->forge->createTable('akun', true);


        // Transaksi Jurnal
        $fields = [
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nomor_transaksi'   => ['type' => 'varchar', 'constraint' => 30],
            'referensi'         => ['type' => 'varchar', 'constraint' => 30],
            'tanggal'           => ['type' => 'date'],
            'total_transaksi'   => ['type' => 'int', 'constraint' => 11],
            'created_at'        => ['type' => 'datetime', 'null' => true],
            'updated_at'        => ['type' => 'datetime', 'null' => true],
            'deleted_at'        => ['type' => 'datetime', 'null' => true],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('transaksi_jurnal', true);


        //Transaksi Jurnal Detail
        $fields = [
            'id'                => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_transaksi'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'id_akun'           => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'deskripsi'         => ['type' => 'varchar', 'constraint' => 250],
            'debit'             => ['type' => 'int', 'constraint' => 20],
            'kredit'            => ['type' => 'int', 'constraint' => 20],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_transaksi', 'transaksi_jurnal', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_akun', 'akun', 'id', '', 'CASCADE');
        $this->forge->createTable('transaksi_jurnal_detail', true);
    }

    public function down()
    {
        $this->forge->dropTable('akun_kategori');
        $this->forge->dropTable('akun');
        $this->forge->dropTable('transaksi_jurnal');
        $this->forge->dropTable('transaksi_jurnal_detail');
    }
}
