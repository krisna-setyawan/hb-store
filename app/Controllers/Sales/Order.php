<?php

namespace App\Controllers\Sales;

use App\Models\Sales\PenjualanOrderModel;
use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\Config\Services;

class Order extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];


    public function index()
    {
        $modelOrder = new PenjualanOrderModel();
        $order = $modelOrder->where('status', 'Waiting')->findAll();

        $data = [
            'order' => $order
        ];

        return view('sales/order/index', $data);
    }


    public function getDataOrder()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $data =  $db->table('penjualan_order')
                ->select('id, id_pemesanan, no_pemesanan, kode_trx_api, id_perusahaan, nama_perusahaan, tanggal, status, grand_total');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    if ($row->status == 'Waiting') {
                        return '
                        <button title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="detailOrder(' . $row->kode_trx_api . ', \'' . $row->id_perusahaan . '\')">
                            <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button title="Proses" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="detailOrder(' . $row->kode_trx_api . ', \'' . $row->id_perusahaan . '\')">
                            <i class="fa-fw fa-solid fa-arrow-right"></i>
                        </button>
                        <button title="Tolak" class="px-2 py-0 btn btn-sm btn-outline-danger" onclick="tolakOrder(' . $row->kode_trx_api . ', \'' . $row->id_perusahaan . '\', \'' . $row->no_pemesanan . '\')">
                            <i class="fa-fw fa-solid fa-xmark"></i>
                        </button>
                        ';
                    } else {
                        return '
                        <button title="Proses" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="detailOrder(' . $row->kode_trx_api . ', \'' . $row->id_perusahaan . '\')">
                        <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                        </button>
                    ';
                    }
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }


    public function show($kode_trx_api = null, $id_perusahaan = null)
    {
        $client = Services::curlrequest();

        // Get data perusahaan
        $perusahaan = get_data_perushaan($id_perusahaan);

        // Get data pemesanan
        $url_get_pemesanan = $perusahaan['url'] . 'hbapi-get-detail-pemesanan/' . $kode_trx_api;

        $response_get_pemesanan = $client->request('GET', $url_get_pemesanan);
        $status = $response_get_pemesanan->getStatusCode();
        $responseJsonPemesanan = $response_get_pemesanan->getBody();
        $responseArrayPemesanan = json_decode($responseJsonPemesanan, true);

        $modelOrder = new PenjualanOrderModel();
        $order = $modelOrder->where('kode_trx_api', $kode_trx_api)->find();

        $data = [
            'order' => $order[0],
            'pemesanan' => $responseArrayPemesanan['pemesanan'],
            'list_produk' => $responseArrayPemesanan['list_produk'],
            'total_harga' => $responseArrayPemesanan['total_harga'],
        ];

        $json = [
            'data' => view('sales/order/show', $data),
        ];

        echo json_encode($json);
    }


    public function tolakOrder()
    {
        $kode_trx_api = $this->request->getVar('kode_trx_api');
        $id_perusahaan = $this->request->getVar('id_perusahaan');
        $no_pemesanan = $this->request->getVar('no_pemesanan');

        $client = Services::curlrequest();

        // Get data perusahaan
        $perusahaan = get_data_perushaan($id_perusahaan);

        // Sent data tolak order
        $url_tolak_order = $perusahaan['url'] . 'hbapi-terima-tolak-pemesanan';
        $data = [
            'kode_trx_api'      => $kode_trx_api,
        ];
        $response_tolak_order = $client->request('POST', $url_tolak_order, [
            'form_params' => $data
        ]);
        $responseBodyTolakOrder = json_decode($response_tolak_order->getBody(), true);

        if ($response_tolak_order->getStatusCode() === 201) {

            // Sent Notif
            $url_give_notif = $perusahaan['url'] . 'hbapi-give-notif';
            $data_notif = [
                'kode_trx_api'  => $kode_trx_api,
                'untuk'         => 'Pemesanan',
                'notif'         => 'Pemesanan dengan Nomor ' . $no_pemesanan . ' telah ditolak oleh ' . $_ENV['NAMA_PERUSAHAAN']
            ];
            $response_give_notif = $client->request('POST', $url_give_notif, [
                'form_params' => $data_notif
            ]);
            $responseBodyNotif = json_decode($response_give_notif->getBody(), true);

            if ($response_give_notif->getStatusCode() === 201) {
                $status = 'success';
                $keterangan = $responseBodyTolakOrder['messages'];

                $modelOrder = new PenjualanOrderModel();
                $modelOrder->where('kode_trx_api', $kode_trx_api)->set(['status' => 'Tolak',])->update();

                baca_notifikasi($kode_trx_api, 'Order');
            } else {
                $keterangan = "Berhasil menolak order tapi Gagal mengirim Notif " . $responseBodyNotif['error'];
            }
        } else {
            $status = 'error';
            $keterangan = "Gagal menolak order " . $responseBodyTolakOrder['error'];
        }

        $json = [
            'status' => $status,
            'keterangan' => $keterangan,
        ];

        echo json_encode($json);
    }
}
