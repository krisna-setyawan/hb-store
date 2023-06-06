<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\KaryawanModel;
use App\Models\Hrm\PelanggaranModel;
use CodeIgniter\RESTful\ResourceController;

class Pelanggaran extends ResourceController
{
    public function index()
    {
        $modelPelanggaran = new PelanggaranModel();
        $pelanggaran = $modelPelanggaran->findAll();

        $data = [
            'pelanggaran' => $pelanggaran
        ];

        return view('hrm/pelanggaran/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        if ($this->request->isAJAX()) {
            $modelPelanggaran = new PelanggaranModel();
            $pelanggaran = $modelPelanggaran->findAll();

            $data = [
                'pelanggaran' => $pelanggaran,
            ];

            $json = [
                'data' => view('hrm/pelanggaran/add', $data)
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
                'nama_pelanggaran'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Deskripsi Pelanggaran harus diisi.',
                    ]
                ],
                'range_point'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Point pelanggaran harus diisi.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nama_pelanggaran'       => $validation->getError('nama_pelanggaran'),
                    'error_range_point'  => $validation->getError('range_point')
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelPelanggaran = new PelanggaranModel();

                $data = [
                    'nama_pelanggaran'         => $this->request->getPost('nama_pelanggaran'),
                    'range_point'    => $this->request->getPost('range_point'),
                ];
                $modelPelanggaran->insert($data);

                $json = [
                    'success' => 'Berhasil menambah data pelanggaran'
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
            $modelPelanggaran = new PelanggaranModel();
            $pelanggaran      = $modelPelanggaran->find($id);

            $data = [
                'validation'    => \Config\Services::validation(),
                'pelanggaran'        => $pelanggaran
            ];

            $json = [
                'data' => view('hrm/pelanggaran/edit', $data)
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
                'nama_pelanggaran'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Deskripsi Pelanggaran harus diisi.',
                    ]
                ],
                'range_point'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Point pelanggaran harus diisi.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nama_pelanggaran' => $validation->getError('nama_pelanggaran'),
                    'error_range_point'     => $validation->getError('range_point')
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelPelanggaran = new PelanggaranModel();
                $data = [
                    'id' => $id,
                    'nama_pelanggaran'  => $this->request->getPost('nama_pelanggaran'),
                    'range_point'       => $this->request->getPost('range_point'),
                ];
                $modelPelanggaran->save($data);

                $json = [
                    'success' => 'Berhasil update data pelanggaran'
                ];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function delete($id = null)
    {
        $modelPelanggaran = new PelanggaranModel();
        $modelPelanggaran->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->back();
    }

    public function ViewKaryawan()
    {
        $modelKaryawan = new KaryawanModel();
        $karyawan = $modelKaryawan->findAll();

        $data = [
            'karyawan' => $karyawan
        ];

        return view('hrm/pelanggaran/karyawan_pelanggaran/index', $data);
    }

    public function ViewMenu()
    {
        return view('hrm/pelanggaran/menu');
    }
}
