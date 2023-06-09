<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HaebotOrder extends Migration
{
    public function up()
    {
        // Haebot Order
        $fields = [
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pemesanan'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'no_pemesanan'          => ['type' => 'varchar', 'constraint' => 30],
            'id_perusahaan'         => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'nama_perusahaan'       => ['type' => 'varchar', 'constraint' => 80],
            'tanggal'               => ['type' => 'date'],
            'status'                => ['type' => 'enum', 'constraint' => ['Waiting', 'Terima', 'Tolak'], 'default' => 'Waiting'],
            'grand_total'           => ['type' => 'int', 'constraint' => 11],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
            'deleted_at'            => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('penjualan_order', true);
    }

    public function down()
    {
        $this->forge->dropTable('penjualan_order');
    }
}
