<?php

namespace App\Controllers\Finance;

use CodeIgniter\RESTful\ResourcePresenter;
use App\Models\Finance\JurnalModel;
use \Hermawan\DataTables\DataTable;

class Neraca extends ResourcePresenter
{
    public function index()
    {
        $data = [
            'tglNeraca' => date('Y-m-d')
        ];

        return view('finance/laporan/neraca/index', $data);
    }


    public function getListNeraca()
    {
        $tglAwal                     = date('Y-01-01');
        $tglNeraca                   = $this->request->getGet('tglNeraca');
        $totalPendapatan             = 0;
        $totalPendapatanLainnya      = 0;
        $totalHargaPokok             = 0;
        $totalBeban                  = 0;
        $totalBebanLainnya           = 0;

        $modelJurnal                 = new JurnalModel();
        //Asset
        $assetKas                    = $modelJurnal->getNeraca(['nama' => 'Kas & Bank'], $tglAwal, $tglNeraca);
        $assetPiutang                = $modelJurnal->getNeraca(['nama' => 'Piutang'], $tglAwal, $tglNeraca);
        $assetPersediaan             = $modelJurnal->getNeraca(['nama' => 'Persediaan'], $tglAwal, $tglNeraca);
        $assetAktivaLancar           = $modelJurnal->getNeraca(['nama' => 'Aktiva Lancar Lainnya'], $tglAwal, $tglNeraca);
        $assetAktivaTetap            = $modelJurnal->getNeraca(['nama' => 'Aktiva Tetap'], $tglAwal, $tglNeraca);
        $assetDepresiasiAmortisasi   = $modelJurnal->getNeraca(['nama' => 'Depresiasi dan Amortisasi'], $tglAwal, $tglNeraca);
        $assetAktivaLainnya          = $modelJurnal->getNeraca(['nama' => 'Aktiva Lainnya'], $tglAwal, $tglNeraca);
        //Hutang
        $hutangAkun                  = $modelJurnal->getNeraca(['nama' => 'Hutang'], $tglAwal, $tglNeraca);
        $hutangKewajibanLancar       = $modelJurnal->getNeraca(['nama' => 'Kewajiban Lancar Lainnya'], $tglAwal, $tglNeraca);
        $hutangKewajibanPanjang      = $modelJurnal->getNeraca(['nama' => 'Kewajiban Jangka Panjang'], $tglAwal, $tglNeraca);
        //Modal
        $modalEkuitas                = $modelJurnal->getNeraca(['nama' => 'Ekuitas'], $tglAwal, $tglNeraca);

        //Pendapatan
        $pendapatanPendapatan        = $modelJurnal->getNeraca(['nama' => 'Pendapatan'], $tglAwal, $tglNeraca);
        $pendapatanPendapatanLainnya = $modelJurnal->getNeraca(['nama' => 'Pendapatan Lainnya'], $tglAwal, $tglNeraca);
        //Beban
        $bebanHargaPokok             = $modelJurnal->getNeraca(['nama' => 'Harga Pokok Penjualan'], $tglAwal, $tglNeraca);
        //Biaya
        $biayaBeban                  = $modelJurnal->getNeraca(['nama' => 'Beban'], $tglAwal, $tglNeraca);
        $biayaBebanLainnya           = $modelJurnal->getNeraca(['nama' => 'Beban Lainnya'], $tglAwal, $tglNeraca);

        foreach ($pendapatanPendapatan as $pp) {
            $totalPendapatan += $pp['kredit'] - $pp['debit'];
        }
        foreach ($pendapatanPendapatanLainnya  as $ppl) {
            $totalPendapatanLainnya += $ppl['kredit'] - $ppl['debit'];
        }
        foreach ($bebanHargaPokok  as $bhp) {
            $totalHargaPokok += $bhp['debit'] - $bhp['kredit'];
        }
        foreach ($biayaBeban   as $bb) {
            $totalBeban += $bb['debit'] - $bb['kredit'];
        }
        foreach ($biayaBebanLainnya as $bbl) {
            $totalBebanLainnya += $bbl['debit'] - $bbl['kredit'];
        }

        $labaKotor                   = ($totalPendapatan + $totalPendapatanLainnya) - $totalHargaPokok;
        $labaBersih                  = $labaKotor - ($totalBeban + $totalBebanLainnya);

        $totalSebelumPendapatan      = 0;
        $totalSebelumLainnya         = 0;
        $totalSebelumHargaPokok      = 0;
        $totalSebelumBeban           = 0;
        $totalSebelumBebanLainnya    = 0;

        $pendapatan                  = $modelJurnal->getSumPeriodeSebelum(['nama' => 'Pendapatan'], $tglAwal);
        $pendapatanLainnya           = $modelJurnal->getSumPeriodeSebelum(['nama' => 'Pendapatan Lainnya'], $tglAwal);
        $hargaPokok                  = $modelJurnal->getSumPeriodeSebelum(['nama' => 'Harga Pokok Penjualan'], $tglAwal);
        $beban                       = $modelJurnal->getSumPeriodeSebelum(['nama' => 'Beban'], $tglAwal);
        $bebanLainnya                = $modelJurnal->getSumPeriodeSebelum(['nama' => 'Beban Lainnya'], $tglAwal);

        foreach ($pendapatan as $p) {
            $totalSebelumPendapatan += $p['kredit'] - $p['debit'];
        }
        foreach ($pendapatanLainnya  as $pl) {
            $totalSebelumLainnya += $pl['kredit'] - $pl['debit'];
        }
        foreach ($hargaPokok  as $hp) {
            $totalSebelumHargaPokok += $hp['debit'] - $hp['kredit'];
        }
        foreach ($beban   as $b) {
            $totalSebelumBeban += $b['debit'] - $b['kredit'];
        }
        foreach ($bebanLainnya as $bl) {
            $totalSebelumBebanLainnya += $bl['debit'] - $bl['kredit'];
        }

        $labaKotorSebelum            = ($totalSebelumPendapatan + $totalSebelumLainnya) - $totalSebelumHargaPokok;
        $labaBersihSebelum           = $labaKotorSebelum - ($totalSebelumBeban + $totalSebelumBebanLainnya);

        $data = [
            'tglNeraca'                   => $tglNeraca,
            //Asset
            'assetKas'                    => $assetKas,
            'assetPiutang'                => $assetPiutang,
            'assetPersediaan'             => $assetPersediaan,
            'assetAktivaLancar'           => $assetAktivaLancar,
            'assetAktivaTetap'            => $assetAktivaTetap,
            'assetDepresiasiAmortisasi'   => $assetDepresiasiAmortisasi,
            'assetAktivaLainnya'          => $assetAktivaLainnya,
            //Hutang
            'hutangAkun'                  => $hutangAkun,
            'hutangKewajibanLancar'       => $hutangKewajibanLancar,
            'hutangKewajibanPanjang'      => $hutangKewajibanPanjang,
            //Modal
            'modalEkuitas'                => $modalEkuitas,
            'labaBersih'                  => $labaBersih,
            'labaBersihSebelum'           => $labaBersihSebelum
        ];

        $json = [
            'data'   => view('finance/laporan/neraca/listNeraca', $data),
        ];

        echo json_encode($json);
    }
}
