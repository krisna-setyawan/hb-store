<?php

namespace App\Database\Seeds;

use App\Models\Resource\SupplierModel;
use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $db      = \Config\Database::connect();
        // $sup_pj = $db->table('supplier_penanggungjawab');

        $supplier = new SupplierModel();

        $supplier->save(
            [
                'origin' => 'SUP-1',
                'nama' => 'Suplier 1',
                'pemilik' => 'pemilik 1',
                'slug' => url_title('Suplier 1', '-', true),
                'alamat' => 'Alamat 1',
                'no_telp' => '08554651232',
                'saldo' => 0,
                'status' => 'Active',
                'note' => '-',
            ]
        );

        // $data_pj2 = [
        //     'id_supplier'       => $supplier->getInsertID(),
        //     'id_user'           => 2,
        //     'urutan'            => 1
        // ];
        // $sup_pj->insert($data_pj2);


        $supplier->save(
            [
                'origin' => 'SUP-2',
                'nama' => 'Suplier 2',
                'pemilik' => 'pemilik 2',
                'slug' => url_title('Suplier 2', '-', true),
                'alamat' => 'Alamat 2',
                'no_telp' => '08554651232',
                'saldo' => 0,
                'status' => 'Active',
                'note' => '-',
            ]
        );
        // $data_pj1 = [
        //     'id_supplier'       => $supplier->getInsertID(),
        //     'id_user'           => 2,
        //     'urutan'            => 1
        // ];
        // $sup_pj->insert($data_pj1);

        // $data_pj2 = [
        //     'id_supplier'       => $supplier->getInsertID(),
        //     'id_user'           => 3,
        //     'urutan'            => 2
        // ];
        // $sup_pj->insert($data_pj2);
    }
}
