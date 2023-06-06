<?php

namespace App\Controllers\Warehouse;

use App\Models\Warehouse\LokasiProdukModel;
use App\Models\Warehouse\OutboundPenjualanDetailModel;
use App\Models\Warehouse\OutboundPenjualanModel;
use App\Models\Warehouse\PenjualanModel;
use App\Models\Warehouse\ProdukModel;
use CodeIgniter\RESTful\ResourcePresenter;

class OutboundPenjualanDetail extends ResourcePresenter
{
    protected $helpers = ['form', 'stok_helper'];


    public function listProdukOutPenjualan($no_outbound)
    {
        $idGudang     = session()->get('id_gudang');

        $modelOutboundPenjualan = new OutboundPenjualanModel();
        $modelOutboundPenjualanDetail = new OutboundPenjualanDetailModel();
        $modelPenjualan = new PenjualanModel();

        $outboundPenjualan = $modelOutboundPenjualan->where(['no_outbound' => $no_outbound])->first();
        $outboundPenjualanDetail = $modelOutboundPenjualanDetail->getListProduk($outboundPenjualan['id'], $idGudang);
        $penjualan = $modelPenjualan->find($outboundPenjualan['id_penjualan']);

        $data = [
            'penjualan'                 => $penjualan,
            'outbound_penjualan'        => $outboundPenjualan,
            'outbound_penjualan_detail' => $outboundPenjualanDetail
        ];
        return view('warehouse/outbound_penjualan/detail', $data);
    }

    public function update($id = null)
    {
        $modelOutboundPenjualanDetail = new OutboundPenjualanDetailModel();
        $outbound_produk = $modelOutboundPenjualanDetail->find($id);

        $data = [
            'id'                        => $id,
            'qty_dikirim_sekarang'      => $this->request->getPost('qty_dikirim_sekarang'),
            'qty_kurang'                => $this->request->getPost('qty_beli') - ($outbound_produk['qty_dikirim_sebelumnya']  + $this->request->getPost('qty_dikirim_sekarang')),
        ];
        $modelOutboundPenjualanDetail->save($data);

        session()->setFlashdata('pesan', 'Data berhasil diupdate.');
        return redirect()->to('/warehouse-detail_outbound_penjualan/' . $this->request->getPost('no_outbound'));
    }

    public function validasiSave()
    {
        if ($this->request->isAJAX()) {
            $id_outbound_penjualan = $this->request->getVar('id_outbound_penjualan');
            $modelOutboundPenjualanDetail = new OutboundPenjualanDetailModel();
            $produk = $modelOutboundPenjualanDetail->sumDikirimSekarang($id_outbound_penjualan);

            if ($produk['total_qty_dikirim_sekarang'] != 0) {
                $json = ['ok' => 'ok'];
            } else {
                $json = ['null' => null];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }

    public function saveOutbound($id)
    {
        $idGudang     = session()->get('id_gudang');

        $modelProduk = new ProdukModel();
        $modelLokasiProduk = new LokasiProdukModel();

        $modelOutboundPenjualanDetail = new OutboundPenjualanDetailModel();
        $outbound_detail = $modelOutboundPenjualanDetail->where(['id_outbound_penjualan' => $id])->findAll();
        $total_qty_kurang = $modelOutboundPenjualanDetail->sumTotalQtyKurang($id);

        // dd($outbound_detail);

        foreach ($outbound_detail as $ls_produk) {
            $produk = $modelProduk->find($ls_produk['id_produk']);
            $data = [
                'id'    => $produk['id'],
                'stok'  => $produk['stok'] - $ls_produk['qty_dikirim_sekarang'],
            ];
            $modelProduk->save($data);

            for ($i = 1; $i <= $ls_produk['qty_dikirim_sekarang']; $i++) {
                $lokasi_produk = $modelLokasiProduk->getProdukByIdProdukIdGudang($idGudang, $ls_produk['id_produk']);
                foreach ($lokasi_produk as $lok_prod) {
                    if ($lok_prod['stok'] != 0) {
                        $data = [
                            'id'    => $lok_prod['id'],
                            'stok'  => $lok_prod['stok'] - 1,
                        ];
                        $modelLokasiProduk->save($data);
                    }
                }
            }
        }


        $modelOutboundPenjualan = new OutboundPenjualanModel();
        $dt_update = [
            'id'            => $id,
            'status_simpan' => 'Saved'
        ];
        $modelOutboundPenjualan->save($dt_update);


        if ($total_qty_kurang['total_qty_kurang'] == '0') {
            $status_outbound = 'Dikirim Semua';
        } else {
            $status_outbound = 'Dikirim Sebagian';
        }
        $modelPenjualan = new PenjualanModel();
        $updt_penjualan = [
            'id'                => $total_qty_kurang['id_penjualan'],
            'jasa_kirim'        => $this->request->getVar('jasa_kirim'),
            'ongkir'            => intval(str_replace(".", "", $this->request->getVar('ongkir'))),
            'status_outbound'   => $status_outbound
        ];
        $modelPenjualan->save($updt_penjualan);


        session()->setFlashdata('pesan', 'Data outbound Penjualan berhasil disimpan.');
        return redirect()->to('/warehouse-outboundPenjualan');
    }
}
