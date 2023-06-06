<?php

namespace App\Database\Seeds;

use App\Models\Resource\CustomerAlamatModel;
use App\Models\Resource\CustomerModel;
use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $customer = new CustomerModel();
        $alamat_customer = new CustomerAlamatModel();

        $customer->save(
            [
                'id_customer' => 'CUS-1',
                'nama' => 'Customer1',
                'slug' => url_title('customer1', '-', true),
                'no_telp' => '08554651232',
                'email' => 'cus1@gmail.com',
                'status' => 'Active',
                'saldo_utama' => 0,
                'saldo_belanja' => 0,
                'saldo_lain' => 0,
                'tgl_registrasi' => '2023-04-23',
                'note' => '-',
            ]
        );

        $alamat_customer->insert([
            'id_customer' => $customer->getInsertID(),
            'nama' => 'alamat1 cus1',
            'id_provinsi' => 32,
            'id_kota' => 3201,
            'id_kecamatan' => 3201210,
            'id_kelurahan' => 21844,
            'detail_alamat' => 'detail alamat1 cus1',
            'penerima' => 'penerima alamat1',
            'no_telp' => '085123123123',
        ]);
        $alamat_customer->insert([
            'id_customer' => $customer->getInsertID(),
            'nama' => 'alamat2 cus1',
            'id_provinsi' => 51,
            'id_kota' => 5104,
            'id_kecamatan' => 5104070,
            'id_kelurahan' => 45700,
            'detail_alamat' => 'detail alamat2 cus1',
            'penerima' => 'penerima alamat2',
            'no_telp' => '085789789798',
        ]);
    }
}
