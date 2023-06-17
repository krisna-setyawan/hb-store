<?php

namespace App\Controllers\Purchase;

use App\Models\Purchase\GudangModel;
use App\Models\Purchase\PemesananFixingDetailModel;
use App\Models\Purchase\PemesananFixingModel;
use App\Models\Purchase\PemesananModel;
use App\Models\Purchase\ProdukModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Pemesanan_detail_fixing extends ResourcePresenter
{
    protected $helpers = ['user_admin_helper', 'nomor_auto_helper'];


    public function detailFixing($no_pemesanan)
    {
        $modelProduk = new ProdukModel();
        $produk = $modelProduk->findAll();
        $modelGudang = new GudangModel();
        $gudang = $modelGudang->findAll();
        $pemesananModel = new PemesananModel();
        $pemesananFixingModel = new PemesananFixingModel();
        $pemesanan = $pemesananModel->getPemesanan($no_pemesanan);

        $data = [
            'pemesananFixing'       => $pemesananFixingModel->getPemesananFixingByIdPemesanan($pemesanan['id']),
            'pemesanan'             => $pemesanan,
            'produk'                => $produk,
            'gudang'                => $gudang,
        ];
        return view('purchase/pemesanan_fixing/detail', $data);
    }


    public function getListProdukPemesananFixing()
    {
        if ($this->request->isAJAX()) {

            $pemesananFixingModel = new PemesananFixingModel();
            $modelPemesananFixing = new PemesananFixingDetailModel();

            $id_pemesanan_fixing = $this->request->getVar('id_pemesanan_fixing');
            $pemesananFixingModel = $pemesananFixingModel->find($id_pemesanan_fixing);
            $list_produk_fixing = $modelPemesananFixing->getListProdukPemesananFixing($id_pemesanan_fixing);

            if ($list_produk_fixing) {
                $data = [
                    'list_produk_fixing'    => $list_produk_fixing,
                    'pemesananFixing'       => $pemesananFixingModel
                ];

                $json = [
                    'list' => view('purchase/pemesanan_fixing/list_produk', $data),
                ];
            } else {
                $json = [
                    'list' => '<tr><td colspan="7" class="text-center">Belum ada list Produk.</td></tr>',
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function create()
    {
        $id_produk = $this->request->getPost('id_produk');
        $id_pemesanan_fixing = $this->request->getPost('id_pemesanan_fixing');

        $modelProduk = new ProdukModel();
        $produk = $modelProduk->find($id_produk);

        $modelPemesananFixingDetail = new PemesananFixingDetailModel();
        $cek_produk = $modelPemesananFixingDetail->where(['id_produk' => $id_produk, 'id_pemesanan_fixing' => $id_pemesanan_fixing])->first();

        if ($cek_produk) {
            $data_update = [
                'id'                    => $cek_produk['id'],
                'id_pemesanan_fixing'   => $id_pemesanan_fixing,
                'id_produk'             => $this->request->getPost('id_produk'),
                'sku'                   => $cek_produk['sku'],
                'qty'                   => $cek_produk['qty'] + $this->request->getPost('qty'),
                'harga_satuan'          => $cek_produk['harga_satuan'],
                'total_harga'           => $cek_produk['total_harga'] + ($cek_produk['harga_satuan'] * $this->request->getPost('qty')),
            ];
            $modelPemesananFixingDetail->save($data_update);
        } else {
            $data = [
                'id_pemesanan_fixing'   => $id_pemesanan_fixing,
                'id_produk'             => $this->request->getPost('id_produk'),
                'sku'                   => $produk['sku'],
                'qty'                   => $this->request->getPost('qty'),
                'harga_satuan'          => $produk['harga_beli'],
                'total_harga'           => ($produk['harga_beli'] * $this->request->getPost('qty')),
            ];
            $modelPemesananFixingDetail->save($data);
        }

        $modelPemesananFixing = new PemesananFixingModel();
        $sum = $modelPemesananFixingDetail->sumTotalHargaProduk($id_pemesanan_fixing);

        $data_update = [
            'id'                    => $id_pemesanan_fixing,
            'grand_total'           => $sum['total_harga'],
            'exw'                   => $sum['total_harga'],
        ];
        $modelPemesananFixing->save($data_update);

        $json = [
            'notif' => 'Berhasil menambah list produk pembelian',
            'exw'   => $sum['total_harga'],
        ];

        echo json_encode($json);
    }


    public function update($id = null)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $modelPemesananFixingDetail = new PemesananFixingDetailModel();
        $harga_satuan = str_replace(".", "", $data['new_harga_satuan']);
        $data_update_produk = [
            'id'                    => $id,
            'qty'                   => $data['new_qty'],
            'harga_satuan'          => $harga_satuan,
            'total_harga'           => $harga_satuan * $data['new_qty'],
        ];
        $modelPemesananFixingDetail->save($data_update_produk);

        $modelPemesananFixing = new PemesananFixingModel();
        $sum = $modelPemesananFixingDetail->sumTotalHargaProduk($data['id_pemesanan_fixing']);
        $data_update_pembelian = [
            'id'                    => $data['id_pemesanan_fixing'],
            'grand_total'           => $sum['total_harga'],
            'exw'                   => $sum['total_harga'],
        ];
        $modelPemesananFixing->save($data_update_pembelian);

        $json = [
            'notif' => 'Berhasil update list produk pembelian',
            'exw'   => $sum['total_harga'],
        ];

        echo json_encode($json);
    }


    public function delete($id = null)
    {
        $id_pemesanan_fixing = $this->request->getPost('id_pemesanan_fixing');
        $modelPemesananFixing = new PemesananFixingModel();
        $no_pemesanan = $modelPemesananFixing->find($id_pemesanan_fixing)['no_pemesanan'];

        $modelPemesananFixingDetail = new PemesananFixingDetailModel();
        $modelPemesananFixingDetail->delete($id);

        $sum = $modelPemesananFixingDetail->sumTotalHargaProduk($id_pemesanan_fixing);

        $data_update = [
            'id'                    => $id_pemesanan_fixing,
            'grand_total'           => $sum['total_harga'],
            'exw'                   => $sum['total_harga'],
        ];
        $modelPemesananFixing->save($data_update);

        session()->setFlashdata('pesan', 'List Produk berhasil dihapus.');
        return redirect()->to('/purchase-list_fixing/' . $no_pemesanan);
    }
}
