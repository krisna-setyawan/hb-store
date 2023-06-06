<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KaryawanAbsen extends Migration
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
            'status' => [
                'type'           => 'ENUM',
                'constraint'     => "'MASUK','ALFA','SAKIT','IZIN','LIBUR','WFA'",
            ],
            'tanggal_absen' => [
                'type'           => 'DATE',
            ],
            'total_menit' => [
                'type'           => 'INT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('karyawan_absen');
    }

    public function down()
    {
        $this->forge->dropTable('karyawan_absen');
    }
}
