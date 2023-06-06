<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('DivisiSeeder');
        $this->call('PermissionSeeder');
        $this->call('GroupSeeder');
        $this->call('UserSeeder');
        $this->call('SupplierSeeder');
        $this->call('CustomerSeeder');
        $this->call('ProdukSeeder');
        $this->call('GudangSeeder');
        $this->call('AkunSeeder');
        $this->call('PelanggaranSeeder');
    }
}
