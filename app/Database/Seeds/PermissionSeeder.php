<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Dashboard',
            'Data Master',
            'Pembelian',
            'Penjualan',
            'Produksi',
            'Gudang',
            'Inventaris',
            'Keuangan',
            'SDM',
            'Laporan',
            'Admin Supplier',
            'Admin Customer',
            'Penanggung Jawab Gudang'
        ];

        foreach ($data as $key => $value) {
            $this->db->table('auth_permissions')->insert(['name' => $value]);
        }
    }
}
