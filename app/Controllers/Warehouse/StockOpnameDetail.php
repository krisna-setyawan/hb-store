<?php

namespace App\Controllers\Warehouse;

use App\Models\Warehouse\LokasiProdukModel;
use App\Models\Warehouse\StockOpnameModel;
use App\Models\Warehouse\StockOpnameDetailModel;
use CodeIgniter\RESTful\ResourcePresenter;

class StockOpnameDetail extends ResourcePresenter
{
    protected $helpers = ['form', 'stok_helper', 'nomor_auto_helper'];

    public function ListProdukStockOpname($idStok)
    {
        $modelLokasi    = new LokasiProdukModel();
        $modelStok      = new StockOpnameModel();
        $stok           = $modelStok->find($idStok);

        $id_gudang      = session()->get('id_gudang');
        $produk         = $modelLokasi->getProdukByGudang($id_gudang);

        $data = [
            'id_gudang' => $id_gudang,
            'produk'    => $produk,
            'stok'      => $stok,
        ];
        return view('warehouse/stockopname/listStokOpname', $data);
    }


    public function StokbyProduk()
    {
        $idProduk = $this->request->getVar('idProduk');
        $id_gudang      = session()->get('id_gudang');

        $db             = \Config\Database::connect();
        $builderLokasi  = $db->table('lokasi_produk')->selectSum('stok')->where('id_produk', $idProduk)->where('id_gudang', $id_gudang);
        $listLokasi     = $builderLokasi->get()->getRowArray();

        echo $listLokasi['stok'];
    }


    public function getListProdukStock()
    {
        if ($this->request->isAJAX()) {

            $idStockOpname = $this->request->getPost('idStockOpname');

            $modelStokDetail   = new StockOpnameDetailModel();
            $modelStok         = new StockOpnameModel();
            $stok              = $modelStok->find($idStockOpname);
            $stokProduk        = $modelStokDetail->getListProdukStock($idStockOpname);

            if ($stokProduk) {
                $data = [
                    'stokProduk'      => $stokProduk,
                    'stok'            => $stok,
                ];

                $json = [
                    'list' => view('warehouse/stockopname/list_produk', $data),
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
        if ($this->request->isAJAX()) {
            $validasi = [
                'idProduk'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Produk harus diisi.'
                    ]
                ],
                'stokFisik'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Jumlah stok fisik harus diisi.'
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_idProduk'    => $validation->getError('idProduk'),
                    'error_stok'        => $validation->getError('stokFisik'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelStokDetail   = new StockOpnameDetailModel();

                $idStockOpname  = $this->request->getPost('idStokOpname');
                $idProduk       = $this->request->getPost('idProduk');
                $jumlahFisik    = $this->request->getPost('stokFisik');
                $jumlahVirtual  = $this->request->getPost('stokVirtual');

                $cekProduk      = $modelStokDetail->where([
                    'id_produk'         => $idProduk,
                    'id_stock_opname'   => $idStockOpname
                ])->first();

                if ($cekProduk) {
                    $data_update = [
                        'id'              => $cekProduk['id'],
                        'id_stock_opname' => $idStockOpname,
                        'id_produk'       => $idProduk,
                        'jumlah_fisik'    => $jumlahFisik,
                        'jumlah_virtual'  => $jumlahVirtual,
                        'selisih'         => $jumlahFisik - $jumlahVirtual,
                    ];
                    $modelStokDetail->save($data_update);

                    $json = [
                        'success' => 'Berhasil mengupdate list produk',
                    ];
                } else {
                    $data = [
                        'id_stock_opname' => $idStockOpname,
                        'id_produk'       => $idProduk,
                        'jumlah_fisik'    => $jumlahFisik,
                        'jumlah_virtual'  => $jumlahVirtual,
                        'selisih'         => $jumlahFisik - $jumlahVirtual,
                    ];

                    $modelStokDetail->insert($data);

                    $json = [
                        'success' => 'Berhasil menambah list produk',
                    ];
                }
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function update($id = null)
    {
        $modelStokDetail    = new StockOpnameDetailModel();

        $jumlahFisik    = $this->request->getPost('new_jumlah_fisik');
        $jumlahVirtual  = $this->request->getPost('jumlah_virtual');

        $data_update_produk = [
            'id'            => $id,
            'jumlah_fisik'  => $jumlahFisik,
            'selisih'       => $jumlahFisik - $jumlahVirtual
        ];
        $modelStokDetail->save($data_update_produk);

        $json = [
            'notif' => 'Berhasil update list produk',
        ];

        echo json_encode($json);
    }


    public function delete($id = null)
    {
        $modelStokDetail = new StockOpnameDetailModel();

        $modelStokDetail->delete($id);
        return redirect()->back();
    }


    public function checkListProduk()
    {
        if ($this->request->isAJAX()) {
            $idStockOpname = $this->request->getVar('idStockOpname');
            $modelStokDetail = new StockOpnameDetailModel();
            $stok = $modelStokDetail->where(['id_stock_opname' => $idStockOpname])->findAll();

            if ($stok) {
                $json = ['ok' => 'ok'];
            } else {
                $json = ['null' => null];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function updateStatusStock()
    {
        $modelStok  = new StockOpnameModel();
        $id         = $this->request->getPost('idStokOpname');

        $data = [
            'id'        => $id,
            'status'    => 'Selesai'
        ];

        $modelStok->save($data);

        $id_gudang      = session()->get('id_gudang');

        session()->setFlashdata('pesan', 'Status pemesanan berhasil diupdate ke Selesai.');
        return redirect()->to('/warehouse-stockopname/' . $id_gudang);
    }
}
