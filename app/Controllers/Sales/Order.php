<?php

namespace App\Controllers\Sales;

use App\Models\Sales\PenjualanOrderModel;
use CodeIgniter\RESTful\ResourcePresenter;
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

        dd($responseArrayPemesanan);

        // $data = [];

        // $json = [
        //     'data' => view('purchase/pemesanan/show', $data),
        // ];

        // echo json_encode($json);
    }
}
