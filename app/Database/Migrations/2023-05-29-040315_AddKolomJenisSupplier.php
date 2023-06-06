<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKolomJenisSupplier extends Migration
{
    public function up()
    {
        $this->forge->addColumn('supplier', [
            'jenis_supplier' => [
                'type' => 'ENUM',
                'constraint' => ['Non-Haebot', 'Haebot'],
                'default' => 'Non-Haebot',
                'after' => 'nama',
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
        $this->forge->dropColumn('supplier', 'jenis_supplier');
        $this->forge->dropColumn('supplier', 'id_perusahaan');
    }
}
