<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jasa extends Migration
{
    public function up()
    {
        // kategori jasa
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'             => ['type' => 'varchar', 'constraint' => 255],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->createTable('jasa_kategori', true);


        // Jasa
        $fields = [
            'id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_kategori'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'nama'             => ['type' => 'varchar', 'constraint' => 80],
            'slug'             => ['type' => 'varchar', 'constraint' => 255],
            'biaya'            => ['type' => 'int', 'unsigned' => true],
            'deskripsi'        => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nama');
        $this->forge->addForeignKey('id_kategori', 'jasa_kategori', 'id', '', 'CASCADE');
        $this->forge->createTable('jasa', true);
    }

    public function down()
    {
        $this->forge->dropTable('jasa_kategori');
        $this->forge->dropTable('jasa');
    }
}
