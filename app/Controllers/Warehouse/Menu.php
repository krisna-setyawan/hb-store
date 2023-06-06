<?php

namespace App\Controllers\Warehouse;

use App\Controllers\BaseController;
use App\Models\Warehouse\GudangModel;

class Menu extends BaseController
{
    public function RuanganRak($id_gudang)
    {
        $modelGudang = new GudangModel();

        $gudang = $modelGudang->getGudangWithAlamat($id_gudang);
        $data = [
            'id_gudang' => $id_gudang,
            'nama_gudang' => $gudang['nama']
        ];

        return view('warehouse/menu/menuruanganrak', $data);
    }


    public function Inbound($id_gudang)
    {
        session()->set('id_gudang', $id_gudang);

        $modelGudang = new GudangModel();

        $gudang = $modelGudang->getGudangWithAlamat($id_gudang);
        $data = [
            'id_gudang' => $id_gudang,
            'nama_gudang' => $gudang['nama']
        ];

        return view('warehouse/menu/inbound', $data);
    }


    public function Outbound($id_gudang)
    {
        session()->set('id_gudang', $id_gudang);

        $modelGudang = new GudangModel();

        $gudang = $modelGudang->getGudangWithAlamat($id_gudang);
        $data = [
            'id_gudang' => $id_gudang,
            'nama_gudang' => $gudang['nama']
        ];

        return view('warehouse/menu/outbound', $data);
    }
}
