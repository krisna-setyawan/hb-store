<?php

namespace App\Database\Seeds;

use App\Models\Resource\ProdukModel;
use App\Models\Resource\ProdukPlanModel;
use CodeIgniter\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $builder_produk_kategori = $db->table('produk_kategori');
        $builder_produk_kategori->insert(['id' => 0, 'nama' => '-']);
        $the_id_kategori = $db->insertID();


        $modelProduk = new ProdukModel();

        $modelProduk->save([                // 1
            'id_kategori'           => $the_id_kategori,
            'sku'                   => 'hbs-produk1',
            'hs_code'               => '',
            'nama'                  => 'HBS Produk 1 Kipas',
            'slug'                  => 'hbs-produk1',
            'satuan'                => 'Unit',
            'tipe'                  => 'SET',
            'jenis'                 => 'Produk Fisik',
            'hg_produk_penyusun'    => 0,
            'harga_beli'            => '1000000',
            'harga_jual'            => '1500000',
            'stok'                  => '3',
            'berat'                 => '5 kg',
            'panjang'               => '2 m',
            'lebar'                 => '1 m',
            'tinggi'                => '1.5 m',
            'minimal_penjualan'     => 0,
            'kelipatan_penjualan'   => 0,
            'status_marketing'      => 'Belum desain',
            'note'                  => ''
        ]);
        $modelProduk->save([                // 2
            'id_kategori'           => $the_id_kategori,
            'sku'                   => 'hbs-produk2',
            'hs_code'               => '',
            'nama'                  => 'HBS Produk 2 TV',
            'slug'                  => 'hbs-produk2',
            'satuan'                => 'Unit',
            'tipe'                  => 'SET',
            'jenis'                 => 'Produk Fisik',
            'hg_produk_penyusun'    => 0,
            'harga_beli'            => '5000000',
            'harga_jual'            => '7500000',
            'stok'                  => '5',
            'berat'                 => '5 kg',
            'panjang'               => '2 m',
            'lebar'                 => '1 m',
            'tinggi'                => '1.5 m',
            'minimal_penjualan'     => 0,
            'kelipatan_penjualan'   => 0,
            'status_marketing'      => 'Belum desain',
            'note'                  => ''
        ]);
        $modelProduk->save([                // 3
            'id_kategori'           => $the_id_kategori,
            'sku'                   => 'hbs-produk3',
            'hs_code'               => '',
            'nama'                  => 'HBS Produk 3 Kulkas',
            'slug'                  => 'hbs-produk3',
            'satuan'                => 'Pcs',
            'tipe'                  => 'SINGLE',
            'jenis'                 => 'Produk Fisik',
            'hg_produk_penyusun'    => 0,
            'harga_beli'            => '500000',
            'harga_jual'            => '600000',
            'stok'                  => '10',
            'berat'                 => '5 kg',
            'panjang'               => '2 m',
            'lebar'                 => '1 m',
            'tinggi'                => '1.5 m',
            'minimal_penjualan'     => 0,
            'kelipatan_penjualan'   => 0,
            'status_marketing'      => 'Belum desain',
            'note'                  => ''
        ]);
        $modelProduk->save([                // 4
            'id_kategori'           => $the_id_kategori,
            'sku'                   => 'hbs-produk4',
            'hs_code'               => '',
            'nama'                  => 'HBS Produk 4 AC',
            'slug'                  => 'hbs-produk4',
            'satuan'                => 'Pcs',
            'tipe'                  => 'SINGLE',
            'jenis'                 => 'Produk Fisik',
            'hg_produk_penyusun'    => 0,
            'harga_beli'            => '350000',
            'harga_jual'            => '400000',
            'stok'                  => '2',
            'berat'                 => '5 kg',
            'panjang'               => '2 m',
            'lebar'                 => '1 m',
            'tinggi'                => '1.5 m',
            'minimal_penjualan'     => 0,
            'kelipatan_penjualan'   => 0,
            'status_marketing'      => 'Belum desain',
            'note'                  => ''
        ]);
        $modelProduk->save([                // 5
            'id_kategori'           => $the_id_kategori,
            'sku'                   => 'hbs-produk5',
            'hs_code'               => '',
            'nama'                  => 'HBS Produk 5 Mesin Cuci',
            'slug'                  => 'hbs-produk5',
            'satuan'                => 'Pcs',
            'tipe'                  => 'SINGLE',
            'jenis'                 => 'Produk Fisik',
            'hg_produk_penyusun'    => 0,
            'harga_beli'            => '15000',
            'harga_jual'            => '20000',
            'stok'                  => '4',
            'berat'                 => '5 kg',
            'panjang'               => '2 m',
            'lebar'                 => '1 m',
            'tinggi'                => '1.5 m',
            'minimal_penjualan'     => 0,
            'kelipatan_penjualan'   => 0,
            'status_marketing'      => 'Belum desain',
            'note'                  => ''
        ]);
        $modelProduk->save([                // 6
            'id_kategori'           => $the_id_kategori,
            'sku'                   => 'hbs-produk6',
            'hs_code'               => '',
            'nama'                  => 'HBS Produk 6 Kompor',
            'slug'                  => 'hbs-produk6',
            'satuan'                => 'Pcs',
            'tipe'                  => 'SINGLE',
            'jenis'                 => 'Produk Fisik',
            'hg_produk_penyusun'    => 0,
            'harga_beli'            => '1350000',
            'harga_jual'            => '200000',
            'stok'                  => '1',
            'berat'                 => '5 kg',
            'panjang'               => '2 m',
            'lebar'                 => '1 m',
            'tinggi'                => '1.5 m',
            'minimal_penjualan'     => 0,
            'kelipatan_penjualan'   => 0,
            'status_marketing'      => 'Belum desain',
            'note'                  => ''
        ]);
        $modelProduk->save([                // 7
            'id_kategori'           => $the_id_kategori,
            'sku'                   => 'hbs-produk7',
            'hs_code'               => '',
            'nama'                  => 'HBS Produk 7 Blender',
            'slug'                  => 'hbs-produk7',
            'satuan'                => 'Pcs',
            'tipe'                  => 'SINGLE',
            'jenis'                 => 'Produk Fisik',
            'hg_produk_penyusun'    => 0,
            'harga_beli'            => '200000',
            'harga_jual'            => '250000',
            'stok'                  => '6',
            'berat'                 => '5 kg',
            'panjang'               => '2 m',
            'lebar'                 => '1 m',
            'tinggi'                => '1.5 m',
            'minimal_penjualan'     => 0,
            'kelipatan_penjualan'   => 0,
            'status_marketing'      => 'Belum desain',
            'note'                  => ''
        ]);
        $modelProduk->save([                // 8
            'id_kategori'           => $the_id_kategori,
            'sku'                   => 'hbs-produk8',
            'hs_code'               => '',
            'nama'                  => 'HBS Produk 8 Vacum Cleaner',
            'slug'                  => 'hbs-produk8',
            'satuan'                => 'Dus',
            'tipe'                  => 'SINGLE',
            'jenis'                 => 'Produk Fisik',
            'hg_produk_penyusun'    => 0,
            'harga_beli'            => '50000',
            'harga_jual'            => '75000',
            'stok'                  => '6',
            'berat'                 => '5 kg',
            'panjang'               => '2 m',
            'lebar'                 => '1 m',
            'tinggi'                => '1.5 m',
            'minimal_penjualan'     => 0,
            'kelipatan_penjualan'   => 0,
            'status_marketing'      => 'Belum desain',
            'note'                  => ''
        ]);
        $modelProduk->save([                // 9
            'id_kategori'           => $the_id_kategori,
            'sku'                   => 'hbs-produk9',
            'hs_code'               => '',
            'nama'                  => 'HBS Produk 9 Sofa',
            'slug'                  => 'hbs-produk9',
            'satuan'                => 'Pcs',
            'tipe'                  => 'ECER',
            'jenis'                 => 'Produk Fisik',
            'hg_produk_penyusun'    => 0,
            'harga_beli'            => '2000',
            'harga_jual'            => '3000',
            'stok'                  => '6',
            'berat'                 => '5 kg',
            'panjang'               => '2 m',
            'lebar'                 => '1 m',
            'tinggi'                => '1.5 m',
            'minimal_penjualan'     => 0,
            'kelipatan_penjualan'   => 0,
            'status_marketing'      => 'Belum desain',
            'note'                  => ''
        ]);
        //     $modelProduk->save([                // 10
        //         'id_kategori'           => $the_id_kategori,
        //         'sku'                   => 'hbs-produk10',
        //         'hs_code'               => '',
        //         'nama'                  => 'HBS Produk 10 Besi Single',
        //         'slug'                  => 'hbs-produk10',
        //         'satuan'                => 'Pcs',
        //         'tipe'                  => 'SINGLE',
        //         'jenis'                 => 'Produk Fisik',
        //         'hg_produk_penyusun'    => 0,
        //         'harga_beli'            => '40000',
        //         'harga_jual'            => '70000',
        //         'stok'                  => '2',
        //         'berat'                 => '5 kg',
        //         'panjang'               => '2 m',
        //         'lebar'                 => '1 m',
        //         'tinggi'                => '1.5 m',
        //         'minimal_penjualan'     => 0,
        //         'kelipatan_penjualan'   => 0,
        //         'status_marketing'      => 'Belum desain',
        //         'note'                  => ''
        //     ]);
        //     $modelProduk->save([                // 11
        //         'id_kategori'           => $the_id_kategori,
        //         'sku'                   => 'hbs-produk11',
        //         'hs_code'               => '',
        //         'nama'                  => 'HBS Produk 11 Eceran Besi',
        //         'slug'                  => 'hbs-produk11',
        //         'satuan'                => 'Pcs',
        //         'tipe'                  => 'ECER',
        //         'jenis'                 => 'Produk Fisik',
        //         'hg_produk_penyusun'    => 0,
        //         'harga_beli'            => '10000',
        //         'harga_jual'            => '15000',
        //         'stok'                  => '3',
        //         'berat'                 => '5 kg',
        //         'panjang'               => '2 m',
        //         'lebar'                 => '1 m',
        //         'tinggi'                => '1.5 m',
        //         'minimal_penjualan'     => 0,
        //         'kelipatan_penjualan'   => 0,
        //         'status_marketing'      => 'Belum desain',
        //         'note'                  => ''
        //     ]);
        //     $modelProduk->save([                // 12
        //         'id_kategori'           => $the_id_kategori,
        //         'sku'                   => 'hbs-produk12',
        //         'hs_code'               => '',
        //         'nama'                  => 'HBS Produk 12 Besi Single Panjang',
        //         'slug'                  => 'hbs-produk12',
        //         'satuan'                => 'Pcs',
        //         'tipe'                  => 'SINGLE',
        //         'jenis'                 => 'Produk Fisik',
        //         'hg_produk_penyusun'    => 0,
        //         'harga_beli'            => '100000',
        //         'harga_jual'            => '150000',
        //         'stok'                  => '2',
        //         'berat'                 => '5 kg',
        //         'panjang'               => '2 m',
        //         'lebar'                 => '1 m',
        //         'tinggi'                => '1.5 m',
        //         'minimal_penjualan'     => 0,
        //         'kelipatan_penjualan'   => 0,
        //         'status_marketing'      => 'Belum desain',
        //         'note'                  => ''
        //     ]);



        //     // PLAN
        //     $modelProdukPlan = new ProdukPlanModel();

        //     // Komputer
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 1,  // komputer
        //         'id_produk_bahan'   => 4,  // ssd
        //         'qty_bahan'         => 1,
        //     ]);
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 1,  // komputer
        //         'id_produk_bahan'   => 5,  // prosesor
        //         'qty_bahan'         => 1,
        //     ]);
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 1,  // komputer
        //         'id_produk_bahan'   => 7,  // ram
        //         'qty_bahan'         => 2,
        //     ]);
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 1,  // komputer
        //         'id_produk_bahan'   => 8,  // baut set
        //         'qty_bahan'         => 1,
        //     ]);



        //     // Motor
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 2,  // motor
        //         'id_produk_bahan'   => 3,  // roda
        //         'qty_bahan'         => 2,
        //     ]);
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 2,  // motor
        //         'id_produk_bahan'   => 6,  // rangka
        //         'qty_bahan'         => 1,
        //     ]);
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 2,  // motor
        //         'id_produk_bahan'   => 8,  // baut set
        //         'qty_bahan'         => 1,
        //     ]);
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 2,  // motor
        //         'id_produk_bahan'   => 10,  // besi single
        //         'qty_bahan'         => 2,
        //     ]);




        //     // Besi single
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 10,  // besi single
        //         'id_produk_bahan'   => 11,  // besi ecer
        //         'qty_bahan'         => 3,
        //     ]);

        //     // Besi single panjang
        //     $modelProdukPlan->save([
        //         'id_produk_jadi'    => 12,  // besi single
        //         'id_produk_bahan'   => 11,  // besi ecer
        //         'qty_bahan'         => 5,
        //     ]);
    }
}
