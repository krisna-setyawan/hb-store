<?php

namespace App\Controllers\Purchase;

use App\Models\Purchase\PembelianModel;
use App\Models\Purchase\PemesananDetailModel;
use App\Models\Purchase\PemesananFixingDetailModel;
use App\Models\Purchase\PemesananFixingModel;
use App\Models\Purchase\PemesananModel;
use App\Models\Purchase\SupplierModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\Config\Services;

class Pemesanan extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];


    public function index()
    {
        return view('purchase/pemesanan/index');
    }


    public function getDataPemesanan()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $data =  $db->table('pemesanan')
                ->select('pemesanan.id, pemesanan.no_pemesanan, pemesanan.tanggal, supplier.nama as supplier, pemesanan.total_harga_produk, pemesanan.status')
                ->join('supplier', 'pemesanan.id_supplier = supplier.id', 'left');
            // ->where('pemesanan.deleted_at', null)
            // ->orderBy('pemesanan.id', 'desc');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    if ($row->status == 'Pending') {
                        return '
                    <a title="List Pemesanan" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . base_url() . '/purchase-list_pemesanan/' . $row->no_pemesanan . '">
                        <i class="fa-fw fa-solid fa-circle-arrow-right"></i>
                    </a>';
                    } else {
                        return '
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(\'' . $row->no_pemesanan . '\')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>
                    <a title="Duplikat" class="px-2 py-0 btn btn-sm btn-outline-success" onclick="repeatPemesanan(\'' . $row->no_pemesanan . '\')">
                        <i class="fa-fw fa-solid fa-repeat"></i>
                    </a>';
                    }
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function readNotifPemesanan($kode_trx_api)
    {
        baca_notifikasi($kode_trx_api, 'Pemesanan');
        return redirect()->to('/purchase-pemesanan');
    }


    public function show($no = null)
    {
        if ($this->request->isAJAX()) {
            $modelPemesanan = new PemesananModel();
            $pemesanan = $modelPemesanan->getPemesanan($no);

            $modelPemesananDetail = new PemesananDetailModel();
            $pemesanan_detail = $modelPemesananDetail->getListProdukPemesanan($pemesanan['id']);

            $data = [
                'pemesanan' => $pemesanan,
                'pemesanan_detail' => $pemesanan_detail,
            ];

            $json = [
                'data' => view('purchase/pemesanan/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function new()
    {
        if ($this->request->isAJAX()) {
            date_default_timezone_set('Asia/Jakarta');
            $modelSupplier = new SupplierModel();
            $supplier = $modelSupplier->findAll();

            $data = [
                'supplier'              => $supplier,
                'nomor_pemesanan_auto'  => nomor_pemesanan_auto(date('Y-m-d'))
            ];

            $json = [
                'data' => view('purchase/pemesanan/add', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function create()
    {
        if ($this->request->isAJAX()) {
            $validasi = [
                'no_pemesanan' => [
                    'rules' => 'required|is_unique[pemesanan.no_pemesanan]',
                    'errors' => [
                        'required' => 'Nomor pemesanan harus diisi.',
                        'is_unique' => 'Nomor pemesanan sudah ada dalam database.'
                    ]
                ],
                'tanggal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'tanggal pemesanan harus diisi.',
                    ]
                ],
                'id_supplier' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Supplier harus dipilih.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_no_pemesanan' => $validation->getError('no_pemesanan'),
                    'error_tanggal' => $validation->getError('tanggal'),
                    'error_id_supplier' => $validation->getError('id_supplier'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelSupplier = new SupplierModel();
                $supplier = $modelSupplier->find($this->request->getPost('id_supplier'));

                $modelPemesanan = new PemesananModel();
                $data = [
                    'no_pemesanan'          => $this->request->getPost('no_pemesanan'),
                    'tanggal'               => $this->request->getPost('tanggal'),
                    'id_supplier'           => $this->request->getPost('id_supplier'),
                    'id_user'               => $this->request->getPost('id_user'),
                    'jenis_supplier'        => $supplier['jenis_supplier'],
                    'id_perusahaan'         => $supplier['id_perusahaan'],
                ];
                $modelPemesanan->save($data);

                $json = [
                    'success' => 'Berhasil menambah data produk',
                    'no_pemesanan' => $this->request->getPost('no_pemesanan'),
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }





    public function simpanPemesanan()
    {
        if ($this->request->isAJAX()) {
            $id_pemesanan = $this->request->getVar('id_pemesanan');

            $modelPemesanan = new PemesananModel();
            $modelPemesananDetail = new PemesananDetailModel();
            $sum = $modelPemesananDetail->sumTotalHargaProduk($id_pemesanan);

            $modelSupplier = new SupplierModel();
            $supplier = $modelSupplier->find($this->request->getPost('id_supplier'));

            $data_update = [
                'id'                    => $this->request->getVar('id_pemesanan'),
                'no_pemesanan'          => $this->request->getVar('no_pemesanan'),
                'id_supplier'           => $this->request->getVar('id_supplier'),
                'jenis_supplier'        => $supplier['jenis_supplier'],
                'id_perusahaan'         => $supplier['id_perusahaan'],
                'id_gudang'             => $this->request->getVar('gudang'),
                'tanggal'               => $this->request->getVar('tanggal'),
                'total_harga_produk'    => $sum['total_harga'],
            ];
            $modelPemesanan->save($data_update);

            $json = ['ok' => 'ok'];
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function kirimPemesanan()
    {
        $id_pemesanan = $this->request->getVar('id_pemesanan');
        $kode_trx_api = get_kode_trx_api();

        $modelPemesanan = new PemesananModel();
        $modelSupplier = new SupplierModel();
        $supplier = $modelSupplier->find($this->request->getPost('id_supplier'));

        $modelPemesananDetail = new PemesananDetailModel();
        $sum = $modelPemesananDetail->sumTotalHargaProduk($id_pemesanan);

        $data_update = [
            'id'                    => $id_pemesanan,
            'no_pemesanan'          => $this->request->getVar('no_pemesanan'),
            'kode_trx_api'          => $kode_trx_api,
            'id_supplier'           => $this->request->getVar('id_supplier'),
            'jenis_supplier'        => $supplier['jenis_supplier'],
            'id_perusahaan'         => $supplier['id_perusahaan'],
            'id_gudang'             => $this->request->getVar('gudang'),
            'id_user'               => $this->request->getVar('id_user'),
            'tanggal'               => $this->request->getVar('tanggal'),
            'total_harga_produk'    => $sum['total_harga'],
            'status'                => 'Ordered'
        ];
        $modelPemesanan->save($data_update);

        $pemesanan = $modelPemesanan->find($id_pemesanan);

        $pesanFlash = '';

        if ($supplier['jenis_supplier'] == 'Haebot') {
            $client = Services::curlrequest();

            // Get data perusahaan
            $perusahaan = get_data_perushaan($supplier['id_perusahaan']);

            // Sent data Order (Haebot Order / Penjualan Order)
            $url_sent_order = $perusahaan['url'] . 'hbapi-sent-penjualan-order';
            $data_order = [
                'id_pemesanan'      => $pemesanan['id'],
                'no_pemesanan'      => $this->request->getVar('no_pemesanan'),
                'kode_trx_api'      => $kode_trx_api,
                'id_perusahaan'     => $_ENV['ID_PERUSAHAAN'],
                'nama_perusahaan'   => $_ENV['NAMA_PERUSAHAAN'],
                'tanggal'           => $this->request->getVar('tanggal'),
                'grand_total'       => $sum['total_harga'],
            ];
            $response_sent_order = $client->request('POST', $url_sent_order, [
                'form_params' => $data_order
            ]);
            $responseBodySentOrder = json_decode($response_sent_order->getBody(), true);


            if ($response_sent_order->getStatusCode() === 201) {

                // Sent Notif
                $url_give_notif = $perusahaan['url'] . 'hbapi-give-notif';
                $data_notif = [
                    'kode_trx_api'  => $kode_trx_api,
                    'untuk'         => 'Order',
                    'notif'         => 'Order masuk dari ' . $_ENV['NAMA_PERUSAHAAN']
                ];
                $response_give_notif = $client->request('POST', $url_give_notif, [
                    'form_params' => $data_notif
                ]);
                $responseBodyNotif = json_decode($response_give_notif->getBody(), true);

                if ($response_give_notif->getStatusCode() === 201) {
                    $pesanFlash .= "Berhasil kirim pemesanan ke " . $perusahaan['nama'] . " dan " . $responseBodyNotif['messages'];
                } else {
                    $pesanFlash .= "Berhasil kirim pemesanan tapi Gagal mengirim Notif " . $responseBodyNotif['error'];
                }
            } else {
                echo 'error';
                $pesanFlash .= "Gagal mengirim pemesanan " . $responseBodySentOrder['error'];
            }
        } else {
            $pesanFlash .= "Status pemesanan berhasil diupdate ke Ordered.";

            $modelPemesananFixing = new PemesananFixingModel();
            $dataFixing = [
                'id_pemesanan'          => $pemesanan['id'],
                'id_supplier'           => $pemesanan['id_supplier'],
                'id_user'               => $pemesanan['id_user'],
                'id_gudang'             => $pemesanan['id_gudang'],
                'invoice'               => '-',
                'no_pemesanan'          => $pemesanan['no_pemesanan'],
                'tanggal'               => $pemesanan['tanggal'],
                'panjang'               => 1,
                'lebar'                 => 1,
                'tinggi'                => 1,
                'berat'                 => 1,
                'carton_koli'           => 1,
                'exw'                   => $sum['total_harga'],
                'grand_total'           => $sum['total_harga'],
                'status'                => 'Fixing',
            ];
            $modelPemesananFixing->save($dataFixing);
            $id_pemesanan_fixing = $modelPemesananFixing->getInsertID();

            $modelPemesananFixingDetail = new PemesananFixingDetailModel();
            $listProdukPemesanan = $modelPemesananDetail->where(['id_pemesanan' => $pemesanan['id']])->findAll();
            foreach ($listProdukPemesanan as $produk) {
                $data_produk = [
                    'id_pemesanan_fixing'   => $id_pemesanan_fixing,
                    'id_produk'             => $produk['id_produk'],
                    'sku'                   => $produk['sku'],
                    'qty'                   => $produk['qty'],
                    'harga_satuan'          => $produk['harga_satuan'],
                    'total_harga'           => $produk['total_harga'],
                ];
                $modelPemesananFixingDetail->save($data_produk);
            }
        }

        session()->setFlashdata('pesan', $pesanFlash);
        return redirect()->to('/purchase-pemesanan');
    }





    public function alasanHapusPemesanan()
    {
        if ($this->request->isAJAX()) {
            $modelPemesanan = new PemesananModel();

            $data = [
                'id'                => $this->request->getPost('id'),
                'alasan_dihapus'    => $this->request->getPost('alasan_dihapus'),
            ];
            $modelPemesanan->save($data);

            $json = [
                'ok' => 'ok',
                'id_pemesanan' => $this->request->getPost('id')
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function delete($id = null)
    {
        $modelPemesananFixing = new PemesananFixingModel();
        $modelPemesananFixing->where(['id_pemesanan' => $id])->delete();

        $modelPemesanan = new PemesananModel();
        $modelPemesanan->save(
            [
                'id' => $id,
                'status' => 'Dihapus',
            ]
        );
        $modelPemesanan->delete($id);

        session()->setFlashdata('pesan', 'Data pemesanan berhasil dihapus.');
        return redirect()->to('/purchase-fixing_pemesanan');
    }


    public function repeatPemesanan($no = null)
    {
        if ($this->request->isAJAX()) {
            $modelPemesanan = new PemesananModel();
            $pemesanan = $modelPemesanan->getPemesanan($no);

            if ($pemesanan) {
                $modelPemesananDetail = new PemesananDetailModel();
                $pemesanan_detail = $modelPemesananDetail->getListProdukPemesanan($pemesanan['id']);

                $data = [
                    'pemesanan' => $pemesanan,
                    'pemesanan_detail' => $pemesanan_detail,
                    'nomor_pemesanan_auto'  => nomor_pemesanan_auto(date('Y-m-d'))
                ];

                $json = [
                    'data' => view('purchase/pemesanan/repeat', $data),
                ];
            } else {
                $json = [];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function saveRepeat()
    {
        if ($this->request->isAJAX()) {
            $validasi = [
                'no_pemesanan' => [
                    'rules' => 'required|is_unique[pemesanan.no_pemesanan]',
                    'errors' => [
                        'required' => 'Nomor pemesanan harus diisi.',
                        'is_unique' => 'Nomor pemesanan sudah ada dalam database.'
                    ]
                ],
                'tanggal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'tanggal pemesanan harus diisi.',
                    ]
                ]
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_no_pemesanan' => $validation->getError('no_pemesanan'),
                    'error_tanggal' => $validation->getError('tanggal'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelPemesanan = new PemesananModel();
                $modelPemesananDetail = new PemesananDetailModel();

                $pemesanan = $modelPemesanan->withDeleted()->where(['id' => $this->request->getPost('id_pemesanan')])->first();

                $data = [
                    'no_pemesanan'          => $this->request->getPost('no_pemesanan'),
                    'tanggal'               => $this->request->getPost('tanggal'),
                    'id_supplier'           => $pemesanan['id_supplier'],
                ];
                $modelPemesanan->save($data);

                $listProdukPemesanan = $modelPemesananDetail->where(['id_pemesanan' => $pemesanan['id']])->findAll();
                foreach ($listProdukPemesanan as $produk) {
                    $data = [
                        'id_pemesanan'          => $modelPemesanan->getInsertID(),
                        'id_produk'             => $produk['id_produk'],
                        'qty'                   => $produk['qty'],
                        'harga_satuan'          => $produk['harga_satuan'],
                        'total_harga'           => $produk['total_harga'],
                    ];
                    $modelPemesananDetail->save($data);
                }

                $json = [
                    'success' => 'Berhasil menambah data produk',
                    'no_pemesanan' => $this->request->getPost('no_pemesanan'),
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }
}
