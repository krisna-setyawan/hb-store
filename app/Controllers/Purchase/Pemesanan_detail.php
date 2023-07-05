<?php

namespace App\Controllers\Purchase;

use App\Models\Purchase\GudangModel;
use App\Models\Purchase\PemesananDetailModel;
use App\Models\Purchase\PemesananModel;
use App\Models\Purchase\ProdukModel;
use App\Models\Purchase\SupplierModel;
use App\Models\Purchase\UserModel;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\Config\Services;

class Pemesanan_detail extends ResourcePresenter
{
    protected $helpers = ['user_admin_helper', 'nomor_auto_helper'];


    public function List_pemesanan($no_pemesanan)
    {
        $pemesananModel = new PemesananModel();
        $pemesanan = $pemesananModel->getPemesanan($no_pemesanan);

        $modelProduk = new ProdukModel();
        $produk = $modelProduk->findAll();

        $modelSupplier = new SupplierModel();
        $supplier = $modelSupplier->findAll();

        $modelUser = new UserModel();
        $user = $modelUser->getAllUserWithKaryawanName();

        $modelGudang = new GudangModel();
        $gudang = $modelGudang->findAll();

        $data = [
            'pemesanan'             => $pemesanan,
            'supplier'              => $supplier,
            'produk'                => $produk,
            'user'                  => $user,
            'gudang'                => $gudang,
        ];
        return view('purchase/pemesanan/detail', $data);
    }


    public function getProdukForAddList($id_pemesanan)
    {
        if ($this->request->isAJAX()) {

            $pemesananModel = new PemesananModel();
            $pemesanan = $pemesananModel->find($id_pemesanan);

            $modelProduk = new ProdukModel();
            $produkSupplier = $modelProduk->getProdukFormPembelianDetailSupplier($pemesanan['id_supplier']);

            $data = [
                'produk_supplier' => $produkSupplier
            ];

            $json = [
                'data' => view('purchase/pemesanan/produk_supplier', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function findProdukByNamaSKU()
    {
        if ($this->request->isAJAX()) {
            $modelProduk = new ProdukModel();
            $nama_sku = $this->request->getPost('input_produk_lain');
            $produk = $modelProduk->findProdukByNamaSKU($nama_sku);

            $data = [
                'produk' => $produk
            ];

            $json = [
                'data' => view('purchase/pemesanan/find_produk', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function getListProdukPemesanan()
    {
        if ($this->request->isAJAX()) {

            $id_pemesanan = $this->request->getVar('id_pemesanan');

            $modelPemesananDetail = new PemesananDetailModel();
            $produk_pemesanan = $modelPemesananDetail->getListProdukPemesanan($id_pemesanan);

            if ($produk_pemesanan) {
                $data = [
                    'produk_pemesanan'      => $produk_pemesanan,
                ];

                $json = [
                    'list' => view('purchase/pemesanan/list_produk', $data),
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


    public function validateProdukApi()
    {
        $client = Services::curlrequest();

        $id_perusahaan = $this->request->getVar('id_perusahaan');
        $sku = $this->request->getVar('sku');

        // Get data perusahaan
        $perusahaan = get_data_perushaan($id_perusahaan);

        $url_validate = $perusahaan['url'] . 'hbapi-validate-exist-produk/' . $sku;

        $response_validate_sku = $client->request('GET', $url_validate);
        $status = $response_validate_sku->getStatusCode();
        $responseJson = $response_validate_sku->getBody();
        $responseArray = json_decode($responseJson, true);

        if ($responseArray['result'] == 'exist') {
            $json = [
                'status' => 'ok',
            ];
        } else {
            $json = [
                'status' => 'not ok',
                'message' => $perusahaan['nama'] . ' tidak memiliki produk dengan SKU ' . $sku
            ];
        }

        echo json_encode($json);
    }


    public function create()
    {
        $id_produk = $this->request->getPost('id_produk');
        $id_pemesanan = $this->request->getPost('id_pemesanan');

        $modelProduk = new ProdukModel();
        $produk = $modelProduk->find($id_produk);

        $modelPemesananDetail = new PemesananDetailModel();
        $cek_produk = $modelPemesananDetail->where(['id_produk' => $id_produk, 'id_pemesanan' => $id_pemesanan])->first();

        if ($cek_produk) {
            $data_update = [
                'id'                    => $cek_produk['id'],
                'id_pemesanan'          => $id_pemesanan,
                'id_produk'             => $this->request->getPost('id_produk'),
                'sku'                   => $produk['sku'],
                'qty'                   => $cek_produk['qty'] + $this->request->getPost('qty'),
                'harga_satuan'          => $produk['harga_beli'],
                'total_harga'           => $cek_produk['total_harga'] + ($produk['harga_beli'] * $this->request->getPost('qty')),
            ];
            $modelPemesananDetail->save($data_update);
        } else {
            $data = [
                'id_pemesanan'          => $id_pemesanan,
                'id_produk'             => $this->request->getPost('id_produk'),
                'sku'                   => $produk['sku'],
                'qty'                   => $this->request->getPost('qty'),
                'harga_satuan'          => $produk['harga_beli'],
                'total_harga'           => ($produk['harga_beli'] * $this->request->getPost('qty')),
            ];
            $modelPemesananDetail->save($data);
        }

        $json = [
            'notif' => 'Berhasil menambah list produk pemesanan',
        ];

        echo json_encode($json);
    }


    public function delete($id = null)
    {
        $id_pemesanan = $this->request->getPost('id_pemesanan');
        $modelPemesanan = new PemesananModel();
        $no_pemesanan = $modelPemesanan->find($id_pemesanan)['no_pemesanan'];

        $modelPemesananDetail = new PemesananDetailModel();

        $modelPemesananDetail->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/purchase-list_pemesanan/' . $no_pemesanan);
    }


    public function gantiNoPemesanan()
    {
        if ($this->request->isAJAX()) {
            $tanggal = $this->request->getVar('tanggal');

            $json = [
                'no_pemesanan'  => nomor_pemesanan_auto($tanggal)
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function checkListProduk()
    {
        if ($this->request->isAJAX()) {
            $id_pemesanan = $this->request->getVar('id_pemesanan');
            $modelPemesananDetail = new PemesananDetailModel();
            $produk = $modelPemesananDetail->where(['id_pemesanan' => $id_pemesanan])->findAll();

            if ($produk) {
                $json = ['ok' => 'ok'];
            } else {
                $json = ['null' => null];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }
}
