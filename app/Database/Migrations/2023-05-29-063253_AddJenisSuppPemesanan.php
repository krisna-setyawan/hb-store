<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJenisSuppPemesanan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pemesanan', [
            'jenis_supplier' => [
                'type' => 'ENUM',
                'constraint' => ['Non-Haebot', 'Haebot'],
                'default' => 'Non-Haebot',
                'after' => 'id_supplier',
            ],
            'id_perusahaan' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'after' => 'jenis_supplier',
                'null' => true
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pemesanan', 'jenis_supplier');
        $this->forge->dropColumn('pemesanan', 'id_perusahaan');
    }
}
