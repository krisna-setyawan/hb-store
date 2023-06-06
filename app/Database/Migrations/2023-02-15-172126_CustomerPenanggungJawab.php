<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CustomerPenanggungJawab extends Migration
{
    public function up()
    {
        // customer penanggung jawab
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_customer'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'id_user'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'urutan'           => ['type' => 'int', 'constraint' => 11, 'default' => 0],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_customer', 'customer', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('customer_penanggungjawab', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_penanggungjawab');
    }
}
