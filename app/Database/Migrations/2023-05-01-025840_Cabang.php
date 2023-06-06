<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cabang extends Migration
{
    public function up()
    {
        // cabang
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_cabang'      => ['type' => 'varchar', 'constraint' => 80],
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
        $this->forge->addUniqueKey('kode_cabang');
        $this->forge->addUniqueKey('nama');
        $this->forge->createTable('cabang', true);
    }

    public function down()
    {
        $this->forge->dropTable('cabang');
    }
}
