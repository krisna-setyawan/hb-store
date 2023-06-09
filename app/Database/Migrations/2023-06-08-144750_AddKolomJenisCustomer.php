<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKolomJenisCustomer extends Migration
{
    public function up()
    {
        $this->forge->addColumn('customer', [
            'jenis_customer' => [
                'type' => 'ENUM',
                'constraint' => ['Non-Haebot', 'Haebot'],
                'default' => 'Non-Haebot',
                'after' => 'nama',
            ],
            'id_perusahaan' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'after' => 'jenis_customer',
                'null' => true
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('customer', 'jenis_customer');
        $this->forge->dropColumn('customer', 'id_perusahaan');
    }
}
