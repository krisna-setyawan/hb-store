<?php

namespace App\Controllers\Purchase;

use App\Models\Purchase\AkunModel;
use App\Models\Purchase\InboundPembelianDetailModel;
use App\Models\Purchase\InboundPembelianModel;
use App\Models\Purchase\JurnalDetailModel;
use App\Models\Purchase\JurnalModel;
use App\Models\Purchase\PembelianDetailModel;
use App\Models\Purchase\PembelianModel;
use App\Models\Purchase\PemesananDetailModel;
use App\Models\Purchase\PemesananFixingDetailModel;
use App\Models\Purchase\PemesananFixingModel;
use App\Models\Purchase\PemesananModel;
use App\Models\Purchase\SupplierModel;
use App\Models\Purchase\TagihanModel;
use App\Models\Purchase\TagihanPembayaranModel;
use App\Models\Purchase\TagihanRincianModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class Pembelian extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];


    public function index()
    {
        return view('purchase/pembelian/index');
    }


    public function getDataPembelian()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $data =  $db->table('pembelian')
                ->select('pembelian.id, pembelian.no_pembelian, pembelian.tanggal, supplier.nama as supplier, pembelian.grand_total, pembelian.status, pembelian.status_pembayaran')
                ->join('supplier', 'pembelian.id_supplier = supplier.id', 'left')
                ->where('pembelian.deleted_at', null)
                ->where('pembelian.status !=', 'Fixing')
                ->orderBy('pembelian.id', 'desc');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                            <a title="Daftar Inbound" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="showModalInbound(' . $row->id . ')">
                                <i class="fa-fw fa-solid fa-list-check"></i>
                            </a>
                            <a title="Tagihan" class="px-2 py-0 btn btn-sm btn-outline-success" onclick="showModalTagihan(\'' . $row->no_pembelian . '\')">
                                <i class="fa-fw fa-solid fa-money-bill-wave"></i>
                            </a>
                            <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(\'' . $row->no_pembelian . '\')">
                                <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                            </a>';
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function show($no = null)
    {
        if ($this->request->isAJAX()) {
            $modelPembelian = new PembelianModel();
            $pembelian = $modelPembelian->getPembelian($no);
            $modelPembelianDetail = new PembelianDetailModel();
            $pembelian_detail = $modelPembelianDetail->getListProdukPembelian($pembelian['id']);

            $data = [
                'pembelian' => $pembelian,
                'pembelian_detail' => $pembelian_detail,
            ];

            $json = [
                'data' => view('purchase/pembelian/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function showTagihan($no = null)
    {
        if ($this->request->isAJAX()) {
            $modelTagihan = new TagihanModel();
            $modelPembelian = new PembelianModel();

            $pembelian = $modelPembelian->getPembelian($no);
            $tagihan = $modelTagihan->like('no_tagihan', $no)->findAll();

            $data = [
                'tagihan' => $tagihan,
                'pembelian' => $pembelian,
            ];

            $json = [
                'data' => view('purchase/pembelian/show_tagihan', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function create()
    {
        $modelPembelian = new PembelianModel();
        $modelPembelianDetail = new PembelianDetailModel();
        $modelPemesanan = new PemesananModel();

        $modelPemesananFixing = new PemesananFixingModel();
        $modelPemesananFixingDetail = new PemesananFixingDetailModel();
        $pemesananFixing = $modelPemesananFixing->find($this->request->getPost('id_pemesanan_fixing'));

        date_default_timezone_set('Asia/Jakarta');
        $no_pembelian = nomor_pembelian_auto(date('Y-m-d'));

        $data = [
            'id_pemesanan'          => $pemesananFixing['id_pemesanan'],
            'id_pemesanan_fixing'   => $pemesananFixing['id'],
            'id_supplier'           => $pemesananFixing['id_supplier'],
            'id_user'               => $this->request->getPost('id_user'),
            'id_gudang'             => $this->request->getPost('id_gudang'),
            'jenis_supplier'        => $pemesananFixing['jenis_supplier'],
            'id_perusahaan'         => $pemesananFixing['id_perusahaan'],
            'no_pembelian'          => $no_pembelian,
            'invoice'               => $this->request->getPost('invoice'),
            'tanggal'               => date('Y-m-d'),
            'panjang'               => $this->request->getPost('panjang'),
            'lebar'                 => $this->request->getPost('lebar'),
            'tinggi'                => $this->request->getPost('tinggi'),
            'berat'                 => $this->request->getPost('berat'),
            'exw'                   => $this->request->getPost('exw'),
            'hf'                    => $this->request->getPost('hf'),
            'ppn_hf'                => $this->request->getPost('ppn_hf'),
            'ongkir_port'           => $this->request->getPost('ongkir_port'),
            'ongkir_laut_udara'     => $this->request->getPost('ongkir_laut_udara'),
            'ongkir_transit'        => $this->request->getPost('ongkir_transit'),
            'ongkir_gudang'         => $this->request->getPost('ongkir_gudang'),
            'bm'                    => $this->request->getPost('bm'),
            'ppn'                   => $this->request->getPost('ppn'),
            'pph'                   => $this->request->getPost('pph'),
            'grand_total'           => $this->request->getPost('grand_total'),
            'status'                => 'Diproses',
        ];
        $modelPembelian->save($data);
        $id_pembelian = $modelPembelian->getInsertID();

        $listProdukPemesanan = $modelPemesananFixingDetail->where(['id_pemesanan_fixing' => $pemesananFixing['id']])->findAll();
        foreach ($listProdukPemesanan as $produk) {
            $data_produk = [
                'id_pembelian'          => $id_pembelian,
                'id_produk'             => $produk['id_produk'],
                'qty'                   => $produk['qty'],
                'harga_satuan'          => $produk['harga_satuan'],
                'total_harga'           => $produk['total_harga'],
            ];
            $modelPembelianDetail->save($data_produk);
        }

        $data_update_pemesanan = [
            'id'                    => $pemesananFixing['id_pemesanan'],
            'status'                => 'Pembelian'
        ];
        $modelPemesanan->save($data_update_pemesanan);

        $data_update_pemesanan_fixing = [
            'id'                    => $pemesananFixing['id'],
            'status'                => 'Pembelian'
        ];
        $modelPemesananFixing->save($data_update_pemesanan_fixing);


        // -----------------------------------------------------------------------------------------------------------------------------------------------------
        $exw               = intval(str_replace(".", "", $this->request->getVar('exw')));
        $hf                = intval(str_replace(".", "", $this->request->getVar('hf')));
        $ppn_hf            = intval(str_replace(".", "", $this->request->getVar('ppn_hf')));
        $ongkir_port       = intval(str_replace(".", "", $this->request->getVar('ongkir_port')));
        $ongkir_laut_udara = intval(str_replace(".", "", $this->request->getVar('ongkir_laut_udara')));
        $ongkir_transit    = intval(str_replace(".", "", $this->request->getVar('ongkir_transit')));
        $ongkir_gudang     = intval(str_replace(".", "", $this->request->getVar('ongkir_gudang')));
        $bm                = intval(str_replace(".", "", $this->request->getVar('bm')));
        $ppn               = intval(str_replace(".", "", $this->request->getVar('ppn')));
        $pph               = intval(str_replace(".", "", $this->request->getVar('pph')));


        // -------------------------------------------------------------- TAGIHAN ------------------------------------------------------------------------------
        $modelTagihan = new TagihanModel();
        $modelTagihanRincian = new TagihanRincianModel();
        $detailPembelian = $modelPembelian->getPembelianById($id_pembelian);


        // input ke tagihan
        $data_tagihan = [
            'id_pembelian'      => $id_pembelian,
            'no_tagihan'        => $no_pembelian . '-1',
            'tanggal'           => $this->request->getVar('tanggal'),
            'penerima'          => $detailPembelian['supplier'],
            'referensi'         => 'Pembelian ' . $no_pembelian,
            'asal'              => 'Pembelian',
            'jumlah'            => $this->request->getVar('grand_total'),
            'sisa_tagihan'      => $this->request->getVar('grand_total'),
        ];
        $modelTagihan->save($data_tagihan);

        // insert rincian tagihan
        if ($exw != 0) {
            $akun = $this->getAkun(5);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (EXW Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('exw'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($hf != 0) {
            $akun = $this->getAkun(27);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (HF Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('hf'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ppn_hf != 0) {
            $akun = $this->getAkun(6);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (PPN HF Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ppn_hf'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ongkir_port != 0) {
            $akun = $this->getAkun(15);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (Ongkir Port Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ongkir_port'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ongkir_laut_udara != 0) {
            $akun = $this->getAkun(15);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (Ongkir Laut Udara Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ongkir_laut_udara'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ongkir_transit != 0) {
            $akun = $this->getAkun(15);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (Ongkir Transit Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ongkir_transit'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ongkir_gudang != 0) {
            $akun = $this->getAkun(15);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (Ongkir Gudang Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ongkir_gudang'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($bm != 0) {
            $akun = $this->getAkun(26);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (BM Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('bm'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ppn != 0) {
            $akun = $this->getAkun(6);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (PPN Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ppn'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($pph != 0) {
            $akun = $this->getAkun(26);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (PPh Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('pph'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }


        // ---------------------------------------------------------- JURNAL TRANSAKSI -------------------------------------------------------------------------
        $modelTransaksiJurnal = new JurnalModel();
        $modelTransaksiJurnalDetail = new JurnalDetailModel();

        // input ke jurnal transaksi
        $data_jurnal = [
            'nomor_transaksi'   => nomor_jurnal_auto_pembelian(),
            'referensi'         => $no_pembelian . '-1',
            'tanggal'           => $this->request->getVar('tanggal'),
            'total_transaksi'   => $this->request->getVar('grand_total'),
        ];
        $modelTransaksiJurnal->save($data_jurnal);

        // insert detail transaksi jurnal
        if ($exw != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 5,
                'deskripsi'         => $no_pembelian . '-EXW',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('exw'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($hf != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 27,
                'deskripsi'         => $no_pembelian . '-HF',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('hf'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ppn_hf != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 6,
                'deskripsi'         => $no_pembelian . '-PPN HF',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('ppn_hf'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ongkir_port != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 15,
                'deskripsi'         => $no_pembelian . '-Ongkir Port',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('ongkir_port'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ongkir_laut_udara != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 15,
                'deskripsi'         => $no_pembelian . '-Ongkir Laut Udara',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('ongkir_laut_udara'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ongkir_transit != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 15,
                'deskripsi'         => $no_pembelian . '-Ongkir Transit',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('ongkir_transit'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ongkir_gudang != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 15,
                'deskripsi'         => $no_pembelian . '-Ongkir Gudang',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('ongkir_gudang'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($bm != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 26,
                'deskripsi'         => $no_pembelian . '-BM',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('bm'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ppn != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 6,
                'deskripsi'         => $no_pembelian . '-PPN',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('ppn'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($pph != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 26,
                'deskripsi'         => $no_pembelian . '-PPh',
                'debit'             => intval(str_replace(".", "", $this->request->getVar('pph'))),
                'kredit'            => 0,
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }


        // HUTANG ---------------------------------------
        $data_jurnal_detail = [
            'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
            'id_akun'           => 7,
            'deskripsi'         => $no_pembelian . '-Hutang Dagang',
            'debit'             => 0,
            'kredit'            => $this->request->getVar('grand_total'),
        ];
        $modelTransaksiJurnalDetail->save($data_jurnal_detail);

        session()->setFlashdata('pesan', 'Berhasil membuat tagihan pembelian.');
        return redirect()->to('/purchase-fixing_pemesanan');
    }





    public function isDebit($value)
    {
        if ($value > 0) {
            return $value;
        } else {
            return 0;
        }
    }

    public function isKredit($value)
    {
        if ($value < 0) {
            return $value;
        } else {
            return 0;
        }
    }

    public function getAkun($id)
    {
        $modelAkun = new AkunModel();
        $akun = $modelAkun->find($id);
        return $akun;
    }





    public function tambahTagihan()
    {
        $modelTagihan = new TagihanModel();
        $modelTagihanRincian = new TagihanRincianModel();
        $pembelianModel = new PembelianModel();
        $supplierModel = new SupplierModel();

        $hf                = intval(str_replace(".", "", $this->request->getVar('hf')));
        $ppn_hf            = intval(str_replace(".", "", $this->request->getVar('ppn_hf')));
        $ongkir_port       = intval(str_replace(".", "", $this->request->getVar('ongkir_port')));
        $ongkir_laut_udara = intval(str_replace(".", "", $this->request->getVar('ongkir_laut_udara')));
        $ongkir_transit    = intval(str_replace(".", "", $this->request->getVar('ongkir_transit')));
        $ongkir_gudang     = intval(str_replace(".", "", $this->request->getVar('ongkir_gudang')));
        $bm                = intval(str_replace(".", "", $this->request->getVar('bm')));
        $ppn               = intval(str_replace(".", "", $this->request->getVar('ppn')));
        $pph               = intval(str_replace(".", "", $this->request->getVar('pph')));

        $jumlah = $hf + $ppn_hf + $ongkir_port + $ongkir_laut_udara + $ongkir_transit + $ongkir_gudang + $bm + $ppn + $pph;

        $no_tagihan_new = nomor_tagihan_pembelian_auto($this->request->getVar('no_pembelian'));
        $pembelian = $pembelianModel->find($this->request->getVar('id_pembelian'));
        $supplier = $supplierModel->find($pembelian['id_supplier']);

        // Insert tagihan
        $data_tagihan = [
            'id_pembelian'      => $this->request->getVar('id_pembelian'),
            'no_tagihan'        => $no_tagihan_new,
            'penerima'          => $supplier['nama'],
            'referensi'         => $pembelian['no_pembelian'],
            'tanggal'           => $this->request->getVar('tanggal'),
            'asal'              => 'Pembelian',
            'jumlah'            => $jumlah,
            'sisa_tagihan'      => $jumlah,
        ];
        $modelTagihan->save($data_tagihan);



        // Insert rincian
        if ($hf != 0) {
            $akun = $this->getAkun(27);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (HF Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('hf'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ppn_hf != 0) {
            $akun = $this->getAkun(6);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (PPN HF Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ppn_hf'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ongkir_port != 0) {
            $akun = $this->getAkun(15);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (Ongkir Port Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ongkir_port'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ongkir_laut_udara != 0) {
            $akun = $this->getAkun(15);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (Ongkir Laut Udara Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ongkir_laut_udara'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ongkir_transit != 0) {
            $akun = $this->getAkun(15);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (Ongkir Transit Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ongkir_transit'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ongkir_gudang != 0) {
            $akun = $this->getAkun(15);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (Ongkir Gudang Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ongkir_gudang'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($bm != 0) {
            $akun = $this->getAkun(26);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (BM Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('bm'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($ppn != 0) {
            $akun = $this->getAkun(6);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (PPN Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('ppn'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }

        if ($pph != 0) {
            $akun = $this->getAkun(26);
            $data_rincian_tagihan = [
                'id_tagihan'        => $modelTagihan->getInsertID(),
                'id_akun'           => $akun['id'],
                'nama_rincian'      => $akun['nama'] . ' (PPh Pembelian)',
                'jumlah'            => intval(str_replace(".", "", $this->request->getVar('pph'))),
            ];
            $modelTagihanRincian->save($data_rincian_tagihan);
        }




        // ---------------------------------------------------------- JURNAL TRANSAKSI -------------------------------------------------------------------------
        $modelTransaksiJurnal = new JurnalModel();
        $modelTransaksiJurnalDetail = new JurnalDetailModel();

        // input ke jurnal transaksi
        $data_jurnal = [
            'nomor_transaksi'   => nomor_jurnal_auto_pembelian(),
            'referensi'         => $no_tagihan_new,
            'tanggal'           => $this->request->getVar('tanggal'),
            'total_transaksi'   => $jumlah,
        ];
        $modelTransaksiJurnal->save($data_jurnal);

        // insert detail transaksi jurnal
        if ($hf != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 27,
                'deskripsi'         => $this->request->getVar('no_pembelian') . '-HF',
                'debit'             => abs($this->isDebit(intval(str_replace(".", "", $this->request->getVar('hf'))))),
                'kredit'            => abs($this->isKredit(intval(str_replace(".", "", $this->request->getVar('hf'))))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ppn_hf != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 6,
                'deskripsi'         => $this->request->getVar('no_pembelian') . '-PPN HF',
                'debit'             => abs($this->isDebit(intval(str_replace(".", "", $this->request->getVar('ppn_hf'))))),
                'kredit'            => abs($this->isKredit(intval(str_replace(".", "", $this->request->getVar('ppn_hf'))))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ongkir_port != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 15,
                'deskripsi'         => $this->request->getVar('no_pembelian') . '-Ongkir Port',
                'debit'             => abs($this->isDebit(intval(str_replace(".", "", $this->request->getVar('ongkir_port'))))),
                'kredit'            => abs($this->isKredit(intval(str_replace(".", "", $this->request->getVar('ongkir_port'))))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ongkir_laut_udara != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 15,
                'deskripsi'         => $this->request->getVar('no_pembelian') . '-Ongkir Laut Udara',
                'debit'             => abs($this->isDebit(intval(str_replace(".", "", $this->request->getVar('ongkir_laut_udara'))))),
                'kredit'            => abs($this->isKredit(intval(str_replace(".", "", $this->request->getVar('ongkir_laut_udara'))))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ongkir_transit != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 15,
                'deskripsi'         => $this->request->getVar('no_pembelian') . '-Ongkir Transit',
                'debit'             => abs($this->isDebit(intval(str_replace(".", "", $this->request->getVar('ongkir_transit'))))),
                'kredit'            => abs($this->isKredit(intval(str_replace(".", "", $this->request->getVar('ongkir_transit'))))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ongkir_gudang != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 15,
                'deskripsi'         => $this->request->getVar('no_pembelian') . '-Ongkir Gudang',
                'debit'             => abs($this->isDebit(intval(str_replace(".", "", $this->request->getVar('ongkir_gudang'))))),
                'kredit'            => abs($this->isKredit(intval(str_replace(".", "", $this->request->getVar('ongkir_gudang'))))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($bm != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 26,
                'deskripsi'         => $this->request->getVar('no_pembelian') . '-BM',
                'debit'             => abs($this->isDebit(intval(str_replace(".", "", $this->request->getVar('bm'))))),
                'kredit'            => abs($this->isKredit(intval(str_replace(".", "", $this->request->getVar('bm'))))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($ppn != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 6,
                'deskripsi'         => $this->request->getVar('no_pembelian') . '-PPN',
                'debit'             => abs($this->isDebit(intval(str_replace(".", "", $this->request->getVar('ppn'))))),
                'kredit'            => abs($this->isKredit(intval(str_replace(".", "", $this->request->getVar('ppn'))))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($pph != 0) {
            $data_jurnal_detail = [
                'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
                'id_akun'           => 26,
                'deskripsi'         => $this->request->getVar('no_pembelian') . '-PPh',
                'debit'             => abs($this->isDebit(intval(str_replace(".", "", $this->request->getVar('pph'))))),
                'kredit'            => abs($this->isKredit(intval(str_replace(".", "", $this->request->getVar('pph'))))),
            ];
            $modelTransaksiJurnalDetail->save($data_jurnal_detail);
        }

        if ($jumlah > 0) {
            $kredit = $jumlah;
            $debit = 0;
        } else {
            $debit = $jumlah;
            $kredit = 0;
        }

        // HUTANG ---------------------------------------
        $data_jurnal_detail = [
            'id_transaksi'      => $modelTransaksiJurnal->getInsertID(),
            'id_akun'           => 7,
            'deskripsi'         => $this->request->getVar('no_pembelian') . '-Hutang Dagang',
            'debit'             => abs($debit),
            'kredit'            => abs($kredit),
        ];
        $modelTransaksiJurnalDetail->save($data_jurnal_detail);

        $json = [
            'ok' => 'ok',
        ];

        echo json_encode($json);
    }


    public function showRincianTagihan($id_tagihan)
    {

        if ($this->request->isAJAX()) {
            $modelTagihanRincian = new TagihanRincianModel();
            $rincian = $modelTagihanRincian->where('id_tagihan', $id_tagihan)->findAll();

            $data = [
                'rincian' => $rincian,
            ];

            $json = [
                'data' => view('purchase/pembelian/rincian_tagihan', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function showPembayaranTagihan($id_tagihan)
    {
        if ($this->request->isAJAX()) {
            $modelTagihanPembayaran = new TagihanPembayaranModel();
            $pembayaran = $modelTagihanPembayaran->getPembayaranByIdTagihan($id_tagihan);

            $data = [
                'pembayaran' => $pembayaran,
            ];

            $json = [
                'data' => view('purchase/pembelian/pembayaran_tagihan', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function listInboundPembelian($id_pembelian)
    {
        $modelInboundPembelian = new InboundPembelianModel();
        $inbound_pembelian = $modelInboundPembelian->getListInboundPembelian($id_pembelian);
        $modelPembelian = new PembelianModel();
        $pembelian = $modelPembelian->getPembelianById($id_pembelian);

        $data = [
            'inbound_pembelian' => $inbound_pembelian,
            'pembelian'         => $pembelian,
        ];

        $json = [
            'data'       => view('purchase/pembelian/list_inbound', $data),
        ];

        echo json_encode($json);
    }


    public function showDetailInbound($id_inbound_pembelian)
    {
        $modelInboundPembelianDetail = new InboundPembelianDetailModel();
        $list_produk = $modelInboundPembelianDetail->getListProduk($id_inbound_pembelian);

        $data = [
            'list_produk' => $list_produk,
        ];

        $json = [
            'data' => view('purchase/pembelian/list_produk_inbound', $data),
        ];

        echo json_encode($json);
    }


    public function delete($id = null)
    {
        $modelPembelian = new PembelianModel();
        $pembelian = $modelPembelian->find($id);

        $modelPemesanan = new PemesananModel();
        $pemesanan = $modelPemesanan->where(['id' => $pembelian['id_pemesanan']])->first();

        $modelPemesanan->save(
            [
                'id' => $pemesanan['id'],
                'status' => 'Dihapus',
            ]
        );

        $modelPembelianDetail = new PembelianDetailModel();
        $modelPembelianDetail->where(['id_pembelian' => $id])->delete();

        $modelPembelian->delete($id, true);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/purchase-fixing_pemesanan');
    }
}
