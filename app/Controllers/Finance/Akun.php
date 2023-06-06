<?php

namespace App\Controllers\Finance;

use App\Models\Finance\AkunModel;
use App\Models\Finance\KategoriAkunModel;
use App\Models\Finance\JurnalModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class Akun extends ResourcePresenter
{

    public function index()
    {
        return view('finance/akun/listAkun/index');
    }


    public function getDataAkun()
    {
        if ($this->request->isAJAX()) {

            $db = \Config\Database::connect();
            $data =  $db->table('akun')
                ->select('akun.id, akun.kode, akun.nama, akun_kategori.nama as kategori')
                ->join('akun_kategori', 'akun.id_kategori = akun_kategori.id', 'left')
                ->where('akun.deleted_at', null);

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                    <button title="Saldo" onclick="showModalBukuBesar(' . $row->id . ')" title="bukuBesar" type="button" class="px-2 py-0 btn btn-sm btn-outline-success"><i class="fa-fw fa-solid fa-bars"></i></button>
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>

                    <a title="Edit" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="showModalEdit(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-pen"></i>
                    </a>

                    <form id="form_delete" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                    </form>';
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {

            $modelAkun = new AkunModel();
            $kategori  = $modelAkun->getAkun($id);
            $akun      = $modelAkun->find($id);

            $data = [
                'akun'      => $akun,
                'kategori'  => $kategori
            ];

            $json = [
                'data'   => view('finance/akun/listAkun/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load data';
        }
    }


    public function new()
    {
        if ($this->request->isAJAX()) {

            $modelAkun = new AkunModel();
            $akun = $modelAkun->findAll();

            $db = \Config\Database::connect();
            $builderAkunKategori = $db->table('akun_kategori');

            $data = [
                'akun'        => $akun,
                'kategori'    => $builderAkunKategori->get()->getResultArray(),
            ];

            $json = [
                'data'       => view('finance/akun/listAkun/add', $data),
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
                'kode'       => [
                    'rules'  => 'required|is_unique[akun.kode]',
                    'errors' => [
                        'required'  => '{field} akun harus diisi.',
                        'is_unique' => 'Kode akun sudah ada dalam database.'
                    ]
                ],
                'nama'       => [
                    'rules'  => 'required|is_unique[akun.nama]',
                    'errors' => [
                        'required'  => '{field} akun harus diisi.',
                        'is_unique' => 'Nama akun sudah ada dalam database.'
                    ]
                ],
                'id_kategori'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} deskripsi harus diisi.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_kode'   => $validation->getError('kode'),
                    'error_nama'   => $validation->getError('nama'),
                    'error_debit'  => $validation->getError('id_kategori')
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelAkun = new AkunModel();

                $db = \Config\Database::connect();
                $builderAkunKategori = $db->table('akun_kategori');

                if (strpos($this->request->getPost('id_kategori'), '-krisna-') !== false) {
                    $post_kategori = explode('-', $this->request->getPost('id_kategori'));
                    $the_id_kategori = $post_kategori[0];
                } else {
                    $builderAkunKategori->insert(['nama' => $this->request->getPost('id_kategori')]);
                    $the_id_kategori = $db->insertID();
                }

                $data = [
                    'kode'         => $this->request->getPost('kode'),
                    'nama'         => $this->request->getPost('nama'),
                    'id_kategori'  => $the_id_kategori
                ];
                $modelAkun->insert($data);

                $json = [
                    'success' => 'Berhasil menambah data Akun'
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
            $modelAkun      = new AkunModel();
            $modelKategori  = new KategoriAkunModel();
            $akun           = $modelAkun->find($id);
            $kategori       = $modelKategori->findAll();

            $data = [
                'validation'    => \Config\Services::validation(),
                'akun'          => $akun,
                'kategori'      => $kategori
            ];

            $json = [
                'data'   => view('finance/akun/listAkun/edit', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load data';
        }
    }


    public function update($id = null)
    {
        if ($this->request->isAJAX()) {

            $modelAkun = new AkunModel();
            $old_akun = $modelAkun->find($id);

            if ($old_akun['kode'] == $this->request->getPost('kode')) {
                $rule_kode = 'required';
            } else {
                $rule_kode = 'required|is_unique[akun.kode]';
            }

            $validasi = [
                'kode'       => [
                    'rules'  => $rule_kode,
                    'errors' => [
                        'required'  => '{field} akun harus diisi.',
                        'is_unique' => 'Kode akun sudah ada dalam database.',
                    ]
                ],
                'nama'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} akun harus diisi.',
                    ]
                ],
                'id_kategori'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => '{field} deskripsi harus diisi.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_kode'       => $validation->getError('kode'),
                    'error_nama'       => $validation->getError('nama'),
                    'error_debit'      => $validation->getError('id_kategori')
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelAkun = new AkunModel();

                $db = \Config\Database::connect();
                $builderAkunKategori = $db->table('akun_kategori');

                if (strpos($this->request->getPost('id_kategori'), '-krisna-') !== false) {
                    $post_kategori   = explode('-', $this->request->getPost('id_kategori'));
                    $the_id_kategori = $post_kategori[0];
                } else {
                    $builderAkunKategori->insert(['nama' => $this->request->getPost('id_kategori')]);
                    $the_id_kategori = $db->insertID();
                }

                $data = [
                    'id'           => $id,
                    'kode'         => $this->request->getPost('kode'),
                    'nama'         => $this->request->getPost('nama'),
                    'id_kategori'  => $the_id_kategori
                ];

                $modelAkun->save($data);

                $json = [
                    'success' => 'Berhasil menambah data produk'
                ];
            }

            echo json_encode($json);
        } else {
            return 'Tidak bisa load data';
        }
    }


    public function buku($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelAkun         = new AkunModel();
            $akun              = $modelAkun->find($id);

            $data = [
                'akun'      => $akun,
                'tglAwal'   => date('Y-01-01'),
                'tglAkhir'  => date('Y-m-d'),
            ];

            $json = [
                'data'   => view('finance/akun/listAkun/buku', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load data';
        }
    }


    public function getListBukuBesar()
    {
        $idAkun            = $this->request->getGet('idAkun');
        $tglAwal           = $this->request->getGet('tglAwal');
        $tglAkhir          = $this->request->getGet('tglAkhir');
        $tglSet            = date('Y-01-01');

        $modelJurnal       = new JurnalModel();
        $bukuAkun          = $modelJurnal->getAkunBuku($idAkun, $tglAwal, $tglAkhir);
        $saldoAwal         = $modelJurnal->getAkunBukuAwal($idAkun, $tglSet, $tglAwal);

        $data = [
            'bukuAkun'  => $bukuAkun,
            'saldoAwal' => $saldoAwal,
            'tglAwal'   => $tglAwal,
            'tglAkhir'  => $tglAkhir
        ];

        $json = [
            'data'   => view('finance/akun/listAkun/listBukuBesar', $data),
        ];

        echo json_encode($json);
    }


    public function delete($id = null)
    {
        $modelAkun = new AkunModel();

        $modelAkun->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/listakun');
    }
}
