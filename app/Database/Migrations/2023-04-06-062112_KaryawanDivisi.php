<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KaryawanDivisi extends Migration
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
            'id_divisi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_divisi', 'divisi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('karyawan_divisi');
    }

    public function down()
    {
        $this->forge->dropTable('karyawan_divisi');
    }
}
