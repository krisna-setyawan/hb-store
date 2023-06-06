<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PelanggaranPoint extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_karyawan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_pelanggaran' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'point' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_pelanggaran', 'pelanggaran', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('point_pelanggaran');
    }

    public function down()
    {
        $this->forge->dropTable('point_pelanggaran');
    }
}
