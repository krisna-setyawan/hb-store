<?php

namespace App\Controllers\Sales;

use App\Models\Sales\CustomerModel;
use App\Models\Sales\PenjualanModel;
use App\Models\Sales\PenawaranDetailModel;
use App\Models\Sales\PenawaranModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class Penawaran extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];


    public function index()
    {
        return view('sales/penawaran/index');
    }


    public function getDataPenawaran()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $data =  $db->table('penawaran')
                ->select('penawaran.id, penawaran.no_penawaran, penawaran.tanggal, customer.nama as customer, penawaran.total_harga_produk, penawaran.status')
                ->join('customer', 'penawaran.id_customer = customer.id', 'left')
                // ->where('penawaran.deleted_at', null)
                ->orderBy('penawaran.id', 'desc');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    if ($row->status == 'Pending') {
                        return '
                    <a title="List Penawaran" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . base_url() . '/sales-list_penawaran/' . $row->no_penawaran . '">
                        <i class="fa-fw fa-solid fa-circle-arrow-right"></i>
                    </a>';
                    } else {
                        return '
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(\'' . $row->no_penawaran . '\')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>
                    <a title="Duplikat" class="px-2 py-0 btn btn-sm btn-outline-success" onclick="repeatPenawaran(\'' . $row->no_penawaran . '\')">
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
            $modelPenawaran = new PenawaranModel();
            $penawaran = $modelPenawaran->getPenawaran($no);

            $modelPenawaranDetail = new PenawaranDetailModel();
            $penawaran_detail = $modelPenawaranDetail->getListProdukPenawaran($penawaran['id']);

            $data = [
                'penawaran' => $penawaran,
                'penawaran_detail' => $penawaran_detail,
            ];

            $json = [
                'data' => view('sales/penawaran/show', $data),
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
            $modelcustomer = new CustomerModel();
            $customer = $modelcustomer->findAll();

            $data = [
                'customer'              => $customer,
                'nomor_penawaran_auto'  => nomor_penawaran_auto(date('Y-m-d'))
            ];

            $json = [
                'data' => view('sales/penawaran/add', $data),
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
                'no_penawaran' => [
                    'rules' => 'required|is_unique[penawaran.no_penawaran]',
                    'errors' => [
                        'required' => 'Nomor penawaran harus diisi.',
                        'is_unique' => 'Nomor penawaran sudah ada dalam database.'
                    ]
                ],
                'tanggal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'tanggal penawaran harus diisi.',
                    ]
                ],
                'id_customer' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'customer harus dipilih.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_no_penawaran' => $validation->getError('no_penawaran'),
                    'error_tanggal' => $validation->getError('tanggal'),
                    'error_id_customer' => $validation->getError('id_customer'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelPenawaran = new PenawaranModel();
                $data = [
                    'no_penawaran'          => $this->request->getPost('no_penawaran'),
                    'tanggal'               => $this->request->getPost('tanggal'),
                    'id_customer'           => $this->request->getPost('id_customer'),
                    'id_user'               => $this->request->getPost('id_user'),
                ];
                $modelPenawaran->save($data);

                $json = [
                    'success' => 'Berhasil menambah data produk',
                    'no_penawaran' => $this->request->getPost('no_penawaran'),
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function alasanHapusPenawaran()
    {
        if ($this->request->isAJAX()) {
            $modelPenawaran = new PenawaranModel();
            $modelPenjualan = new PenjualanModel();

            $data = [
                'id'                => $this->request->getPost('id'),
                'alasan_dihapus'    => $this->request->getPost('alasan_dihapus'),
            ];
            $modelPenawaran->save($data);

            $penjualan = $modelPenjualan->where(['id_penawaran' => $this->request->getPost('id')])->first();

            if ($penjualan) {
                $json = [
                    'ok' => 'ok',
                    'id_penjualan' => $penjualan['id']
                ];
            } else {
                $json = [
                    'ok' => 'ok',
                    'id_penjualan' => 0,
                    'id_penawaran' => $this->request->getPost('id')
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function delete($id = null)
    {
        // $modelPenawaranDetail = new PenawaranDetailModel();
        // $detailPenawaran = $modelPenawaranDetail->where(['id_penawaran' => $id])->delete();

        $modelPenawaran = new PenawaranModel();
        $modelPenawaran->save(
            [
                'id' => $id,
                'status' => 'Dihapus',
            ]
        );
        $modelPenawaran->delete($id);

        session()->setFlashdata('pesan', 'Data penawaran berhasil dihapus.');
        return redirect()->to('/sales-fixing_penawaran');
    }


    public function repeatPenawaran($no = null)
    {
        if ($this->request->isAJAX()) {
            $modelPenawaran = new PenawaranModel();
            $penawaran = $modelPenawaran->getPenawaran($no);

            if ($penawaran) {
                $modelPenawaranDetail = new PenawaranDetailModel();
                $penawaran_detail = $modelPenawaranDetail->getListProdukPenawaran($penawaran['id']);

                $data = [
                    'penawaran' => $penawaran,
                    'penawaran_detail' => $penawaran_detail,
                    'nomor_penawaran_auto'  => nomor_penawaran_auto(date('Y-m-d'))
                ];

                $json = [
                    'data' => view('sales/penawaran/repeat', $data),
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
                'no_penawaran' => [
                    'rules' => 'required|is_unique[penawaran.no_penawaran]',
                    'errors' => [
                        'required' => 'Nomor penawaran harus diisi.',
                        'is_unique' => 'Nomor penawaran sudah ada dalam database.'
                    ]
                ],
                'tanggal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'tanggal penawaran harus diisi.',
                    ]
                ]
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_no_penawaran' => $validation->getError('no_penawaran'),
                    'error_tanggal' => $validation->getError('tanggal'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelPenawaran = new PenawaranModel();
                $modelPenawaranDetail = new PenawaranDetailModel();

                $penawaran = $modelPenawaran->withDeleted()->where(['id' => $this->request->getPost('id_penawaran')])->first();

                $data = [
                    'no_penawaran'          => $this->request->getPost('no_penawaran'),
                    'tanggal'               => $this->request->getPost('tanggal'),
                    'id_customer'           => $penawaran['id_customer'],
                ];
                $modelPenawaran->save($data);

                $listProdukPenawaran = $modelPenawaranDetail->where(['id_penawaran' => $penawaran['id']])->findAll();
                foreach ($listProdukPenawaran as $produk) {
                    $data = [
                        'id_penawaran'          => $modelPenawaran->getInsertID(),
                        'id_produk'             => $produk['id_produk'],
                        'qty'                   => $produk['qty'],
                        'harga_satuan'          => $produk['harga_satuan'],
                        'total_harga'           => $produk['total_harga'],
                    ];
                    $modelPenawaranDetail->save($data);
                }

                $json = [
                    'success' => 'Berhasil menambah data produk',
                    'no_penawaran' => $this->request->getPost('no_penawaran'),
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }
}
