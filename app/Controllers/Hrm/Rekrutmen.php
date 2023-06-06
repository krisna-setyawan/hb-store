<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\CalonKaryawanModel;
use CodeIgniter\RESTful\ResourceController;

class Rekrutmen extends ResourceController
{

    public function index()
    {
        $modelCalonKaryawan = new CalonKaryawanModel();
        $calonkaryawan = $modelCalonKaryawan->findAll();

        $data = [
            'karyawan' => $calonkaryawan
        ];

        return view('hrm/rekrutmen/index', $data);
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelCalonKaryawan = new CalonKaryawanModel();
            $calonkaryawan = $modelCalonKaryawan->find($id);

            $data = [
                'karyawan' => $calonkaryawan,
            ];
            $json = [
                'data' => view('hrm/rekrutmen/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function new()
    {
        if ($this->request->isAJAX()) {

            $modelCalonKaryawan = new CalonKaryawanModel();
            $calonkaryawan = $modelCalonKaryawan->findAll();

            $data = [
                'karyawan'        => $calonkaryawan,
            ];

            $json = [
                'data'          => view('hrm/rekrutmen/add', $data),
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
                'nama'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'nama lengkap harus diisi',
                    ]
                ],
                'no_telp' => [
                    'rules'  => 'required|min_length[11]|numeric',
                    'errors' => [
                        'required'    => 'No telepon harus diisi dan minimal 11 angka',
                        'min_length'  => 'Minimal harus 11 angka',
                        'numeric'     => 'No telepon hanya boleh diisi dengan angka 0-9'
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nama' => $validation->getError('nama'),
                    'error_no_telp' => $validation->getError('no_telp'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelCalonKaryawan = new CalonKaryawanModel();

                $data = [
                    'nik' => $this->request->getPost('nik'),
                    'nama' => $this->request->getPost('nama'),
                    'alamat' => $this->request->getPost('alamat'),
                    'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                    'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                    'agama' => $this->request->getPost('agama'),
                    'pendidikan' => $this->request->getPost('pendidikan'),
                    'no_telp' => $this->request->getPost('no_telp'),
                    'email' => $this->request->getPost('email'),
                ];
                $modelCalonKaryawan->save($data);
                $json = [
                    'success' => 'Berhasil menambah data karyawan'
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
            $modelCalonKaryawan = new CalonKaryawanModel();
            $karyawan      = $modelCalonKaryawan->find($id);

            $data = [
                'karyawan' => $karyawan,
            ];
            $json = [
                'data' => view('hrm/rekrutmen/edit', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function update($id = null)
    {
        $validasi = [
            'nama'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'nama lengkap harus diisi',
                ]
            ],
            'no_telp' => [
                'rules'  => 'required|min_length[11]|numeric',
                'errors' => [
                    'required'    => 'No telepon harus diisi dan minimal 11 angka',
                    'min_length'  => 'Minimal harus 11 angka',
                    'numeric'     => 'No telepon hanya boleh diisi dengan angka 0-9'
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            $validation = \Config\Services::validation();

            $error = [
                'error_nama' => $validation->getError('nama'),
                'error_no_telp' => $validation->getError('no_telp'),
                'error_email' => $validation->getError('email'),
            ];

            $json = [
                'error' => $error
            ];
        } else {
            $modelCalonKaryawan = new CalonKaryawanModel();

            $data = [
                'id' => $id,
                'nik' => $this->request->getPost('nik'),
                'nama' => $this->request->getPost('nama'),
                'alamat' => $this->request->getPost('alamat'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'agama' => $this->request->getPost('agama'),
                'pendidikan' => $this->request->getPost('pendidikan'),
                'no_telp' => $this->request->getPost('no_telp'),
                'email' => $this->request->getPost('email'),
            ];
            $modelCalonKaryawan->save($data);

            $json = [
                'success' => 'Berhasil Update data karyawan'
            ];
        }
        echo json_encode($json);
    }


    public function delete($id = null)
    {
        $modelCalonKaryawan = new CalonKaryawanModel();


        $modelCalonKaryawan->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->back();
    }
}
