<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\KaryawanModel;
use App\Models\Hrm\UserModel;
use CodeIgniter\RESTful\ResourceController;
use \Hermawan\DataTables\DataTable;
use Myth\Auth\Password;

class Karyawan extends ResourceController
{
    protected $helpers = ['form'];


    public function index()
    {
        $modelKaryawan = new KaryawanModel();
        $karyawan = $modelKaryawan->findAll();

        $data = [
            'karyawan' => $karyawan
        ];

        return view('hrm/karyawan/index', $data);
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelKaryawan = new KaryawanModel();
            $karyawan      = $modelKaryawan->find($id);

            $data = [
                'karyawan' => $karyawan,
            ];
            $json = [
                'data' => view('hrm/karyawan/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function new()
    {
        if ($this->request->isAJAX()) {

            $modelKaryawan = new KaryawanModel();
            $karyawan = $modelKaryawan->findAll();

            $data = [
                'karyawan'        => $karyawan,
            ];

            $json = [
                'data'          => view('hrm/karyawan/add', $data),
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
                'nik'  => [
                    'rules'     => 'required|is_unique[karyawan.nik]|exact_length[16]',
                    'errors'    => [
                        'required' => 'nik harus diisi dan sesuai aturan 16 angka',
                        'exact_length' => 'harus sesuai aturan 16 angka'
                    ]
                ],
                'jabatan'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'jabatan harus diisi',
                    ]
                ],
                'nama_lengkap'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'nama lengkap harus diisi',
                    ]
                ],
                'alamat'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'alamat harus diisi',
                    ]
                ],
                'jenis_kelamin'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'jenis kelamin harus diisi',
                    ]
                ],
                'tempat_lahir'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'tempat lahir harus diisi',
                    ]
                ],
                'tanggal_lahir'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'tanggal lahir harus diisi',
                    ]
                ],
                'agama'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'agama harus diisi',
                    ]
                ],
                'pendidikan'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'pendidikan harus diisi',
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
                'email'  => [
                    'rules'     => 'required|valid_email|is_unique[karyawan.email]',
                    'errors'    => [
                        'required' => 'email harus diisi',
                        'valid_email' => 'Email Harus Valid',
                        'is_unique' => 'Email tidak boleh sama',
                    ]
                ],
                'username'  => [
                    'rules'     => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username]',
                    'errors'    => [
                        'required' => 'username harus diisi',
                    ]
                ],
                'password'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'password harus diisi',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_nik' => $validation->getError('nik'),
                    'error_nama_lengkap' => $validation->getError('nama_lengkap'),
                    'error_jabatan' => $validation->getError('jabatan'),
                    'error_alamat' => $validation->getError('alamat'),
                    'error_jenis_kelamin' => $validation->getError('jenis_kelamin'),
                    'error_tempat_lahir' => $validation->getError('tempat_lahir'),
                    'error_tanggal_lahir' => $validation->getError('tanggal_lahir'),
                    'error_agama' => $validation->getError('agama'),
                    'error_pendidikan' => $validation->getError('pendidikan'),
                    'error_no_telp' => $validation->getError('no_telp'),
                    'error_email' => $validation->getError('email'),
                    'error_username' => $validation->getError('username'),
                    'error_password' => $validation->getError('password'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelKaryawan = new KaryawanModel();
                $modelUser = new UserModel();

                $data1 = [
                    'id_grup' => null,
                    'id_divisi' => null,
                    'nik' => $this->request->getPost('nik'),
                    'jabatan' => $this->request->getPost('jabatan'),
                    'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                    'alamat' => $this->request->getPost('alamat'),
                    'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                    'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                    'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                    'agama' => $this->request->getPost('agama'),
                    'pendidikan' => $this->request->getPost('pendidikan'),
                    'no_telp' => $this->request->getPost('no_telp'),
                    'email' => $this->request->getPost('email'),
                ];
                $modelKaryawan->save($data1);


                $data2 = [
                    'id_karyawan' => $modelKaryawan->getInsertID(),
                    'name' => $this->request->getPost('nama_lengkap'),
                    'email' => $this->request->getPost('email'),
                    'username' => $this->request->getPost('username'),
                    'password_hash' => Password::hash($this->request->getPost('password'),),
                    'active' => 1
                ];
                $modelUser->save($data2);
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
            $modelKaryawan = new KaryawanModel();
            $karyawan      = $modelKaryawan->find($id);

            $data = [
                'karyawan' => $karyawan,
            ];
            $json = [
                'data' => view('hrm/karyawan/edit', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function update($id = null)
    {

        $validasi = [
            'nik'  => [
                'rules'     => 'required|exact_length[16]',
                'errors'    => [
                    'required' => 'nik harus diisi dan sesuai aturan 16 angka',
                    'exact_length' => 'harus sesuai aturan 16 angka',
                ]
            ],
            'jabatan'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'jabatan harus diisi',
                ]
            ],
            'nama_lengkap'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'nama lengkap harus diisi',
                ]
            ],
            'alamat'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'alamat harus diisi',
                ]
            ],
            'jenis_kelamin'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'jenis kelamin harus diisi',
                ]
            ],
            'tempat_lahir'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'tempat lahir harus diisi',
                ]
            ],
            'tanggal_lahir'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'tanggal lahir harus diisi',
                ]
            ],
            'agama'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'agama harus diisi',
                ]
            ],
            'pendidikan'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'pendidikan harus diisi',
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
            'email'  => [
                'rules'     => 'required|valid_email|is_unique[karyawan.email]',
                'errors'    => [
                    'required' => 'email harus diisi',
                    'valid_email' => 'Email Harus Valid',
                    'is_unique' => 'Email tidak boleh sama',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            $validation = \Config\Services::validation();

            $error = [
                'error_nik' => $validation->getError('nik'),
                'error_jabatan' => $validation->getError('jabatan'),
                'error_nama_lengkap' => $validation->getError('nama_lengkap'),
                'error_alamat' => $validation->getError('alamat'),
                'error_jenis_kelamin' => $validation->getError('jenis_kelamin'),
                'error_tempat_lahir' => $validation->getError('tempat_lahir'),
                'error_tanggal_lahir' => $validation->getError('tanggal_lahir'),
                'error_agama' => $validation->getError('agama'),
                'error_pendidikan' => $validation->getError('pendidikan'),
                'error_no_telp' => $validation->getError('no_telp'),
                'error_email' => $validation->getError('email'),
            ];

            $json = [
                'error' => $error
            ];
        } else {
            $modelKaryawan = new KaryawanModel();

            $data = [
                'id' => $id,
                'nik' => $this->request->getPost('nik'),
                'jabatan' => $this->request->getPost('jabatan'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'alamat' => $this->request->getPost('alamat'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'tempat_lahir' => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'agama' => $this->request->getPost('agama'),
                'pendidikan' => $this->request->getPost('pendidikan'),
                'no_telp' => $this->request->getPost('no_telp'),
                'email' => $this->request->getPost('email'),
            ];
            $modelKaryawan->save($data);

            $json = [
                'success' => 'Berhasil Update data karyawan'
            ];
        }
        echo json_encode($json);
    }


    public function redirect($kode)
    {
        if ($kode == 'add') {
            session()->setFlashdata('pesan', 'Berhasil menambah data Karyawan.');
        } else {
            session()->setFlashdata('pesan', 'Berhasil mengedit data Karyawan.');
        }
        return redirect()->to('/hrm-karyawan');
    }


    public function delete($id = null)
    {
        $modelKaryawan = new KaryawanModel();
        $modelUser = new UserModel();

        $modelKaryawan->delete($id);
        $modelUser->where(['id_karyawan' => $id])->delete();

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/hrm-karyawan');
    }
}
