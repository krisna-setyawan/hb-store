<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Resource\AkunModel;
use App\Models\Resource\KategoriAkunModel;

class AkunSeeder extends Seeder
{
    public function run()
    {
        $akun     = new AkunModel();
        $kategori = new KategoriAkunModel();

        //Kategori Akun
        $kategori->insert([    //1
            'nama'             => 'Kas & Bank',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //2
            'nama'             => 'Piutang',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //3
            'nama'             => 'Persediaan',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //4
            'nama'             => 'Aktiva Lancar Lainnya',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //5
            'nama'             => 'Aktiva Tetap',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //6
            'nama'             => 'Depresiasi dan Amortisasi',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //7
            'nama'             => 'Aktiva Lainnya',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //8
            'nama'             => 'Akun Hutang',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //9
            'nama'             => 'Kewajiban Lancar Lainnya',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //10
            'nama'             => 'Kewajiban Jangka Panjang',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //11
            'nama'             => 'Ekuitas',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //12
            'nama'             => 'Pendapatan',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //13
            'nama'             => 'Harga Pokok Penjualan',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //14
            'nama'             => 'Beban',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);

        $kategori->insert([    //15
            'nama'             => 'Pendapatan Lainnya',
            'deskripsi'        => '-',
            'debit'            => '-1',
            'kredit'           => '1',
        ]);

        $kategori->insert([    //16
            'nama'             => 'Beban Lainnya',
            'deskripsi'        => '-',
            'debit'            => '1',
            'kredit'           => '-1',
        ]);


        //Akun
        $akun->insert([
            'kode'         => '11',
            'nama'         => 'Kas',
            'id_kategori'  => '1',
        ]);

        $akun->insert([
            'kode'         => '12',
            'nama'         => 'Rekening Bank',
            'id_kategori'  => '1',
        ]);

        $akun->insert([
            'kode'         => '13',
            'nama'         => 'Piutang Dagang',
            'id_kategori'  => '2',
        ]);

        $akun->insert([
            'kode'         => '14',
            'nama'         => 'Inventory',
            'id_kategori'  => '3',
        ]);

        $akun->insert([
            'kode'         => '142',
            'nama'         => 'Inventory in Shipping',
            'id_kategori'  => '3',
        ]);

        $akun->insert([
            'kode'         => '18',
            'nama'         => 'PPN Masukan',
            'id_kategori'  => '4',
        ]);

        $akun->insert([
            'kode'         => '21',
            'nama'         => 'Hutang Dagang',
            'id_kategori'  => '8',
        ]);

        $akun->insert([
            'kode'         => '22',
            'nama'         => 'Hutang Pinjaman',
            'id_kategori'  => '10',
        ]);

        $akun->insert([
            'kode'         => '31',
            'nama'         => 'Modal Ekutias Awal',
            'id_kategori'  => '11',
        ]);

        $akun->insert([
            'kode'         => '32',
            'nama'         => 'Laba Ditahan',
            'id_kategori'  => '11',
        ]);

        $akun->insert([
            'kode'         => '41',
            'nama'         => 'Penjualan Online',
            'id_kategori'  => '12',
        ]);

        $akun->insert([
            'kode'         => '42',
            'nama'         => 'Penjualan Offline',
            'id_kategori'  => '12',
        ]);

        $akun->insert([
            'kode'         => '43',
            'nama'         => 'Return Penjualan',
            'id_kategori'  => '12',
        ]);

        $akun->insert([
            'kode'         => '51',
            'nama'         => 'Beban Pokok Pendapatan',
            'id_kategori'  => '13',
        ]);

        $akun->insert([
            'kode'         => '52',
            'nama'         => 'Beban Pengangkutan dan Pengiriman',
            'id_kategori'  => '13',
        ]);

        $akun->insert([
            'kode'         => '53',
            'nama'         => 'Return Pembelian',
            'id_kategori'  => '13',
        ]);

        $akun->insert([
            'kode'         => '61',
            'nama'         => 'Biaya Gaji dan Upah',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '62',
            'nama'         => 'Biaya Konsumsi',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '63',
            'nama'         => 'Biaya Komplain dan Keluhan',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '64',
            'nama'         => 'Biaya Sales Pengiriman',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '65',
            'nama'         => 'Biaya Iklan dan Promosi',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '66',
            'nama'         => 'Biaya Pengadaan Kebutuhan dan Alat',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '67',
            'nama'         => 'Biaya Manajemen : Consolidasi',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '68',
            'nama'         => 'Biaya Sewa Operasional',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '69',
            'nama'         => 'Biaya Utilitas',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '610',
            'nama'         => 'Biaya Pajak impor',
            'id_kategori'  => '14',
        ]);

        $akun->insert([
            'kode'         => '611',
            'nama'         => 'Biaya Importir Forwarder',
            'id_kategori'  => '14',
        ]);
    }
}
