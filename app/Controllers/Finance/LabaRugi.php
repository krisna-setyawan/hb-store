<?php

namespace App\Controllers\Finance;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Finance\JurnalModel;
use \Hermawan\DataTables\DataTable;

class LabaRugi extends ResourcePresenter
{
    public function index()
    {
        $data = [
            'tglAwal'   => date('Y-01-01'),
            'tglAkhir'  => date('Y-m-d'),
        ];
        return view('finance/laporan/labarugi/index', $data);
    }


    public function getListLabaRugi()
    {
        $tglAwal           = $this->request->getGet('tglAwal');
        $tglAkhir          = $this->request->getGet('tglAkhir');

        $modelJurnal                 = new JurnalModel();
        //Pendapatan

        $pendapatanPendapatan   = $modelJurnal->getNeraca(['nama' => 'Pendapatan'], $tglAwal, $tglAkhir);
        $pendapatanLainnya      = $modelJurnal->getNeraca(['nama' => 'Pendapatan Lainnya'], $tglAwal, $tglAkhir);
        //Beban
        $bebanHargaPokok        = $modelJurnal->getNeraca(['nama' => 'Harga Pokok Penjualan'], $tglAwal, $tglAkhir);
        //Biaya
        $biayaBeban             = $modelJurnal->getNeraca(['nama' => 'Beban'], $tglAwal, $tglAkhir);
        $biayaBebanLainnya      = $modelJurnal->getNeraca(['nama' => 'Beban Lainnya'], $tglAwal, $tglAkhir);

        $data = [
            'tglAkhir'              => $tglAkhir,
            'pendapatanPendapatan'  => $pendapatanPendapatan,
            'pendapatanLainnya'     => $pendapatanLainnya,
            'bebanHargaPokok'       => $bebanHargaPokok,
            'biayaBeban'            => $biayaBeban,
            'biayaBebanLainnya'     => $biayaBebanLainnya
        ];

        $json = [
            'data'   => view('finance/laporan/labarugi/listLabaRugi', $data),
        ];

        echo json_encode($json);
    }
}
