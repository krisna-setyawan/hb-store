<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StockOpname extends Migration
{
    public function up()
    {
        // stock opname
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_gudang'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_pj'                 => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'nomor'                 => ['type' => 'varchar', 'constraint' => 30],
            'tanggal'               => ['type' => 'date',],
            'status'                => ['type' => 'enum', 'constraint' => ['Proses', 'Selesai'], 'default' => 'Proses'],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nomor');
        $this->forge->addForeignKey('id_gudang', 'gudang', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_pj', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('stock_opname', true);


        // list produk stock opname
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_stock_opname'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_produk'             => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'jumlah_fisik'          => ['type' => 'int', 'constraint' => 11],
            'jumlah_virtual'        => ['type' => 'int', 'constraint' => 11],
            'selisih'               => ['type' => 'int', 'constraint' => 11],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_stock_opname', 'stock_opname', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_produk', 'produk', 'id', '', 'CASCADE');
        $this->forge->createTable('stock_opname_list_produk', true);
    }

    public function down()
    {
        $this->forge->dropTable('stock_opname');
        $this->forge->dropTable('stock_opname_list_produk');
    }
}
