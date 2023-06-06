<?php

namespace App\Controllers\Warehouse;

use App\Models\Warehouse\GudangModel;
use App\Models\Warehouse\StockOpnameModel;
use App\Models\Warehouse\StockOpnameDetailModel;
use App\Models\Warehouse\UserModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class StockOpname extends ResourcePresenter
{
    protected $helpers = ['form', 'stok_helper', 'nomor_auto_helper'];


    public function opname($id_gudang)
    {
        session()->set('id_gudang', $id_gudang);

        $modelGudang = new GudangModel();

        $gudang = $modelGudang->getGudangWithAlamat($id_gudang);
        $data = [
            'id_gudang' => $id_gudang,
            'nama_gudang' => $gudang['nama']
        ];

        return view('warehouse/stockopname/index', $data);
    }


    public function getDataStok()
    {
        if ($this->request->isAJAX()) {
            $idGudang     = session()->get('id_gudang');

            $db = \Config\Database::connect();
            $data =  $db->table('stock_opname')
                ->select('stock_opname.id, stock_opname.nomor as nomor, stock_opname.tanggal as tanggal, stock_opname.status, users.name as pj')
                ->join('users', 'stock_opname.id_pj = users.id', 'left')
                ->where('stock_opname.id_gudang', $idGudang)->orderBy('id', 'desc');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    if ($row->status == 'Proses') {
                        return '
                    <a title="List Stok" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . base_url() . '/warehouse-list_stok/' . $row->id . '">
                        <i class="fa-fw fa-solid fa-circle-arrow-right"></i>
                    </a>';
                    } else {
                        return '
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(\'' . $row->id . '\')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>';
                    }
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelStok          = new StockOpnameModel();
            $stockopname        = $modelStok->getStock($id);

            $modelStokDetail    = new StockOpnameDetailModel();
            $stockopnamedetail  = $modelStokDetail->getListProdukStock($stockopname['id']);

            $modelUser = new UserModel();
            $pj        = $modelUser->getKaryawanByIdUser($stockopname['id_pj']);

            $data = [
                'penanggung_jawab'  => $pj['nama_lengkap'],
                'stockopname'       => $stockopname,
                'stockopnamedetail' => $stockopnamedetail,
            ];

            $json = [
                'data' => view('warehouse/stockopname/show', $data),
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
            $modelStok   = new StockOpnameModel();
            $stok        = $modelStok->findAll();

            $data = [
                'stok'              => $stok,
                'nomor_stok_auto'   => nomor_stockopname_auto(date('Y-m-d'))
            ];

            $json = [
                'data'       => view('warehouse/stockopname/add', $data),
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
                'nomor'       => [
                    'rules'  => 'required|is_unique[stock_opname.nomor]',
                    'errors' => [
                        'required'  => '{field} harus diisi.',
                        'is_unique' => '{field} sudah ada dalam database'
                    ]
                ],
                'tanggal'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi.'
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nomor'    => $validation->getError('nomor'),
                    'error_tanggal'  => $validation->getError('tanggal'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {

                date_default_timezone_set('Asia/Jakarta');
                $modelStok   = new StockOpnameModel();

                $idGudang       = session()->get('id_gudang');

                $data = [
                    'id_gudang' => $idGudang,
                    'id_pj'     => user()->id,
                    'nomor'     => $this->request->getPost('nomor'),
                    'tanggal'   => $this->request->getPost('tanggal'),
                ];

                $modelStok->insert($data);
                $idStok = $modelStok->insertID();

                $json = [
                    'success' => 'Berhasil menambah data stok opname',
                    'idStok'  => $idStok
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }
}
