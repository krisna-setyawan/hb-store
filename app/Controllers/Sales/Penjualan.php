<?php

namespace App\Controllers\Sales;

use App\Models\Sales\AkunModel;
use App\Models\Sales\JurnalDetailModel;
use App\Models\Sales\JurnalModel;
use App\Models\Sales\PenjualanDetailModel;
use App\Models\Sales\PenjualanModel;
use App\Models\Sales\PenawaranDetailModel;
use App\Models\Sales\PenawaranModel;
use App\Models\Sales\TagihanModel;
use App\Models\Sales\TagihanPembayaranModel;
use App\Models\Sales\TagihanRincianModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class Penjualan extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];


    public function index()
    {
        return view('sales/penjualan/index');
    }


    public function getDataPenjualan()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $data =  $db->table('penjualan')
                ->select('penjualan.id, penjualan.no_penjualan, penjualan.tanggal, customer.nama as customer, penjualan.grand_total, penjualan.status, penjualan.status_pembayaran')
                ->join('customer', 'penjualan.id_customer = customer.id', 'left')
                ->where('penjualan.deleted_at', null)
                ->where('penjualan.status !=', 'Fixing')
                ->orderBy('penjualan.id', 'desc');

            //     <a title="Tagihan" class="px-2 py-0 btn btn-sm btn-outline-success" onclick="showModalTagihan(\'' . $row->no_penjualan . '\')">
            //     <i class="fa-fw fa-solid fa-money-bill-wave"></i>
            // </a>

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                            
                            <a title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalDetail(\'' . $row->no_penjualan . '\')">
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
            $modelPenjualan = new PenjualanModel();
            $penjualan = $modelPenjualan->getPenjualan($no);
            $modelPenjualanDetail = new PenjualanDetailModel();
            $penjualan_detail = $modelPenjualanDetail->getListProdukPenjualan($penjualan['id']);

            $data = [
                'penjualan' => $penjualan,
                'penjualan_detail' => $penjualan_detail,
            ];

            $json = [
                'data' => view('sales/penjualan/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function create()
    {
        $modelPenjualan = new PenjualanModel();
        $modelPenawaran = new PenawaranModel();
        $modelPenjualanDetail = new PenjualanDetailModel();
        $modelPenawaranDetail = new PenawaranDetailModel();
        $penawaran = $modelPenawaran->getPenawaran($this->request->getPost('no_penawaran'));
        $penjualan = $modelPenjualan->getPenjualanByIdPenawaran($penawaran['id']);

        if ($penjualan) {
            return redirect()->to('/sales-list_fixing/' . $this->request->getPost('no_penawaran'));
        } else {

            date_default_timezone_set('Asia/Jakarta');
            $no_penjualan = nomor_penjualan_auto(date('Y-m-d'));

            $data = [
                'id_penawaran'          => $penawaran['id'],
                'id_customer'           => $penawaran['id_customer'],
                'id_user'               => $penawaran['id_user'],
                'no_penjualan'          => $no_penjualan,
                'tanggal'               => date('Y-m-d'),
                'panjang'               => 1,
                'lebar'                 => 1,
                'tinggi'                => 1,
                'berat'                 => 1,
                'carton_koli'           => 1,
                'grand_total'           => $penawaran['total_harga_produk'],
                'total_harga_produk'    => $penawaran['total_harga_produk'],
                'status'                => 'Fixing',
            ];

            $modelPenjualan->save($data);
            $id_penjualan = $modelPenjualan->getInsertID();

            $listProdukPenawaran = $modelPenawaranDetail->where(['id_penawaran' => $penawaran['id']])->findAll();
            foreach ($listProdukPenawaran as $produk) {
                $data_produk = [
                    'id_penjualan'          => $id_penjualan,
                    'id_produk'             => $produk['id_produk'],
                    'qty'                   => $produk['qty'],
                    'harga_satuan'          => $produk['harga_satuan'],
                    'diskon'                => 0,
                    'biaya_tambahan'        => 0,
                    'total_harga'           => $produk['total_harga'],
                ];
                $modelPenjualanDetail->save($data_produk);
            }

            $data_update_penawaran = [
                'id'                    => $penawaran['id'],
                'status'                => 'Fixing'
            ];
            $modelPenawaran->save($data_update_penawaran);

            return redirect()->to('/sales-list_fixing/' . $this->request->getPost('no_penawaran'));
        }
    }


    public function checkProdukPenjualan()
    {
        $id_penjualan = $this->request->getVar('id_penjualan');
        $modelPenjualanDetail = new PenjualanDetailModel();
        $produk = $modelPenjualanDetail->where(['id_penjualan' => $id_penjualan])->findAll();

        if ($produk) {
            $json = ['ok' => 'ok'];
        } else {
            $json = ['null' => null];
        }
        echo json_encode($json);
    }


    public function simpanPenjualan()
    {
        if ($this->request->isAJAX()) {
            $modelPenjualan = new PenjualanModel();
            $modelPenawaran = new PenawaranModel();

            $data_update_penjualan = [
                'id'                    => $this->request->getVar('id_penjualan'),
                'id_customer'           => $this->request->getVar('id_customer'),
                'no_penjualan'          => $this->request->getVar('no_penjualan'),
                'tanggal'               => $this->request->getVar('tanggal'),
                'total_harga_produk'    => intval(str_replace(".", "", $this->request->getVar('total_harga_produk'))),
                // 'ongkir'                => intval(str_replace(".", "", $this->request->getVar('ongkir'))),
                'diskon'                => intval(str_replace(".", "", $this->request->getVar('diskon'))),
                // 'jasa_kirim'            => $this->request->getVar('jasa_kirim'),
                'kode_promo'            => $this->request->getVar('kode_promo'),
                'grand_total'           => $this->request->getVar('grand_total'),
                'nama_alamat'           => $this->request->getVar('nama_alamat'),
                'id_provinsi'           => $this->request->getVar('id_provinsi'),
                'id_kota'               => $this->request->getVar('id_kota'),
                'id_kecamatan'          => $this->request->getVar('id_kecamatan'),
                'id_kelurahan'          => $this->request->getVar('id_kelurahan'),
                'detail_alamat'         => $this->request->getVar('detail_alamat'),
                'penerima'              => $this->request->getVar('penerima'),
                'no_telp'               => $this->request->getVar('no_telp'),
                'catatan'               => $this->request->getVar('catatan'),
            ];
            $modelPenjualan->save($data_update_penjualan);

            $penjualan = $modelPenjualan->find($this->request->getVar('id_penjualan'));
            $data_update_penawaran = [
                'id'                    => $penjualan['id_penawaran'],
                'id_customer'           => $this->request->getVar('id_customer'),
            ];
            $modelPenawaran->save($data_update_penawaran);

            $json = ['ok' => 'ok'];
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function buatPenjualan()
    {
        date_default_timezone_set('Asia/Jakarta');

        $id_penjualan           = $this->request->getVar('id_penjualan');
        // $total_harga_produk     = intval(str_replace(".", "", $this->request->getVar('total_harga_produk')));
        // $ongkir                 = intval(str_replace(".", "", $this->request->getVar('ongkir')));
        // $diskon                 = intval(str_replace(".", "", $this->request->getVar('diskon')));

        $modelPenawaran = new PenawaranModel();
        $modelPenjualan = new PenjualanModel();

        $penjualan = $modelPenjualan->find($id_penjualan);
        // $detailPenjualan = $modelPenjualan->getPenjualan($this->request->getVar('no_penjualan'));

        $data_update = [
            'id'                    => $penjualan['id'],
            'id_customer'           => $this->request->getVar('customer'),
            'no_penjualan'          => $this->request->getVar('no_penjualan'),
            'tanggal'               => $this->request->getVar('tanggal'),
            'total_harga_produk'    => intval(str_replace(".", "", $this->request->getVar('total_harga_produk'))),
            // 'ongkir'                => intval(str_replace(".", "", $this->request->getVar('ongkir'))),
            'diskon'                => intval(str_replace(".", "", $this->request->getVar('diskon'))),
            // 'jasa_kirim'            => $this->request->getVar('jasa_kirim'),
            'kode_promo'            => $this->request->getVar('kode_promo'),
            'grand_total'           => intval(str_replace(".", "", $this->request->getVar('grand_total'))),
            'nama_alamat'           => $this->request->getVar('nama_alamat'),
            'id_provinsi'           => $this->request->getVar('id_provinsi'),
            'id_kota'               => $this->request->getVar('id_kota'),
            'id_kecamatan'          => $this->request->getVar('id_kecamatan'),
            'id_kelurahan'          => $this->request->getVar('id_kelurahan'),
            'detail_alamat'         => $this->request->getVar('detail_alamat'),
            'penerima'              => $this->request->getVar('penerima'),
            'no_telp'               => $this->request->getVar('no_telp'),
            'catatan'               => $this->request->getVar('catatan'),
            'status'                => 'Request Outbound'
        ];
        $modelPenjualan->save($data_update);

        $data_update_penawaran = [
            'id'                    => $penjualan['id_penawaran'],
            'id_customer'           => $this->request->getVar('customer'),
            'status'                => 'Penjualan'
        ];
        $modelPenawaran->save($data_update_penawaran);


        session()->setFlashdata('pesan', 'Berhasil membuat tagihan penjualan.');
        return redirect()->to('/sales-fixing_penawaran');
    }


    public function delete($id = null)
    {
        $modelPenjualan = new PenjualanModel();
        $penjualan = $modelPenjualan->find($id);

        $modelPenawaran = new PenawaranModel();
        $penawaran = $modelPenawaran->where(['id' => $penjualan['id_penawaran']])->first();

        $modelPenawaran->save(
            [
                'id' => $penawaran['id'],
                'status' => 'Dihapus',
            ]
        );

        // $modelPenjualanDetail = new PenjualanDetailModel();
        // $modelPenjualanDetail->where(['id_penjualan' => $id])->delete();

        $modelPenjualan->delete($id, true);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/sales-fixing_penawaran');
    }
}
