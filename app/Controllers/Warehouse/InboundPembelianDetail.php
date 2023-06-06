<?php

namespace App\Controllers\Warehouse;

use App\Models\Warehouse\InboundPembelianDetailModel;
use App\Models\Warehouse\InboundPembelianModel;
use App\Models\Warehouse\PembelianModel;
use App\Models\Warehouse\ProdukModel;
use CodeIgniter\RESTful\ResourcePresenter;

class InboundPembelianDetail extends ResourcePresenter
{
    protected $helpers = ['form', 'stok_helper'];


    public function listProdukInbPembelian($no_inbound)
    {
        $modelInboundPembelian = new InboundPembelianModel();
        $modelInboundPembelianDetail = new InboundPembelianDetailModel();

        $inboundPembelian = $modelInboundPembelian->where(['no_inbound' => $no_inbound])->first();
        $inboundPembelianDetail = $modelInboundPembelianDetail->getListProduk($inboundPembelian['id']);

        $data = [
            'inbound_pembelian'         => $inboundPembelian,
            'inbound_pembelian_detail'  => $inboundPembelianDetail
        ];
        return view('warehouse/inbound_pembelian/detail', $data);
    }

    public function update($id = null)
    {
        $modelInboundPembelianDetail = new InboundPembelianDetailModel();
        $inbound_produk = $modelInboundPembelianDetail->find($id);

        $data = [
            'id'                        => $id,
            'qty_diterima_sekarang'     => $this->request->getPost('qty_diterima_sekarang'),
            'qty_kurang'                => $this->request->getPost('qty_beli') - ($inbound_produk['qty_diterima_sebelumnya']  + $this->request->getPost('qty_diterima_sekarang')),
        ];
        $modelInboundPembelianDetail->save($data);

        session()->setFlashdata('pesan', 'Data berhasil diupdate.');
        return redirect()->to('/warehouse-detail_inbound_pembelian/' . $this->request->getPost('no_inbound'));
    }

    public function validasiSave()
    {
        if ($this->request->isAJAX()) {
            $id_inbound_pembelian = $this->request->getVar('id_inbound_pembelian');
            $modelInboundPembelianDetail = new InboundPembelianDetailModel();
            $produk = $modelInboundPembelianDetail->sumDiterimaSekarang($id_inbound_pembelian);

            if ($produk['total_qty_diterima_sekarang'] != 0) {
                $json = ['ok' => 'ok'];
            } else {
                $json = ['null' => null];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }

    public function saveInbound($id)
    {
        $modelProduk = new ProdukModel();
        $modelInboundPembelianDetail = new InboundPembelianDetailModel();
        $inbound_detail = $modelInboundPembelianDetail->where(['id_inbound_pembelian' => $id])->findAll();
        $total_qty_kurang = $modelInboundPembelianDetail->sumTotalQtyKurang($id);


        foreach ($inbound_detail as $ls_produk) {
            $produk = $modelProduk->find($ls_produk['id_produk']);
            $data = [
                'id'    => $produk['id'],
                'stok'  => $produk['stok'] + $ls_produk['qty_diterima_sekarang'],
            ];
            $modelProduk->save($data);
        }


        $modelInboundPembelian = new InboundPembelianModel();
        $dt_update = [
            'id'            => $id,
            'status_simpan' => 'Saved'
        ];
        $modelInboundPembelian->save($dt_update);


        if ($total_qty_kurang['total_qty_kurang'] == '0') {
            $status_inbound = 'Diterima Semua';
        } else {
            $status_inbound = 'Diterima Sebagian';
        }
        $modelPembelian = new PembelianModel();
        $updt_pembelian = [
            'id'                => $total_qty_kurang['id_pembelian'],
            'status_inbound'    => $status_inbound
        ];
        $modelPembelian->save($updt_pembelian);


        session()->setFlashdata('pesan', 'Data Inbound Pembelian berhasil disimpan.');
        return redirect()->to('/warehouse-inboundPembelian');
    }
}
