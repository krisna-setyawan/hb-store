<?php

namespace App\Controllers\Finance;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Finance\JurnalModel;
use App\Models\Finance\JurnalDetailModel;
use App\Models\Finance\AkunModel;
use \Hermawan\DataTables\DataTable;

class Jurnal extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];

    function __construct()
    {
        $this->db                = \Config\Database::connect();
        $this->modelJurnal       = new JurnalModel();
        $this->modelJurnalDetail = new JurnalDetailModel();
    }


    public function index()
    {
        return view('finance/akun/jurnal/index');
    }


    public function getDataJurnal()
    {
        if ($this->request->isAJAX()) {

            $modelJurnal = new JurnalModel();
            $data = $modelJurnal->select('id, nomor_transaksi, referensi, tanggal, total_transaksi')->where('deleted_at', null);

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    if (strpos($row->nomor_transaksi, "JRN/TGH") !== false) {
                        return '
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>

                    <form id="form_delete" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                    <button onclick="confirm_delete(' . $row->id . ')" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
                    ';
                    } else {
                        return '
                    <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                    </a>

                    <a title="Edit" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . site_url() . 'jurnal/' . $row->id . '/edit">
                        <i class="fa-fw fa-solid fa-pen"></i>
                    </a>

                    <form id="form_delete" method="POST" class="d-inline">
                        ' . csrf_field() . '
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                    <button onclick="confirm_delete(' . $row->id . ')" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
                    ';
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

            $modelAkun         = new AkunModel();
            $modelJurnal       = new JurnalModel();
            $modelJurnalDetail = new JurnalDetailModel();
            $transaksi         = $modelJurnal->find($id);
            $akun              = $modelAkun->findAll();
            $detail            = $modelJurnalDetail->getDetailJurnal(['id_transaksi' => $transaksi['id']]);

            $data = [
                'akun'          => $akun,
                'detail'        => $detail,
                'transaksi'     => $transaksi,
            ];


            $json = [
                'data'   => view('finance/akun/jurnal/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load data';
        }
    }


    public function new()
    {
        date_default_timezone_set('Asia/Jakarta');
        $modelAkun         = new AkunModel();

        $akun = $modelAkun->findAll();

        $data = [
            'akun'               => $akun,
            'nomor_jurnal_auto'  => jurnal_nomor_auto(date('Y-m-d'))
        ];

        return view('finance/akun/jurnal/add', $data);
    }


    public function create()
    {
        $validasi = [
            'nomor_transaksi' => [
                'rules'  => 'required|is_unique[transaksi_jurnal.nomor_transaksi]',
                'errors' => [
                    'required'  => 'nomor harus diisi.',
                    'is_unique' => 'Nomor sudah ada dalam database. Refresh dan ulangi',
                ]
            ],
            'tanggal'  => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'tanggal harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            $validation = \Config\Services::validation();

            $error = [
                'error_nomor'   => $validation->getError('nomor_transaksi'),
                'error_tanggal' => $validation->getError('tanggal'),
            ];

            $json = [
                'error' => $error
            ];
        } else {
            $modelJurnal       = new JurnalModel();
            $modelJurnalDetail = new JurnalDetailModel();

            $data = [
                'nomor_transaksi'   => $this->request->getPost('nomor_transaksi'),
                'tanggal'           => $this->request->getPost('tanggal'),
                'referensi'         => $this->request->getPost('referensi'),
                'total_transaksi'   => $this->request->getPost('total_transaksi')
            ];
            $modelJurnal->insert($data);

            $id_transaksi = $this->modelJurnal->insertID();
            $id_akun      = $this->request->getPost('id_akun');
            $deskripsi    = $this->request->getPost('deskripsi');
            $debit        = $this->request->getPost('debit');
            $kredit       = $this->request->getPost('kredit');

            for ($i = 0; $i < count($id_akun); $i++) {
                $modelAkun = new AkunModel();
                $akun = $modelAkun->find($id_akun[$i]);

                if ($id_akun[$i] != 0) {
                    $dataAkun = [
                        'id_transaksi'  => $id_transaksi,
                        'id_akun'       => $akun['id'],
                        'deskripsi'     => $deskripsi[$i],
                        'debit'         => $debit[$i],
                        'kredit'        => $kredit[$i]
                    ];

                    $modelJurnalDetail->insert($dataAkun);
                }
            }

            $json = [
                'success' => 'Berhasil menambah data jurnal'
            ];
        }
        echo json_encode($json);
    }


    public function akun()
    {
        $modelAkun  = new AkunModel();
        $akun       = $modelAkun->findAll();

        return $this->response->setJSON($akun);
    }


    public function edit($id = null)
    {
        $modelAkun         = new AkunModel();
        $modelJurnal       = new JurnalModel();
        $modelJurnalDetail = new JurnalDetailModel();
        $transaksi         = $modelJurnal->find($id);
        $detail            = $modelJurnalDetail->where(['id_transaksi' => $transaksi['id']])->findAll();
        $akun              = $modelAkun->findAll();


        $data = [
            'validation'    => \Config\Services::validation(),
            'akun'          => $akun,
            'detail'        => $detail,
            'transaksi'     => $transaksi,
        ];

        return view('finance/akun/jurnal/edit', $data);
    }


    public function update($id = null)
    {
        $validasi = [
            'nomor_transaksi' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => '{field} harus diisi.',
                ]
            ],
            'tanggal'  => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => '{field} harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            $validation = \Config\Services::validation();

            $error = [
                'error_nomor'   => $validation->getError('nomor_transaksi'),
                'error_tanggal' => $validation->getError('tanggal'),
            ];

            $json = [
                'error' => $error
            ];
        } else {
            $modelJurnal       = new JurnalModel();
            $modelJurnalDetail = new JurnalDetailModel();

            $data = [
                'id'                => $id,
                'nomor_transaksi'   => $this->request->getPost('nomor_transaksi'),
                'tanggal'           => $this->request->getPost('tanggal'),
                'referensi'         => $this->request->getPost('referensi'),
                'total_transaksi'   => $this->request->getPost('total_transaksi')
            ];
            $modelJurnal->save($data);

            $id_detail    = $this->request->getPost('id_detail');
            $modelJurnalDetail->where(['id_transaksi' => $id])->delete($id_detail);

            $id_akun      = $this->request->getPost('id_akun');
            $deskripsi    = $this->request->getPost('deskripsi');
            $debit        = $this->request->getPost('debit');
            $kredit       = $this->request->getPost('kredit');

            for ($i = 0; $i < count($id_akun); $i++) {
                $dataAkun = [
                    'id_transaksi'  => $id,
                    'id_akun'       => $id_akun[$i],
                    'deskripsi'     => $deskripsi[$i],
                    'debit'         => $debit[$i],
                    'kredit'        => $kredit[$i]
                ];
                $modelJurnalDetail->insert($dataAkun);
            }

            $json = [
                'success' => 'Berhasil update data Jurnal'
            ];
        }
        echo json_encode($json);
    }


    public function hapusBaris($id = null)
    {
        $modelJurnalDetail  = new JurnalDetailModel();

        $modelJurnalDetail->delete($id);

        return redirect()->back();
    }


    public function delete($id = null)
    {
        $modelJurnal        = new JurnalModel();

        $modelJurnal->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/jurnal');
    }
}
