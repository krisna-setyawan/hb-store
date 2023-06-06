<?php

namespace App\Controllers\Warehouse;

use App\Models\Warehouse\GudangModel;
use App\Models\Warehouse\InboundPembelianDetailModel;
use App\Models\Warehouse\InboundPembelianModel;
use App\Models\Warehouse\PembelianDetailModel;
use App\Models\Warehouse\PembelianModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class InboundPembelian extends ResourcePresenter
{
    protected $helpers = ['form', 'stok_helper'];


    public function index()
    {
        $id_gudang = session()->get('id_gudang');

        $modelGudang = new GudangModel();

        $gudang = $modelGudang->getGudangWithAlamat($id_gudang);
        $data = [
            'id_gudang' => $id_gudang,
            'nama_gudang' => $gudang['nama']
        ];

        return view('warehouse/inbound_pembelian/index', $data);
    }


    public function getDataPembelian()
    {
        if ($this->request->isAJAX()) {
            $idGudang     = session()->get('id_gudang');

            $db = \Config\Database::connect();
            $data =  $db->table('pembelian')
                ->select('pembelian.id, pembelian.no_pembelian, supplier.nama as supplier, pembelian.tanggal, pembelian.status_inbound, gudang.nama as gudang, karyawan.nama_lengkap as admin')
                ->join('supplier', 'pembelian.id_supplier = supplier.id', 'left')
                ->join('gudang', 'pembelian.id_gudang = gudang.id', 'left')
                ->join('users', 'pembelian.id_user = users.id', 'left')
                ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
                ->where('pembelian.deleted_at', null)
                ->where('id_gudang', $idGudang);

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                        <a title="Daftar Inbound" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalInbound(' . $row->id . ')">
                            <i class="fa-fw fa-solid fa-list-check"></i>
                        </a>';
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function listInboundPembelian($id_pembelian)
    {
        $modelInboundPembelian = new InboundPembelianModel();
        $inbound_pembelian = $modelInboundPembelian->getListInboundPembelian($id_pembelian);
        $modelPembelian = new PembelianModel();
        $pembelian = $modelPembelian->getPembelianById($id_pembelian);

        $hasSavedStatus = false;
        foreach ($inbound_pembelian as $item) {
            if ($item['status_simpan'] === 'Unsave') {
                $hasSavedStatus = true;
                break;
            }
        }

        $data = [
            'inbound_pembelian' => $inbound_pembelian,
            'pembelian'         => $pembelian,
            'hasSavedStatus'    => $hasSavedStatus
        ];

        $json = [
            'data'       => view('warehouse/inbound_pembelian/list_inbound', $data),
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
            'data' => view('warehouse/inbound_pembelian/list_produk_inbound', $data),
        ];

        echo json_encode($json);
    }


    public function create_inbound_pembelian($id_pembelian)
    {
        $no_inbound = nomor_inbound_auto(date('Y-m-d'));

        $modelInboundPembelian = new InboundPembelianModel();
        $inbound_pembelian = $modelInboundPembelian->where(['id_pembelian' => $id_pembelian])->first();

        if ($inbound_pembelian) {
            $data = [
                'id_pembelian' => $id_pembelian,
                'id_pj'        => user()->id,
                'no_inbound'   => $no_inbound,
                'tanggal'      => date('Y-m-d'),
            ];
            $modelInboundPembelian->insert($data);

            $modelInboundPembelianDetail = new InboundPembelianDetailModel();
            $inbound_pembelian_detail = $modelInboundPembelianDetail->getListProdukdanTotalDiterima($id_pembelian);

            foreach ($inbound_pembelian_detail as $ls_produk) {
                $data = [
                    'id_pembelian'              => $id_pembelian,
                    'id_inbound_pembelian'      => $modelInboundPembelian->getInsertID(),
                    'id_produk'                 => $ls_produk['id_produk'],
                    'qty_beli'                  => $ls_produk['qty_beli'],
                    'qty_diterima_sebelumnya'   => $ls_produk['sudah_diterima'],
                    'qty_diterima_sekarang'     => 0,
                    'qty_kurang'                => $ls_produk['qty_beli'] - $ls_produk['sudah_diterima'],
                ];
                $modelInboundPembelianDetail->insert($data);
            }
        } else {
            $data = [
                'id_pembelian' => $id_pembelian,
                'id_pj'        => user()->id,
                'no_inbound'   => $no_inbound,
                'tanggal'      => date('Y-m-d'),
            ];
            $modelInboundPembelian->insert($data);

            $modelInboundPembelianDetail = new InboundPembelianDetailModel();
            $modelPembelianDetail = new PembelianDetailModel();
            $pembelian_detail = $modelPembelianDetail->where(['id_pembelian' => $id_pembelian])->findAll();

            foreach ($pembelian_detail as $ls_produk) {
                $data = [
                    'id_pembelian'              => $id_pembelian,
                    'id_inbound_pembelian'      => $modelInboundPembelian->getInsertID(),
                    'id_produk'                 => $ls_produk['id_produk'],
                    'qty_beli'                  => $ls_produk['qty'],
                    'qty_diterima_sebelumnya'   => 0,
                    'qty_diterima_sekarang'     => 0,
                    'qty_kurang'                => $ls_produk['qty'],
                ];
                $modelInboundPembelianDetail->insert($data);
            }
        }

        return redirect()->to('/warehouse-detail_inbound_pembelian/' . $no_inbound);
    }
}
