<?php

namespace App\Database\Seeds;

use App\Models\Resource\DivisiModel;
use CodeIgniter\Database\Seeder;

class DivisiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Finance',
            'Procurement',
            'Analyst',
            'Resource',
            'Gudang',
            'Sales',
            'IT Support',
            'HR'
        ];

        $divisi = new DivisiModel();

        foreach ($data as $key => $value) {
            $divisi->save(['nama' => $value, 'deskripsi' => '-']);
        }
    }
}
