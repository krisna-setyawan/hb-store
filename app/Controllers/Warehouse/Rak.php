<?php

namespace App\Controllers\Warehouse;

use App\Models\Warehouse\GudangModel;
use App\Models\Warehouse\RuanganModel;
use App\Models\Warehouse\RakModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class Rak extends ResourcePresenter
{
    protected $helpers = ['form', 'stok_helper'];


    public function rak($id_gudang)
    {
        $modelGudang = new GudangModel();

        $gudang = $modelGudang->getGudangWithAlamat($id_gudang);
        $data = [
            'id_gudang' => $id_gudang,
            'nama_gudang' => $gudang['nama']
        ];

        session()->set('id_gudang', $id_gudang);
        return view('warehouse/ruanganrak/rak/index', $data);
    }


    public function getDataRak()
    {
        if ($this->request->isAJAX()) {
            $idGudang     = session()->get('id_gudang');

            $db = \Config\Database::connect();
            $data =  $db->table('rak')
                ->select('rak.id, ruangan.nama as ruangan, rak.nama, rak.kode')
                ->join('ruangan', 'rak.id_ruangan = ruangan.id', 'left')
                ->where('rak.id_gudang', $idGudang);

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                    <a title="Edit" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="showModalEdit(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-pen"></i>
                    </a>

                    <form id="form_delete" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                    <button onclick="confirm_delete(' . $row->id . ')" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
                    ';
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        if ($this->request->isAJAX()) {
            $modelRak       = new RakModel();
            $rak            = $modelRak->findAll();
            $idGudang       = session()->get('id_gudang');

            $db = \Config\Database::connect();
            $builderRuangan = $db->table('ruangan');

            $data = [
                'rak'       => $rak,
                'ruangan'   => $builderRuangan->where('id_gudang', $idGudang)->get()->getResultArray(),
            ];

            $json = [
                'data'       => view('warehouse/ruanganrak/rak/add', $data),
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
                'idRuangan'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Ruangan rak harus diisi.',
                    ]
                ],
                'nama'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} rak harus diisi.',
                    ]
                ],
                'kodeRak'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'kode rak harus diisi.'
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_idRuangan'  => $validation->getError('idRuangan'),
                    'error_nama'       => $validation->getError('nama'),
                    'error_kode'       => $validation->getError('kodeRak'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelRak       = new RakModel();
                $idGudang     = session()->get('id_gudang');

                $data = [
                    'id_gudang'    => $idGudang,
                    'id_ruangan'   => $this->request->getPost('idRuangan'),
                    'nama'         => $this->request->getPost('nama'),
                    'kode'         => $this->request->getPost('kodeRak'),
                ];

                $modelRak->insert($data);

                $json = [
                    'success' => 'Berhasil menambah data rak'
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function edit($id = null)
    {
        if ($this->request->isAJAX()) {
            $idGudang     = session()->get('id_gudang');

            $modelRak       = new RakModel();
            $modelRuangan   = new RuanganModel();

            $rak            = $modelRak->find($id);
            $ruangan        = $modelRuangan->where('id_gudang', $idGudang)->findAll();

            $data = [
                'rak'      => $rak,
                'ruangan'  => $ruangan
            ];

            $json = [
                'data'   => view('warehouse/ruanganrak/rak/edit', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function update($id = null)
    {
        if ($this->request->isAJAX()) {
            $validasi = [
                'idRuangan'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Ruangan rak harus diisi.',
                    ]
                ],
                'nama'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} rak harus diisi.',
                    ]
                ],
                'kodeRak'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'kode rak harus diisi.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_idRuangan'  => $validation->getError('idRuangan'),
                    'error_nama'       => $validation->getError('nama'),
                    'error_kode'       => $validation->getError('kodeRak'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelRak   = new RakModel();

                $data = [
                    'id'           => $id,
                    'id_ruangan'   => $this->request->getPost('idRuangan'),
                    'nama'         => $this->request->getPost('nama'),
                    'kode'         => $this->request->getPost('kodeRak'),
                ];
                $modelRak->save($data);

                $json = [
                    'success' => 'Data Berhasil di update'
                ];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function delete($id = null)
    {
        $modelRak   = new RakModel();

        $modelRak->delete($id);

        $idGudang       = session()->get('id_gudang');

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/warehouse-rak/' . $idGudang);
    }
}
