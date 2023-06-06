<?php

namespace App\Database\Seeds;

use App\Models\Resource\GudangModel;
use App\Models\Resource\GudangPJModel;
use CodeIgniter\Database\Seeder;

class GudangSeeder extends Seeder
{
    public function run()
    {
        $gudang = new GudangModel();
        $gudangPj = new GudangPJModel();

        $gudang->insert([
            'nama' => 'Gudang Jakarta',
            'id_provinsi' => 31,
            'id_kota' => 3171,
            'id_kecamatan' => 3171050,
            'id_kelurahan' => 65475,
            'detail_alamat' => 'Detail Alamat',
            'no_telp' => '085123456789',
            'keterangan' => '-',
        ]);

        $gudangPj->insert([
            'id_gudang' => $gudang->getInsertID(),
            'id_user' => 3,
            'urutan' => 1
        ]);



        $gudang->insert([
            'nama' => 'Gudang Blitar',
            'id_provinsi' => 35,
            'id_kota' => 3572,
            'id_kecamatan' => 3572030,
            'id_kelurahan' => 43740,
            'detail_alamat' => 'Detail Alamat Gudang blitar',
            'no_telp' => '085456789123',
            'keterangan' => '-',
        ]);

        $gudangPj->insert([
            'id_gudang' => $gudang->getInsertID(),
            'id_user' => 4,
            'urutan' => 1
        ]);
    }
}
