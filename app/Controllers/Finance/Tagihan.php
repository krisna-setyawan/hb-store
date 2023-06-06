<?php

namespace App\Controllers\Finance;

use App\Models\Finance\AkunModel;
use App\Models\Finance\JurnalDetailModel;
use App\Models\Finance\JurnalModel;
use App\Models\Finance\PembelianModel;
use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Finance\TagihanModel;
use App\Models\Finance\TagihanPembayaranModel;
use App\Models\Finance\TagihanRincianModel;
use \Hermawan\DataTables\DataTable;

class Tagihan extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];

    public function index()
    {
        $modelTagihan = new TagihanModel();
        $rupiah_last30 = $modelTagihan
            ->select('sum(jumlah) as rupiah_last30')
            ->where('deleted_at', null)
            ->where('tanggal >=', date('Y-m-d', strtotime('-30 days')))
            ->get()->getRowArray();
        $jumlah_last30 = $modelTagihan
            ->select('count(id) as jumlah_last30')
            ->where('deleted_at', null)
            ->where('tanggal >=', date('Y-m-d', strtotime('-30 days')))
            ->get()->getRowArray();
        $rupiah_bulan_ini = $modelTagihan
            ->select('sum(jumlah) as rupiah_bulan_ini')
            ->where('deleted_at', null)
            ->where('MONTH(tanggal)', date('m'))
            ->where('YEAR(tanggal)', date('Y'))
            ->get()->getRowArray();
        $jumlah_bulan_ini = $modelTagihan
            ->select('count(id) as jumlah_bulan_ini')
            ->where('deleted_at', null)
            ->where('MONTH(tanggal)', date('m'))
            ->where('YEAR(tanggal)', date('Y'))
            ->get()->getRowArray();
        $rupiah_belum_dibayar = $modelTagihan
            ->select('sum(jumlah) as rupiah_belum_dibayar')
            ->where('deleted_at', null)
            ->where('status', 'Belum dibayar')
            ->get()->getRowArray();
        $jumlah_belum_dibayar = $modelTagihan
            ->select('count(id) as jumlah_belum_dibayar')
            ->where('deleted_at', null)
            ->where('status', 'Belum dibayar')
            ->get()->getRowArray();

        $data = [
            'rupiah_last30' => $rupiah_last30['rupiah_last30'],
            'jumlah_last30' => $jumlah_last30['jumlah_last30'],
            'rupiah_bulan_ini' => $rupiah_bulan_ini['rupiah_bulan_ini'],
            'jumlah_bulan_ini' => $jumlah_bulan_ini['jumlah_bulan_ini'],
            'rupiah_belum_dibayar' => $rupiah_belum_dibayar['rupiah_belum_dibayar'],
            'jumlah_belum_dibayar' => $jumlah_belum_dibayar['jumlah_belum_dibayar'],
        ];


        return view('finance/tagihan/index', $data);
    }


    public function getDataTagihan()
    {
        if ($this->request->isAJAX()) {

            $modelTagihan = new TagihanModel();
            $data = $modelTagihan->select('id, no_tagihan, id_pembelian, tanggal, status, jumlah, sisa_tagihan')->where('deleted_at', null);

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    if ($row->status != 'Lunas') {
                        if ($row->id_pembelian == null) {
                            return '
                                <a title="Detail Tagihan" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                                    <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                                </a>
                                <a title="Buat Pembayaran" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . site_url() . 'finance-tagihan/' . $row->id . '/bayar">
                                    <i class="fa-fw fa-solid fa-pen"></i>
                                </a>
                                <form id="form_delete" method="POST" class="d-inline">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                                <button onclick="confirm_delete(' . $row->id . ')" title="Hapus Tagihan" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
                                ';
                        } else {
                            return '
                                <a title="Detail Tagihan" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                                    <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                                </a>
                                <a title="Buat Pembayaran" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . site_url() . 'finance-tagihan/' . $row->id . '/bayar">
                                    <i class="fa-fw fa-solid fa-pen"></i>
                                </a>
                                ';
                        }
                    } else {
                        return '
                            <a title="Detail Tagihan" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(' . $row->id . ')">
                                <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                            </a>';
                    }
                }, 'last')
                ->filter(function ($data, $request) {
                    if ($request->last30day != '') {
                        $data->where('tanggal >=', date('Y-m-d', strtotime('-30 days')));
                    }
                    if ($request->bulanini != '') {
                        $data->where('MONTH(tanggal)', date('m'));
                        $data->where('YEAR(tanggal)', date('Y'));
                    }
                    if ($request->belumDiBayar != '') {
                        $data->where('status', 'Belum dibayar');
                    }
                })
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {

            $modelTagihan = new TagihanModel();
            $modelTagihanRincian = new TagihanRincianModel();
            $modelTagihanPembayaran = new TagihanPembayaranModel();

            $tagihan = $modelTagihan->find($id);
            $tagihanRincian = $modelTagihanRincian->where('id_tagihan', $id)->findAll();
            $pembayaran = $modelTagihanPembayaran->getListPembayaranTagihan($id);

            $data = [
                'tagihan'          => $tagihan,
                'tagihanRincian'   => $tagihanRincian,
                'pembayaran'       => $pembayaran,
            ];

            $json = [
                'data'   => view('finance/tagihan/show', $data),
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

        $dariAkun = $modelAkun->where(['id_kategori' => 1])->findAll();

        $data = [
            'dariAkun'            => $dariAkun,
            'nomor_tagihan_auto'  => tagihan_nomor_auto(date('Y-m-d'))
        ];

        return view('finance/tagihan/new', $data);
    }


    public function keAkun()
    {
        $modelAkun  = new AkunModel();
        $dariAkun       = $modelAkun->where(['id_kategori !=' => 1])->orderBy('id_kategori', 'asc')->findAll();

        return $this->response->setJSON($dariAkun);
    }


    public function create()
    {
        $validasi = [
            'no_tagihan' => [
                'rules'  => 'required|is_unique[tagihan.no_tagihan]',
                'errors' => [
                    'required' => 'nomor tagihan belum diisi.',
                    'is_unique' => 'Nomor tagihan sudah ada dalam database. Refresh dan ulangi'
                ]
            ],
            'tanggal'  => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'tanggal belum diisi.',
                ]
            ],
            'penerima'  => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'penerima belum diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            $validation = \Config\Services::validation();

            $error = [
                'error_nomor'   => $validation->getError('no_tagihan'),
                'error_tanggal' => $validation->getError('tanggal'),
                'error_penerima' => $validation->getError('penerima'),
            ];

            $json = [
                'error' => $error
            ];
        } else {
            $modelTagihan           = new TagihanModel();
            $modelRincianTagihan    = new TagihanRincianModel();
            $modelTagihanPembayaran = new TagihanPembayaranModel();
            $modelAkun              = new AkunModel();


            // Tagihan
            $data_tagihan = [
                'no_tagihan'        => $this->request->getPost('no_tagihan'),
                'tanggal'           => $this->request->getPost('tanggal'),
                'penerima'          => $this->request->getPost('penerima'),
                'referensi'         => $this->request->getPost('referensi'),
                'status'            => 'Lunas',
                'jumlah'            => $this->request->getPost('total_tagihan')
            ];
            $modelTagihan->insert($data_tagihan);
            $id_tagihan = $modelTagihan->insertID();

            // rincian tagihan
            $id_keakun = $this->request->getPost('id_keakun');
            $deskripsi = $this->request->getPost('deskripsi');
            $jumlah_rincian_akun = $this->request->getPost('jumlah_rincian_akun');

            for ($i = 0; $i < count($id_keakun); $i++) {
                $akun = $modelAkun->find($id_keakun[$i]);
                if ($id_keakun[$i] != 0) {
                    $data_rincian = [
                        'id_tagihan'           => $id_tagihan,
                        'id_akun'              => $akun['id'],
                        'nama_rincian'         => $akun['nama'],
                        'deskripsi'            => $deskripsi[$i],
                        'jumlah'               => $jumlah_rincian_akun[$i],
                    ];
                    $modelRincianTagihan->insert($data_rincian);
                }
            }





            // -------------------------------------------------------- PEMBAYARAN TAGIHAN ------------------------------------------------------------------------

            // Pembayaran Tagihan
            $data_pembayaran = [
                'id_tagihan'            => $id_tagihan,
                'id_user'               => $this->request->getPost('id_user'),
                'id_akun_pembayaran'    => $this->request->getPost('id_dariakun'),
                'tanggal_bayar'         => $this->request->getPost('tanggal'),
                'jumlah_bayar'          => $this->request->getPost('total_tagihan')
            ];
            $modelTagihanPembayaran->insert($data_pembayaran);





            // ---------------------------------------------------------- JURNAL TRANSAKSI -------------------------------------------------------------------------

            $modelTransaksiJurnal = new JurnalModel();
            $modelTransaksiJurnalDetail = new JurnalDetailModel();


            // input ke jurnal transaksi
            $data_jurnal = [
                'nomor_transaksi'   => nomor_jurnal_auto_tagihan(),
                'referensi'         => $this->request->getVar('no_tagihan') . '-1',
                'tanggal'           => $this->request->getVar('tanggal'),
                'total_transaksi'   => $this->request->getVar('total_tagihan'),
            ];
            $modelTransaksiJurnal->save($data_jurnal);


            // insert detail transaksi jurnal (tagihan)
            if ($this->request->getVar('total_tagihan') > 0) {
                for ($i = 0; $i < count($id_keakun); $i++) {
                    $akun = $modelAkun->find($id_keakun[$i]);
                    if ($id_keakun[$i] != 0) {
                        $data_jurnal_detail = [
                            'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                            'id_akun'           => $akun['id'],
                            'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $akun['nama'],
                            'debit'             => abs($jumlah_rincian_akun[$i]),
                            'kredit'            => 0,
                        ];
                        $modelTransaksiJurnalDetail->save($data_jurnal_detail);
                    }
                }
                // pembayaran
                $dariakun = $modelAkun->find($this->request->getPost('id_dariakun'));
                $data_jurnal_detail = [
                    'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                    'id_akun'           => $dariakun['id'],
                    'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $dariakun['nama'],
                    'debit'             => 0,
                    'kredit'            => abs($this->request->getVar('total_tagihan')),
                ];
                $modelTransaksiJurnalDetail->save($data_jurnal_detail);
            } else {
                for ($i = 0; $i < count($id_keakun); $i++) {
                    $akun = $modelAkun->find($id_keakun[$i]);
                    if ($id_keakun[$i] != 0) {
                        $data_jurnal_detail = [
                            'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                            'id_akun'           => $akun['id'],
                            'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $akun['nama'],
                            'debit'             => 0,
                            'kredit'            => abs($jumlah_rincian_akun[$i]),
                        ];
                        $modelTransaksiJurnalDetail->save($data_jurnal_detail);
                    }
                }
                // pembayaran
                $dariakun = $modelAkun->find($this->request->getPost('id_dariakun'));
                $data_jurnal_detail = [
                    'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                    'id_akun'           => $dariakun['id'],
                    'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $dariakun['nama'],
                    'debit'             => abs($this->request->getVar('total_tagihan')),
                    'kredit'            => 0,
                ];
                $modelTransaksiJurnalDetail->save($data_jurnal_detail);
            }

            $json = [
                'success' => 'Berhasil menambah tagihan'
            ];
        }
        echo json_encode($json);
    }


    public function bayarTagihan($id_tagihan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $modelAkun              = new AkunModel();
        $modelTagihan           = new TagihanModel();
        $modelRincianTagihan    = new TagihanRincianModel();
        $modelTagihanPembayaran = new TagihanPembayaranModel();

        $tagihan = $modelTagihan->find($id_tagihan);
        $dariAkun = $modelAkun->where(['id_kategori' => 1])->findAll();
        $rincian = $modelRincianTagihan->where('id_tagihan', $id_tagihan)->findAll();
        $pembayaran = $modelTagihanPembayaran->getListPembayaranTagihan($id_tagihan);

        $data = [
            'tagihan'             => $tagihan,
            'dariAkun'            => $dariAkun,
            'nomor_tagihan_auto'  => tagihan_nomor_auto(date('Y-m-d')),
            'rincian'             => $rincian,
            'pembayaran'          => $pembayaran,
        ];

        return view('finance/tagihan/bayar', $data);
    }


    public function payTagihan()
    {
        $validasi = [
            'tanggal_bayar'  => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'tanggal belum diisi.',
                ]
            ],
            'jumlah_bayar'  => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'nominal pembayaran belum diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            $validation = \Config\Services::validation();

            $error = [
                'error_tanggal_bayar' => $validation->getError('tanggal_bayar'),
                'error_jumlah_bayar' => $validation->getError('jumlah_bayar'),
            ];

            $json = [
                'error' => $error
            ];
        } else {
            $modelTagihan           = new TagihanModel();
            $modelTagihanPembayaran = new TagihanPembayaranModel();
            $modelAkun              = new AkunModel();

            // -------------------------------------------------------- PEMBAYARAN TAGIHAN ------------------------------------------------------------------------

            $tagihan = $modelTagihan->find($this->request->getPost('id_tagihan'));
            $sisa_tagihan = $tagihan['sisa_tagihan'] - intval(str_replace(".", "", $this->request->getVar('jumlah_bayar')));
            if ($sisa_tagihan > 0) {
                $status_tagihan = 'Dibayar Sebagian';
            } else {
                $status_tagihan = 'Lunas';
            }
            $update_tagihan = [
                'id'                => $this->request->getPost('id_tagihan'),
                'sisa_tagihan'      => $sisa_tagihan,
                'status'            => $status_tagihan
            ];
            $modelTagihan->save($update_tagihan);


            // Pembayaran Tagihan
            $data_pembayaran = [
                'id_tagihan'            => $this->request->getPost('id_tagihan'),
                'id_user'               => $this->request->getPost('id_user'),
                'id_akun_pembayaran'    => $this->request->getPost('id_akun_pembayaran'),
                'tanggal_bayar'         => $this->request->getPost('tanggal_bayar'),
                'jumlah_bayar'                => intval(str_replace(".", "", $this->request->getVar('jumlah_bayar'))),
            ];
            $modelTagihanPembayaran->insert($data_pembayaran);



            // UPDATE DATA PEMBELIAN
            $modelPembelian = new PembelianModel();
            $update_pembelian = [
                'id'                => $tagihan['id_pembelian'],
                'status_pembayaran' => $status_tagihan
            ];
            $modelPembelian->save($update_pembelian);



            // ---------------------------------------------------------- JURNAL TRANSAKSI -------------------------------------------------------------------------

            $modelTransaksiJurnal = new JurnalModel();
            $modelTransaksiJurnalDetail = new JurnalDetailModel();


            // input ke jurnal transaksi
            $data_jurnal = [
                'nomor_transaksi'   => nomor_jurnal_auto_tagihan(),
                'referensi'         => 'Bayar Tagihan ' . $this->request->getVar('no_tagihan'),
                'tanggal'           => $this->request->getVar('tanggal_bayar'),
                'total_transaksi'   => intval(str_replace(".", "", $this->request->getVar('jumlah_bayar'))),
            ];
            $modelTransaksiJurnal->save($data_jurnal);


            // insert detail transaksi jurnal (tagihan)
            if ($this->request->getVar('jumlah_bayar') > 0) {

                $akun = $modelAkun->find(7); // 7 adalah akun hutang dagang
                $data_jurnal_detail = [
                    'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                    'id_akun'           => $akun['id'],
                    'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $akun['nama'],
                    'debit'             => intval(str_replace(".", "", $this->request->getVar('jumlah_bayar'))),
                    'kredit'            => 0,
                ];
                $modelTransaksiJurnalDetail->save($data_jurnal_detail);

                // pembayaran dari akun kas atau rekening
                $dariakun = $modelAkun->find($this->request->getPost('id_akun_pembayaran'));
                $data_jurnal_detail = [
                    'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                    'id_akun'           => $dariakun['id'],
                    'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $dariakun['nama'],
                    'debit'             => 0,
                    'kredit'            => intval(str_replace(".", "", $this->request->getVar('jumlah_bayar'))),
                ];
                $modelTransaksiJurnalDetail->save($data_jurnal_detail);
            } else {
                $akun = $modelAkun->find(7); // 7 adalah akun hutang dagang
                $data_jurnal_detail = [
                    'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                    'id_akun'           => $akun['id'],
                    'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $akun['nama'],
                    'debit'             => 0,
                    'kredit'            => intval(str_replace(".", "", $this->request->getVar('jumlah_bayar'))),
                ];
                $modelTransaksiJurnalDetail->save($data_jurnal_detail);

                // pembayaran dari akun kas atau rekening
                $dariakun = $modelAkun->find($this->request->getPost('id_dariakun'));
                $data_jurnal_detail = [
                    'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                    'id_akun'           => $dariakun['id'],
                    'deskripsi'         => $this->request->getVar('no_tagihan') . ' - ' . $dariakun['nama'],
                    'debit'             => intval(str_replace(".", "", $this->request->getVar('jumlah_bayar'))),
                    'kredit'            => 0,
                ];
                $modelTransaksiJurnalDetail->save($data_jurnal_detail);
            }

            $json = [
                'success' => 'Berhasil menambah tagihan'
            ];
        }
        echo json_encode($json);
    }
}
