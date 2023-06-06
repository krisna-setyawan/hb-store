<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Resource\GroupModel;
use App\Models\Resource\PermissionModel;

class GroupSeeder extends Seeder
{
    public function run()
    {
        // menambahkan data ke tabel group
        $groups = new GroupModel();
        $permissions = new PermissionModel();


        //1
        $groups->insert([
            'name' => 'Administrator',
            'description' => 'Administrator'
        ]);

        // menambahkan permision group ke dalam tabel groups_permissions
        // dengan cara loop semua module yang ada di permision karna 'super admin'
        // dapat mengakses semua module

        // proses ambil semua module atau permision
        $module_all = $permissions->findAll();
        foreach ($module_all as $mod_super) {
            // groups adalah model group buatan myth auth untuk menambahkan group kedalam permision
            // method addPermissionToGroup menerima 2 parameter bisa di cek di modelnya
            $groups->addPermissionToGroup($mod_super->id, $groups->getInsertID());
        }


        //2
        $groups->insert([
            'name' => 'Owner',
            'description' => 'Pemilik Perusahaan'
        ]);
        foreach ($module_all as $mod_super) {
            $groups->addPermissionToGroup($mod_super->id, $groups->getInsertID());
        }


        //3
        $groups->insert([
            'name' => 'Manajer',
            'description' => '-'
        ]);
        foreach ($module_all as $mod_super) {
            $groups->addPermissionToGroup($mod_super->id, $groups->getInsertID());
        }


        //4
        $groups->insert([
            'name' => 'SPV',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Laporan'";
        $module_spv = $permissions->where($where)->findAll();
        foreach ($module_spv as $mod_spv) {
            $groups->addPermissionToGroup($mod_spv->id, $groups->getInsertID());
        }


        //5
        $groups->insert([
            'name' => 'HR',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='SDM'";
        $module_hr = $permissions->where($where)->findAll();
        foreach ($module_hr as $mod_hr) {
            $groups->addPermissionToGroup($mod_hr->id, $groups->getInsertID());
        }


        //6 (1,3,4,7,8,10)
        $groups->insert([
            'name' => 'Team Finance',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Pembelian' OR name='Penjualan' OR name='Inventaris' OR name='Keuangan' OR name='Laporan'";
        $module_finance = $permissions->where($where)->findAll();
        foreach ($module_finance as $mod_finance) {
            $groups->addPermissionToGroup($mod_finance->id, $groups->getInsertID());
        }


        //7 (1,3,4,5,6,11)
        $groups->insert([
            'name' => 'Team Procurement',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Pembelian' OR name='Penjualan' OR name='Produksi' OR name='Gudang' OR name='Admin Supplier'";
        $module_procurement = $permissions->where($where)->findAll();
        foreach ($module_procurement as $mod_procurement) {
            $groups->addPermissionToGroup($mod_procurement->id, $groups->getInsertID());
        }


        //8 (1,3,4,5,6)
        $groups->insert([
            'name' => 'Team Analyst',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Pembelian' OR name='Penjualan' OR name='Produksi' OR name='Gudang'";
        $module_analyst = $permissions->where($where)->findAll();
        foreach ($module_analyst as $mod_analyst) {
            $groups->addPermissionToGroup($mod_analyst->id, $groups->getInsertID());
        }


        //9 (1,2,11,12)
        $groups->insert([
            'name' => 'Team Resource',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Data Master' OR name='Admin Supplier' OR name='Admin Customer'";
        $module_resource = $permissions->where($where)->findAll();
        foreach ($module_resource as $mod_resource) {
            $groups->addPermissionToGroup($mod_resource->id, $groups->getInsertID());
        }


        //10 (1,6,13)
        $groups->insert([
            'name' => 'Team Gudang',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Gudang' OR name='Penanggung Jawab Gudang'";
        $module_gudang = $permissions->where($where)->findAll();
        foreach ($module_gudang as $mod_gudang) {
            $groups->addPermissionToGroup($mod_gudang->id, $groups->getInsertID());
        }


        //11 (1,3,4,5,6)
        $groups->insert([
            'name' => 'Team Sales',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Pembelian' OR name='Penjualan' OR name='Produksi' OR name='Gudang'";
        $module_sales = $permissions->where($where)->findAll();
        foreach ($module_sales as $mod_sales) {
            $groups->addPermissionToGroup($mod_sales->id, $groups->getInsertID());
        }


        //12 (1,2,7)
        $groups->insert([
            'name' => 'Team IT Support',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Data Master' OR name='Inventaris'";
        $module_it = $permissions->where($where)->findAll();
        foreach ($module_it as $mod_it) {
            $groups->addPermissionToGroup($mod_it->id, $groups->getInsertID());
        }


        //13 (1,3,4,5,6)
        $groups->insert([
            'name' => 'Team Marketing',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Pembelian' OR name='Penjualan' OR name='Produksi' OR name='Gudang'";
        $module_marketing = $permissions->where($where)->findAll();
        foreach ($module_marketing as $mod_marketing) {
            $groups->addPermissionToGroup($mod_marketing->id, $groups->getInsertID());
        }


        //14 (1,3,4,5,6,12)
        $groups->insert([
            'name' => 'Team Sevice',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Pembelian' OR name='Penjualan' OR name='Produksi' OR name='Gudang' OR name='Admin Customer'";
        $module_service = $permissions->where($where)->findAll();
        foreach ($module_service as $mod_service) {
            $groups->addPermissionToGroup($mod_service->id, $groups->getInsertID());
        }


        //15 (1,5,6)
        $groups->insert([
            'name' => 'Team Creative',
            'description' => '-'
        ]);
        $where = "name='Dashboard' OR name='Produksi' OR name='Gudang'";
        $module_creative = $permissions->where($where)->findAll();
        foreach ($module_creative as $mod_creative) {
            $groups->addPermissionToGroup($mod_creative->id, $groups->getInsertID());
        }
    }
}
