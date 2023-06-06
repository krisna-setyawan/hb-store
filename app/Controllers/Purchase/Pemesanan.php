<?php

namespace App\Controllers\Purchase;

use App\Models\Purchase\PembelianModel;
use App\Models\Purchase\PemesananDetailModel;
use App\Models\Purchase\PemesananModel;
use App\Models\Purchase\SupplierModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

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
                ->join('supplier', 'pemesanan.id_supplier = supplier.id', 'left')
                // ->where('pemesanan.deleted_at', null)
                ->orderBy('pemesanan.id', 'desc');

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


    public function alasanHapusPemesanan()
    {
        if ($this->request->isAJAX()) {
            $modelPemesanan = new PemesananModel();
            $modelPembelian = new PembelianModel();

            $data = [
                'id'                => $this->request->getPost('id'),
                'alasan_dihapus'    => $this->request->getPost('alasan_dihapus'),
            ];
            $modelPemesanan->save($data);

            $pembelian = $modelPembelian->where(['id_pemesanan' => $this->request->getPost('id')])->first();

            if ($pembelian) {
                $json = [
                    'ok' => 'ok',
                    'id_pembelian' => $pembelian['id']
                ];
            } else {
                $json = [
                    'ok' => 'ok',
                    'id_pembelian' => 0,
                    'id_pemesanan' => $this->request->getPost('id')
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function delete($id = null)
    {
        // $modelPemesananDetail = new PemesananDetailModel();
        // $detailPemesanan = $modelPemesananDetail->where(['id_pemesanan' => $id])->delete();

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
