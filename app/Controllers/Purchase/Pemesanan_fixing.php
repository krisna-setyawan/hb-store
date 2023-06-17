<?php

namespace App\Controllers\Purchase;

use App\Models\Purchase\PemesananFixingDetailModel;
use App\Models\Purchase\PemesananFixingModel;
use App\Models\Purchase\PemesananModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class Pemesanan_fixing extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];


    public function index()
    {
        return view('purchase/pemesanan_fixing/index');
    }


    public function getDataPemesananOrdered()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $data =  $db->table('pemesanan_fixing')
                ->select('pemesanan_fixing.id, pemesanan_fixing.id_pemesanan, pemesanan_fixing.no_pemesanan, pemesanan_fixing.tanggal, supplier.nama as supplier, pemesanan_fixing.status, users.name as admin')
                ->join('supplier', 'pemesanan_fixing.id_supplier = supplier.id', 'left')
                ->join('users', 'users.id = pemesanan_fixing.id_user', 'left')
                ->whereNotIn('pemesanan_fixing.status', ['Batal', 'Pembelian'])
                ->where('pemesanan_fixing.deleted_at', null);

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                        <a title="Fixing" class="px-2 py-0 btn btn-sm btn-outline-primary" href="' . site_url() . 'purchase-list_fixing/' . $row->no_pemesanan . '">
                            <i class="fa-fw fa-solid fa-pen"></i>
                        </a>
                        
                        <form id="form_delete" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        <button onclick="confirm_delete(' . $row->id_pemesanan . ')" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>';
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function simpanUpdate()
    {
        if ($this->request->isAJAX()) {
            $pemesananFixingModel = new PemesananFixingModel();

            $data_update_pemesanan_fixing = [
                'id'                    => $this->request->getVar('id_pemesanan_fixing'),
                'id_user'               => $this->request->getVar('id_user'),
                'id_gudang'             => $this->request->getVar('id_gudang'),
                'invoice'               => $this->request->getVar('invoice'),
                'no_pemesanan'          => $this->request->getVar('no_pemesanan'),
                'tanggal'               => $this->request->getVar('tanggal'),
                'panjang'               => $this->request->getVar('panjang'),
                'lebar'                 => $this->request->getVar('lebar'),
                'tinggi'                => $this->request->getVar('tinggi'),
                'berat'                 => $this->request->getVar('berat'),
                'carton_koli'           => $this->request->getVar('carton_koli'),
                'exw'                   => intval(str_replace(".", "", $this->request->getVar('exw'))),
                'hf'                    => intval(str_replace(".", "", $this->request->getVar('hf'))),
                'ppn_hf'                => intval(str_replace(".", "", $this->request->getVar('ppn_hf'))),
                'ongkir_port'           => intval(str_replace(".", "", $this->request->getVar('ongkir_port'))),
                'ongkir_laut_udara'     => intval(str_replace(".", "", $this->request->getVar('ongkir_laut_udara'))),
                'ongkir_transit'        => intval(str_replace(".", "", $this->request->getVar('ongkir_transit'))),
                'ongkir_gudang'         => intval(str_replace(".", "", $this->request->getVar('ongkir_gudang'))),
                'bm'                    => intval(str_replace(".", "", $this->request->getVar('bm'))),
                'ppn'                   => intval(str_replace(".", "", $this->request->getVar('ppn'))),
                'pph'                   => intval(str_replace(".", "", $this->request->getVar('pph'))),
                'grand_total'           => $this->request->getVar('grand_total'),
                'catatan'               => $this->request->getVar('catatan'),
            ];
            $pemesananFixingModel->save($data_update_pemesanan_fixing);

            $modelPemesanan = new PemesananModel();
            $data_update_pemesanan = [
                'id'                    => $this->request->getVar('id_pemesanan'),
                'no_pemesanan'          => $this->request->getVar('no_pemesanan'),
                'tanggal'               => $this->request->getVar('tanggal'),
            ];
            $modelPemesanan->save($data_update_pemesanan);

            $json = ['ok' => 'ok'];
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function checkExistProdukPembelian()
    {
        $id_pemesanan_fixing = $this->request->getVar('id_pemesanan_fixing');
        $modelPemesananFixingDetail = new PemesananFixingDetailModel();
        $produk = $modelPemesananFixingDetail->where(['id_pemesanan_fixing' => $id_pemesanan_fixing])->findAll();

        if ($produk) {
            $json = ['ok' => 'ok'];
        } else {
            $json = ['null' => null];
        }
        echo json_encode($json);
    }
}
