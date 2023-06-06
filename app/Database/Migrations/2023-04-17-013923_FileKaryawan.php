<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FileKaryawan extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'tgl_upload' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'nama_file' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'created_at'    => [
                'type'      => 'datetime',
                'null'      => true
            ],
            'updated_at'    => [
                'type'      => 'datetime',
                'null'      => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_karyawan', 'karyawan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('file_karyawan');
    }

    public function down()
    {
        $this->forge->dropTable('file_karyawan');
    }
}
