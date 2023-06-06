<?php

namespace App\Controllers\Finance;

use App\Models\Finance\KategoriAkunModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class KategoriAkun extends ResourcePresenter
{

    public function index()
    {
        return view('finance/akun/kategori/index');
    }

    public function getDataKategori()
    {
        if ($this->request->isAJAX()) {

            $modelKategori = new KategoriAkunModel();
            $data = $modelKategori->where(['deleted_at' => null])->select('id, nama, deskripsi, debit, kredit');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>

                    <a title="Edit" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="showModalEdit(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-pen"></i>
                    </a>';
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelKategori = new KategoriAkunModel();
            $kategori      = $modelKategori->find($id);

            $data = [
                'kategori' => $kategori
            ];

            $json = [
                'data'   => view('finance/akun/kategori/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load data';
        }
    }


    public function new()
    {
        if ($this->request->isAJAX()) {
            $modelKategori = new KategoriAkunModel();
            $kategori      = $modelKategori->findAll();

            $data = [
                'kategori' => $kategori
            ];

            $json = [
                'data'   => view('finance/akun/kategori/add', $data),
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
                'nama'       => [
                    'rules'  => 'required|is_unique[akun_kategori.nama]',
                    'errors' => [
                        'required'  => '{field} kategori harus diisi.',
                        'is_unique' => 'nama kategori sudah ada dalam database.'
                    ]
                ],
                'deskripsi'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi.'
                    ]
                ],
                'debit'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi.',
                    ]
                ],
                'kredit'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nama'       => $validation->getError('nama'),
                    'error_deskripsi'  => $validation->getError('deskripsi'),
                    'error_debit'      => $validation->getError('debit'),
                    'error_kredit'     => $validation->getError('kredit')
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelKategori = new KategoriAkunModel();

                $data = [
                    'nama'         => $this->request->getPost('nama'),
                    'deskripsi'    => $this->request->getPost('deskripsi'),
                    'debit'        => $this->request->getPost('debit'),
                    'kredit'       => $this->request->getPost('kredit')
                ];

                $modelKategori->insert($data);

                $json = [
                    'success' => 'Berhasil menambah data kategori'
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
            $modelKategori = new KategoriAkunModel();
            $kategori      = $modelKategori->find($id);

            $data = [
                'validation'    => \Config\Services::validation(),
                'kategori'      => $kategori
            ];

            $json = [
                'data'   => view('finance/akun/kategori/edit', $data),
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
                'nama'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} kategori harus diisi.',
                    ]
                ],
                'deskripsi'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi.',
                    ]
                ],
                'debit'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi.',
                    ]
                ],
                'kredit'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} harus diisi.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nama'       => $validation->getError('nama'),
                    'error_deskripsi'  => $validation->getError('deskripsi'),
                    'error_debit'      => $validation->getError('debit'),
                    'error_kredit'     => $validation->getError('kredit'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelKategori = new KategoriAkunModel();

                $data = [
                    'id'           => $id,
                    'nama'         => $this->request->getPost('nama'),
                    'deskripsi'    => $this->request->getPost('deskripsi'),
                    'debit'        => $this->request->getPost('debit'),
                    'kredit'       => $this->request->getPost('kredit')
                ];
                $modelKategori->save($data);

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
        $modelKategori = new KategoriAkunModel();

        $modelKategori->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/finance-kategoriakun');
    }
}
