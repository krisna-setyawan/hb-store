<?php

namespace App\Controllers\Sales;

use App\Models\Sales\CustomerModel;
use App\Models\Sales\PenawaranDetailModel;
use App\Models\Sales\PenawaranModel;
use App\Models\Sales\ProdukModel;
use App\Models\Sales\UserModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Penawaran_detail extends ResourcePresenter
{
    protected $helpers = ['user_admin_helper', 'nomor_auto_helper'];


    public function List_penawaran($no_penawaran)
    {
        $modelCustomer = new CustomerModel();
        $customer = $modelCustomer->findAll();
        $modelProduk = new ProdukModel();
        $produk = $modelProduk->findAll();
        $modelUser = new UserModel();
        $user = $modelUser->getAllUserWithKaryawanName();

        $penawaranModel = new PenawaranModel();
        $data = [
            'penawaran'             => $penawaranModel->getPenawaran($no_penawaran),
            'customer'              => $customer,
            'produk'                => $produk,
            'user'                  => $user
        ];
        return view('sales/penawaran/detail', $data);
    }


    public function getProdukForAddList($customer)
    {
        if ($this->request->isAJAX()) {
            $modelProduk = new ProdukModel();
            $produkCustomer = $modelProduk->getProdukFormPenjualanDetailCustomer($customer);

            $data = [
                'produk_customer' => $produkCustomer
            ];

            $json = [
                'data' => view('sales/penawaran/produk_customer', $data),
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
                'data' => view('sales/penawaran/find_produk', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function getListProdukPenawaran()
    {
        if ($this->request->isAJAX()) {

            $id_penawaran = $this->request->getVar('id_penawaran');

            $modelPenawaranDetail = new PenawaranDetailModel();
            $produk_penawaran = $modelPenawaranDetail->getListProdukPenawaran($id_penawaran);

            if ($produk_penawaran) {
                $data = [
                    'produk_penawaran'      => $produk_penawaran,
                ];

                $json = [
                    'list' => view('sales/penawaran/list_produk', $data),
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
        $id_penawaran = $this->request->getPost('id_penawaran');

        $modelProduk = new ProdukModel();
        $produk = $modelProduk->find($id_produk);

        $modelPenawaranDetail = new PenawaranDetailModel();
        $cek_produk = $modelPenawaranDetail->where(['id_produk' => $id_produk, 'id_penawaran' => $id_penawaran])->first();

        if ($cek_produk) {
            $data_update = [
                'id'                    => $cek_produk['id'],
                'id_penawaran'          => $id_penawaran,
                'id_produk'             => $this->request->getPost('id_produk'),
                'qty'                   => $cek_produk['qty'] + $this->request->getPost('qty'),
                'harga_satuan'          => $produk['harga_beli'],
                'total_harga'           => $cek_produk['total_harga'] + ($produk['harga_beli'] * $this->request->getPost('qty')),
            ];
            $modelPenawaranDetail->save($data_update);
        } else {
            $data = [
                'id_penawaran'          => $id_penawaran,
                'id_produk'             => $this->request->getPost('id_produk'),
                'qty'                   => $this->request->getPost('qty'),
                'harga_satuan'          => $produk['harga_beli'],
                'total_harga'           => ($produk['harga_beli'] * $this->request->getPost('qty')),
            ];
            $modelPenawaranDetail->save($data);
        }

        $json = [
            'notif' => 'Berhasil menambah list produk penawaran',
        ];

        echo json_encode($json);
    }


    public function delete($id = null)
    {
        $id_penawaran = $this->request->getPost('id_penawaran');
        $modelPenawaran = new PenawaranModel();
        $no_penawaran = $modelPenawaran->find($id_penawaran)['no_penawaran'];

        $modelPenawaranDetail = new PenawaranDetailModel();

        $modelPenawaranDetail->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/sales-list_penawaran/' . $no_penawaran);
    }


    public function gantiNoPenawaran()
    {
        if ($this->request->isAJAX()) {
            $tanggal = $this->request->getVar('tanggal');

            $json = [
                'no_penawaran'  => nomor_penawaran_auto($tanggal)
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function checkListProduk()
    {
        if ($this->request->isAJAX()) {
            $id_penawaran = $this->request->getVar('id_penawaran');
            $modelPenawaranDetail = new PenawaranDetailModel();
            $produk = $modelPenawaranDetail->where(['id_penawaran' => $id_penawaran])->findAll();

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


    public function simpanPenawaran()
    {
        if ($this->request->isAJAX()) {
            $id_penawaran = $this->request->getVar('id_penawaran');

            $modelPenawaran = new PenawaranModel();
            $modelPenawaranDetail = new PenawaranDetailModel();
            $sum = $modelPenawaranDetail->sumTotalHargaProduk($id_penawaran);

            $data_update = [
                'id'                    => $this->request->getVar('id_penawaran'),
                'no_penawaran'          => $this->request->getVar('no_penawaran'),
                'id_customer'           => $this->request->getVar('id_customer'),
                'tanggal'               => $this->request->getVar('tanggal'),
                'total_harga_produk'    => $sum['total_harga'],
            ];
            $modelPenawaran->save($data_update);

            $json = ['ok' => 'ok'];
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function kirimPenawaran()
    {
        $id_penawaran = $this->request->getVar('id_penawaran');

        $modelPenawaran = new PenawaranModel();
        $penawaran = $modelPenawaran->find($id_penawaran);

        $modelPenawaranDetail = new PenawaranDetailModel();
        $sum = $modelPenawaranDetail->sumTotalHargaProduk($id_penawaran);

        $data_update = [
            'id'                    => $penawaran['id'],
            'id_customer'           => $this->request->getVar('customer'),
            'no_penawaran'          => $this->request->getVar('no_penawaran'),
            'id_user'               => $this->request->getVar('id_user'),
            'total_harga_produk'    => $sum['total_harga'],
            'tanggal'               => $this->request->getVar('tanggal'),
            'status'                => 'Ordered'
        ];
        $modelPenawaran->save($data_update);

        session()->setFlashdata('pesan', 'Status penawaran berhasil diupdate ke Ordered.');
        return redirect()->to('/sales-penawaran');
    }
}
