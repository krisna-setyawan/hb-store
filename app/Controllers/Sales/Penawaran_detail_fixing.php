<?php

namespace App\Controllers\Sales;

use App\Models\Sales\CustomerAlamatModel;
use App\Models\Sales\GudangModel;
use App\Models\Sales\PenjualanDetailModel;
use App\Models\Sales\PenjualanModel;
use App\Models\Sales\PenawaranModel;
use App\Models\Sales\ProdukModel;
use App\Models\Sales\CustomerModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Penawaran_detail_fixing extends ResourcePresenter
{
    protected $helpers = ['user_admin_helper', 'nomor_auto_helper'];


    public function ListFixing($no_penawaran)
    {
        $penawaranModel = new PenawaranModel();
        $penawaran = $penawaranModel->getPenawaran($no_penawaran);
        $penjualanModel = new PenjualanModel();
        $penjualan = $penjualanModel->getPenjualanByIdPenawaran($penawaran['id']);
        $modelCustomer = new CustomerModel();
        $customer = $modelCustomer->findAll();
        $modelCustomerAlamat = new CustomerAlamatModel();
        $alamat_customer = $modelCustomerAlamat->where(['id_customer' => $penjualan['id_customer']])->findAll();
        $modelProduk = new ProdukModel();
        $produk = $modelProduk->findAll();
        $modelGudang = new GudangModel();
        $gudang = $modelGudang->findAll();

        $data = [
            'penjualan'             => $penjualan,
            'penawaran'             => $penawaran,
            'customer'              => $customer,
            'alamat_customer'       => $alamat_customer,
            'produk'                => $produk,
            'gudang'                => $gudang,
        ];
        return view('sales/penawaran_fixing/detail', $data);
    }


    public function getListProdukPenjualan()
    {
        if ($this->request->isAJAX()) {

            $modelPenjualan = new PenjualanModel();
            $modelPenjualanDetail = new PenjualanDetailModel();

            $id_penjualan = $this->request->getVar('id_penjualan');
            $penjualan = $modelPenjualan->find($id_penjualan);
            $produk_penjualan = $modelPenjualanDetail->getListProdukPenjualan($id_penjualan);

            if ($produk_penjualan) {
                $data = [
                    'produk_penjualan'      => $produk_penjualan,
                    'penjualan'             => $penjualan
                ];


                $ada_stok_kurang = false;
                foreach ($produk_penjualan as $pr) {
                    if ($pr['stok'] < $pr['qty']) {
                        $ada_stok_kurang = true;
                    }
                }


                $json = [
                    'list' => view('sales/penawaran_fixing/list_produk', $data),
                    'ada_stok_kurang' => $ada_stok_kurang
                ];
            } else {
                $json = [
                    'list' => '<tr><td colspan="9" class="text-center">Belum ada list Produk.</td></tr>',
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function getListAlamatCustomer()
    {
        $id_customer = $this->request->getVar('customer');

        $modelCustomerAlamat = new CustomerAlamatModel();
        $list_alamat_customer = $modelCustomerAlamat->getAlamatByCustomer($id_customer);
        $first_alamat_customer = $modelCustomerAlamat->getFirstAlamatCustomer($id_customer);

        $foreach_list_alamat = '<select onchange="change_alamat_customer()" class="form-select" id="alamat_customer" name="alamat_customer">';
        if ($list_alamat_customer) {

            foreach ($list_alamat_customer as $al_cust) {
                $foreach_list_alamat .= '<option value="' . $al_cust['id'] . '">' . $al_cust['nama'] . '</option>';
            }
            $foreach_list_alamat .= '</select>';

            $json = [
                'list_alamat_customer' => $foreach_list_alamat,
                'first_alamat_customer' => $first_alamat_customer,
                'result' => 'ada'
            ];
        } else {
            $json = [
                'result' => 'tidak ada'
            ];
        }

        echo json_encode($json);
    }


    public function getAlamatCustomer()
    {
        $id_alamat_customer = $this->request->getVar('id_alamat_customer');

        $modelCustomerAlamat = new CustomerAlamatModel();
        $alamat_customer = $modelCustomerAlamat->find($id_alamat_customer);
        $alamat_joined = $modelCustomerAlamat->getAlamatById($id_alamat_customer);

        $json = [
            'alamat_customer' => $alamat_customer,
            'alamat_joined' => $alamat_joined,
        ];

        echo json_encode($json);
    }


    public function gantiNoPenjualan()
    {
        if ($this->request->isAJAX()) {
            $tanggal = $this->request->getVar('tanggal');

            $json = [
                'no_penjualan'  => nomor_penjualan_auto($tanggal)
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function create()
    {
        $id_produk = $this->request->getPost('id_produk');
        $id_penjualan = $this->request->getPost('id_penjualan');

        $modelProduk = new ProdukModel();
        $produk = $modelProduk->find($id_produk);

        $modelPenjualanDetail = new PenjualanDetailModel();
        $cek_produk = $modelPenjualanDetail->where(['id_produk' => $id_produk, 'id_penjualan' => $id_penjualan])->first();

        if ($cek_produk) {
            $data_update = [
                'id'                    => $cek_produk['id'],
                'id_penjualan'          => $id_penjualan,
                'id_produk'             => $this->request->getPost('id_produk'),
                'qty'                   => $cek_produk['qty'] + $this->request->getPost('qty'),
                'harga_satuan'          => $cek_produk['harga_satuan'],
                'total_harga'           => $cek_produk['total_harga'] + ($cek_produk['harga_satuan'] * $this->request->getPost('qty')),
            ];
            $modelPenjualanDetail->save($data_update);
        } else {
            $data = [
                'id_penjualan'          => $id_penjualan,
                'id_produk'             => $this->request->getPost('id_produk'),
                'qty'                   => $this->request->getPost('qty'),
                'harga_satuan'          => $produk['harga_beli'],
                'total_harga'           => ($produk['harga_beli'] * $this->request->getPost('qty')),
            ];
            $modelPenjualanDetail->save($data);
        }

        $modelPenjualan = new PenjualanModel();
        $sum = $modelPenjualanDetail->sumTotalHargaProduk($id_penjualan);

        $data_update = [
            'id'                    => $id_penjualan,
            'total_harga_produk'    => $sum['total_harga'],
        ];
        $modelPenjualan->save($data_update);

        $json = [
            'notif' => 'Berhasil menambah list produk penjualan',
            'total_harga_produk'   => $sum['total_harga'],
        ];

        echo json_encode($json);
    }


    public function update($id = null)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $modelPenjualanDetail = new PenjualanDetailModel();
        $oldListProduk = $modelPenjualanDetail->find($id);

        $biaya_tambahan = str_replace(".", "", $data['new_biaya_tambahan']);
        $diskon = str_replace(".", "", $data['new_diskon']);

        $data_update_produk = [
            'id'                    => $id,
            'qty'                   => $data['new_qty'],
            'biaya_tambahan'        => $biaya_tambahan,
            'diskon'                => $diskon,
            'total_harga'           => (($oldListProduk['harga_satuan'] * $data['new_qty']) + $biaya_tambahan) - $diskon,
            'catatan'               => $data['new_catatan'],
        ];
        $modelPenjualanDetail->save($data_update_produk);

        $modelPenjualan = new PenjualanModel();
        $sum = $modelPenjualanDetail->sumTotalHargaProduk($data['id_penjualan']);
        $data_update_penjualan = [
            'id'                    => $data['id_penjualan'],
            'total_harga_produk'    => $sum['total_harga'],
        ];
        $modelPenjualan->save($data_update_penjualan);

        $json = [
            'notif' => 'Berhasil update list produk penjualan',
            'total_harga_produk'   => $sum['total_harga'],
        ];

        echo json_encode($json);
    }


    public function delete($id = null)
    {
        $id_penjualan = $this->request->getPost('id_penjualan');
        $modelPenjualan = new PenjualanModel();
        $modelPenawaran = new PenawaranModel();

        $id_penawaran = $modelPenjualan->find($id_penjualan)['id_penawaran'];
        $no_penawaran = $modelPenawaran->find($id_penawaran)['no_penawaran'];

        $modelPenjualanDetail = new PenjualanDetailModel();

        $modelPenjualanDetail->delete($id);

        $sum = $modelPenjualanDetail->sumTotalHargaProduk($id_penjualan);

        $data_update = [
            'id'                    => $id_penjualan,
            'total_harga_produk'    => $sum['total_harga'],
        ];
        $modelPenjualan->save($data_update);

        session()->setFlashdata('pesan', 'List Produk berhasil dihapus.');
        return redirect()->to('/sales-list_fixing/' . $no_penawaran);
    }
}
