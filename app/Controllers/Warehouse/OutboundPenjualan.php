<?php

namespace App\Controllers\Warehouse;

use App\Models\Warehouse\GudangModel;
use App\Models\Warehouse\OutboundPenjualanDetailModel;
use App\Models\Warehouse\OutboundPenjualanModel;
use App\Models\Warehouse\PenjualanDetailModel;
use App\Models\Warehouse\PenjualanModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class OutboundPenjualan extends ResourcePresenter
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

        return view('warehouse/outbound_penjualan/index', $data);
    }


    public function getDataPenjualan()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $data =  $db->table('penjualan')
                ->select('penjualan.id, penjualan.no_penjualan, customer.nama as customer, penjualan.tanggal, penjualan.status_outbound, karyawan.nama_lengkap as admin')
                ->join('customer', 'penjualan.id_customer = customer.id', 'left')
                ->join('users', 'penjualan.id_user = users.id', 'left')
                ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
                ->where('penjualan.deleted_at', null)
                ->where('penjualan.status', 'Request Outbound');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                        <a title="Daftar Outbound" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="showModalOutbound(' . $row->id . ')">
                            <i class="fa-fw fa-solid fa-list-check"></i>
                        </a>';
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function listOutboundPenjualan($id_penjualan)
    {
        $id_gudang = session()->get('id_gudang');

        $modelOutboundPenjualan = new OutboundPenjualanModel();
        $outbound_penjualan = $modelOutboundPenjualan->getListOutboundPenjualan($id_penjualan);
        $modelPenjualan = new PenjualanModel();
        $penjualan = $modelPenjualan->getPenjualanById($id_penjualan);

        $hasSavedStatus = false;
        foreach ($outbound_penjualan as $item) {
            if ($item['status_simpan'] === 'Unsave') {
                $hasSavedStatus = true;
                break;
            }
        }

        $data = [
            'id_gudang'             => $id_gudang,
            'outbound_penjualan'    => $outbound_penjualan,
            'penjualan'             => $penjualan,
            'hasSavedStatus'        => $hasSavedStatus
        ];

        $json = [
            'data'       => view('warehouse/outbound_penjualan/list_outbound', $data),
        ];

        echo json_encode($json);
    }


    public function showDetailOutbound($id_outbound_penjualan)
    {
        $modelOutboundPenjualanDetail = new OutboundPenjualanDetailModel();
        $list_produk = $modelOutboundPenjualanDetail->getListProdukForDetail($id_outbound_penjualan);

        $data = [
            'list_produk' => $list_produk,
        ];

        $json = [
            'data' => view('warehouse/outbound_penjualan/list_produk_outbound', $data),
        ];

        echo json_encode($json);
    }


    public function create_outbound_penjualan($id_penjualan)
    {
        $idGudang     = session()->get('id_gudang');
        $no_outbound = nomor_outbound_auto(date('Y-m-d'));

        $modelOutboundPenjualan = new OutboundPenjualanModel();
        $outbound_penjualan = $modelOutboundPenjualan->where(['id_penjualan' => $id_penjualan])->first();

        if ($outbound_penjualan) {
            $data = [
                'id_penjualan' => $id_penjualan,
                'id_pj'        => user()->id,
                'id_gudang'    => $idGudang,
                'no_outbound'  => $no_outbound,
                'tanggal'      => date('Y-m-d'),
            ];
            $modelOutboundPenjualan->insert($data);

            $modelOutboundPenjualanDetail = new OutboundPenjualanDetailModel();
            $outbound_penjualan_detail = $modelOutboundPenjualanDetail->getListProdukdanTotalDikirim($id_penjualan);

            foreach ($outbound_penjualan_detail as $ls_produk) {
                $data = [
                    'id_penjualan'              => $id_penjualan,
                    'id_outbound_penjualan'     => $modelOutboundPenjualan->getInsertID(),
                    'id_produk'                 => $ls_produk['id_produk'],
                    'qty_beli'                  => $ls_produk['qty_beli'],
                    'qty_dikirim_sebelumnya'    => $ls_produk['sudah_dikirim'],
                    'qty_dikirim_sekarang'      => 0,
                    'qty_kurang'                => $ls_produk['qty_beli'] - $ls_produk['sudah_dikirim'],
                ];
                $modelOutboundPenjualanDetail->insert($data);
            }
        } else {
            $data = [
                'id_penjualan' => $id_penjualan,
                'id_pj'        => user()->id,
                'id_gudang'    => $idGudang,
                'no_outbound'  => $no_outbound,
                'tanggal'      => date('Y-m-d'),
            ];
            $modelOutboundPenjualan->insert($data);

            $modelOutboundPenjualanDetail = new OutboundPenjualanDetailModel();
            $modelPenjualanDetail = new PenjualanDetailModel();
            $penjualan_detail = $modelPenjualanDetail->where(['id_penjualan' => $id_penjualan])->findAll();

            foreach ($penjualan_detail as $ls_produk) {
                $data = [
                    'id_penjualan'              => $id_penjualan,
                    'id_outbound_penjualan'     => $modelOutboundPenjualan->getInsertID(),
                    'id_produk'                 => $ls_produk['id_produk'],
                    'qty_beli'                  => $ls_produk['qty'],
                    'qty_dikirim_sebelumnya'    => 0,
                    'qty_dikirim_sekarang'      => 0,
                    'qty_kurang'                => $ls_produk['qty'],
                ];
                $modelOutboundPenjualanDetail->insert($data);
            }
        }

        return redirect()->to('/warehouse-detail_outbound_penjualan/' . $no_outbound);
    }
}
