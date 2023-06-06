<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggaran extends Migration
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
            'nama_pelanggaran' => [
                'type'           => 'VARCHAR',
                'constraint'     => 200,
                'null'           => true,
            ],
            'range_point' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pelanggaran');
    }

    public function down()
    {
        $this->forge->dropTable('pelanggaran');
    }
}
