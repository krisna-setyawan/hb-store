<?php

namespace App\Controllers\Resource;

use App\Models\Resource\GudangModel;
use App\Models\Resource\GudangPJModel;
use App\Models\Resource\KecamatanModel;
use App\Models\Resource\KelurahanModel;
use App\Models\Resource\KotaModel;
use App\Models\Resource\ProvinsiModel;
use App\Models\Resource\UserModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Gudang extends ResourcePresenter
{
    protected $helpers = ['form'];


    public function index()
    {
        $modelGudang = new GudangModel();
        $gudang = $modelGudang->getGudang();

        $data = [
            'gudang' => $gudang
        ];

        return view('resource/gudang/index', $data);
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelGudang = new GudangModel();
            $modelGudangPJ = new GudangPJModel();

            $data = [
                'gudang'  => $modelGudang->getGudangWithAlamat($id),
                'pj'        => $modelGudangPJ->getPJByGudang($id),
            ];

            $json = [
                'data' => view('resource/gudang/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function new()
    {
        $modelProvinsi = new ProvinsiModel();
        $data = [
            'validation'        => \Config\Services::validation(),
            'provinsi'          => $modelProvinsi->orderBy('nama')->findAll(),
        ];
        return view('resource/gudang/add', $data);
    }


    public function create()
    {
        $validasi = [
            'nama' => [
                'rules' => 'required|is_unique[gudang.nama]',
                'errors' => [
                    'required' => '{field} gudang harus diisi.',
                    'is_unique' => 'nama gudang sudah ada dalam database.'
                ]
            ],
            // 'id_provinsi' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'provinsi gudang harus diisi.',
            //     ]
            // ],
            // 'id_kota' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'kota gudang harus diisi.',
            //     ]
            // ],
            // 'id_kecamatan' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'kecamatan gudang harus diisi.',
            //     ]
            // ],
            // 'id_kelurahan' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'kelurahan gudang harus diisi.',
            //     ]
            // ],
            'detail_alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'detail alamat gudang harus diisi.',
                ]
            ],
            'no_telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No telepon gudang harus diisi.',
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} gudang harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            return redirect()->to('/resource-gudang/new')->withInput();
        }

        $modelGudang = new GudangModel();

        $data = [
            'nama'          => $this->request->getPost('nama'),
            'id_provinsi'   => $this->request->getPost('id_provinsi'),
            'id_kota'       => $this->request->getPost('id_kota'),
            'id_kecamatan'  => $this->request->getPost('id_kecamatan'),
            'id_kelurahan'  => $this->request->getPost('id_kelurahan'),
            'detail_alamat' => $this->request->getPost('detail_alamat'),
            'no_telp'       => $this->request->getPost('no_telp'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ];
        $modelGudang->save($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/resource-gudang');
    }


    public function edit($id = null)
    {
        $modelGudang = new GudangModel();
        $modelGudangPJ = new GudangPJModel();
        $modelProvinsi = new ProvinsiModel();
        $modelKota = new KotaModel();
        $modelKecamatan = new KecamatanModel();
        $modelKelurahan = new KelurahanModel();
        $modelUser = new UserModel();

        $gudang = $modelGudang->find($id);

        $pj = $modelGudangPJ->getPJByGudang($id);
        if ($pj) {
            $users = $modelUser->getUserPJWithKaryawanName(array_column($pj, 'id_user'));
        } else {
            $users = $modelUser->getAllUserWithKaryawanName();
        }

        $data = [
            'validation'        => \Config\Services::validation(),
            'gudang'            => $gudang,
            'pj'                => $pj,
            'provinsi'          => $modelProvinsi->orderBy('nama')->findAll(),
            'kota'              => $modelKota->where(['id_provinsi' => $gudang['id_provinsi']])->findAll(),
            'kecamatan'         => $modelKecamatan->where(['id_kota' => $gudang['id_kota']])->findAll(),
            'kelurahan'         => $modelKelurahan->where(['id_kecamatan' => $gudang['id_kecamatan']])->findAll(),
            'users'             => $users
        ];

        return view('resource/gudang/edit', $data);
    }


    public function update($id = null)
    {
        $modelGudang = new GudangModel();
        $old_gudang = $modelGudang->find($id);

        if ($old_gudang['nama'] == $this->request->getPost('nama')) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[gudang.nama]';
        }

        $validasi = [
            'nama' => [
                'rules' => $rule_nama,
                'errors' => [
                    'required' => '{field} gudang harus diisi.',
                    'is_unique' => 'nama gudang sudah ada dalam database.'
                ]
            ],
            // 'id_provinsi' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'provinsi gudang harus diisi.',
            //     ]
            // ],
            // 'id_kota' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'kota gudang harus diisi.',
            //     ]
            // ],
            // 'id_kecamatan' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'kecamatan gudang harus diisi.',
            //     ]
            // ],
            // 'id_kelurahan' => [
            //     'rules' => 'required',
            //     'errors' => [
            //         'required' => 'kelurahan gudang harus diisi.',
            //     ]
            // ],
            'detail_alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'detail alamat gudang harus diisi.',
                ]
            ],
            'no_telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No telepon gudang harus diisi.',
                ]
            ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} gudang harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            return redirect()->to('/resource-gudang/' . $old_gudang["id"] . '/edit')->withInput();
        }

        $data = [
            'id'            => $id,
            'nama'          => $this->request->getPost('nama'),
            'id_provinsi'   => $this->request->getPost('id_provinsi'),
            'id_kota'       => $this->request->getPost('id_kota'),
            'id_kecamatan'  => $this->request->getPost('id_kecamatan'),
            'id_kelurahan'  => $this->request->getPost('id_kelurahan'),
            'detail_alamat' => $this->request->getPost('detail_alamat'),
            'no_telp'       => $this->request->getPost('no_telp'),
            'keterangan'    => $this->request->getPost('keterangan'),
        ];
        $modelGudang->save($data);

        session()->setFlashdata('pesan', 'Data berhasil diedit.');

        return redirect()->to('/resource-gudang');
    }


    public function remove($id = null)
    {
        //
    }


    public function delete($id = null)
    {
        $modelGudang = new GudangModel();

        $modelGudang->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/resource-gudang');
    }
}
