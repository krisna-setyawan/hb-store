<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\DivisiModel;
use App\Models\Hrm\KaryawanModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Divisi extends ResourcePresenter
{
    public function index()
    {
        $modelDivisi = new DivisiModel();
        $divisi      = $modelDivisi->findall();

        $data = [
            'divisi' => $divisi
        ];

        return view('hrm/divisi/index', $data);
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelDivisi = new DivisiModel();
            $divisi      = $modelDivisi->find($id);

            $data = [
                'divisi' => $divisi,
            ];

            $json = [
                'data'   => view('hrm/divisi/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load data';
        }
    }


    public function new()
    {
        if ($this->request->isAJAX()) {
            $modelDivisi = new DivisiModel();
            $divisi = $modelDivisi->findAll();

            $data = [
                'divisi' => $divisi
            ];

            $json = [
                'data'   => view('hrm/divisi/add', $data),
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
                    'rules'  => 'required|is_unique[divisi.nama]',
                    'errors' => [
                        'required'  => '{field} nama divisi harus diisi.',
                        'is_unique' => 'nama divisi sudah ada dalam database.'
                    ]
                ],
                'deskripsi'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} deskripsi harus diisi.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nama'       => $validation->getError('nama'),
                    'error_deskripsi'  => $validation->getError('deskripsi')
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelDivisi = new DivisiModel();

                $data = [
                    'nama'         => $this->request->getPost('nama'),
                    'deskripsi'    => $this->request->getPost('deskripsi'),
                ];
                $modelDivisi->insert($data);

                $json = [
                    'success' => 'Berhasil menambah data produk'
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
            $modelDivisi = new DivisiModel();
            $divisi      = $modelDivisi->find($id);

            $data = [
                'validation'    => \Config\Services::validation(),
                'divisi'        => $divisi
            ];

            $json = [
                'data'   => view('hrm/divisi/edit', $data),
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
                        'required'  => 'nama divisi harus diisi.',
                    ]
                ],
                'deskripsi'  => [
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
                    'error_deskripsi'  => $validation->getError('deskripsi')
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelDivisi = new DivisiModel();
                $divisi      = $modelDivisi->find($id);

                $data = [
                    'id'           => $divisi,
                    'nama'         => $this->request->getPost('nama'),
                    'deskripsi'    => $this->request->getPost('deskripsi'),
                ];
                $modelDivisi->save($data);

                $json = [
                    'success' => 'Berhasil menambah data produk'
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function redirect($kode)
    {
        if ($kode == 'add') {
            session()->setFlashdata('pesan', 'Berhasil menambah data Divisi.');
        } else {
            session()->setFlashdata('pesan', 'Berhasil mengedit data Divisi.');
        }
        return redirect()->to('/hrm-divisi');
    }


    public function delete($id = null)
    {
        $modelDivisi = new DivisiModel();

        $modelDivisi->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/hrm-divisi');
    }
}
