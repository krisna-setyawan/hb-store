<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CalonKaryawan extends Migration
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
            'nik' => [
                'type'       => 'INT',
                'constraint' => 10,
                'null'      => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null'      => true,
            ],
            'alamat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'      => true,
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM("LAKI-LAKI","PEREMPUAN")',
                'null'      => true,
            ],
            'tempat_lahir' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'      => true,
            ],
            'tanggal_lahir' => [
                'type'       => 'DATE',
                'null'      => true,
            ],
            'agama' => [
                'type' => 'ENUM("ISLAM","KATOLIK","KRISTEN","HINDU","BUDHA","KHONGHUCU")',
                'null'      => true,
            ],
            'pendidikan' => [
                'type' => 'ENUM("SD","SMP","SMA/SMK","D I","D II","D III","D IV/S I")',
                'null'      => true,
            ],
            'no_telp' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'      => true,
            ],
            'created_at'    => [
                'type'      => 'datetime',
                'null'      => true
            ],
            'updated_at'    => [
                'type'      => 'datetime',
                'null'      => true,
            ],
            'deleted_at'    => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('calon_karyawan');
    }

    public function down()
    {
        $this->forge->dropTable('calon_karyawan');
    }
}
