<?php

namespace App\Controllers\Resource;

use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\Config\Services;

class Perusahaan extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];

    public function index()
    {
        // Membuat objek HTTP client
        $client = Services::curlrequest();

        $url = $_ENV['URL_API'] . 'public/get-perusahaan';
        $response = $client->request('GET', $url);
        $status = $response->getStatusCode();

        // Mengambil body respons sebagai string
        $responseJson = $response->getBody();
        $responseArray = json_decode($responseJson, true);
        $perusahaan = $responseArray['data_perusahaan'];

        $data = [
            'perusahaan' => $perusahaan
        ];

        return view('resource/perusahaan/index', $data);
    }


    public function show($id = null)
    {
        // Membuat objek HTTP client
        $client = Services::curlrequest();

        $url = $_ENV['URL_API'] . 'public/get-perusahaan/' . $id;
        $response = $client->request('GET', $url);
        $status = $response->getStatusCode();

        // Mengambil body respons sebagai string
        $responseJson = $response->getBody();
        $responseArray = json_decode($responseJson, true);
        $perusahaan = $responseArray['data_perusahaan'];

        $json = [
            'perusahaan' => $perusahaan[0]
        ];

        echo json_encode($json);
    }


    public function produk($id_perusahaan = null)
    {
        $client = Services::curlrequest();
        $perusahaan = get_data_perushaan($id_perusahaan);

        // produk
        $url_produk = $perusahaan['url'] . 'hbapi-get-produks';
        $response_produk = $client->request('GET', $url_produk);
        $status = $response_produk->getStatusCode();
        $responseJsonProduk = $response_produk->getBody();
        $responseArrayProduk = json_decode($responseJsonProduk, true);
        $produk = $responseArrayProduk['products'];

        $db = \Config\Database::connect();
        $builder_produk_kategori = $db->table('produk_kategori');

        $data = [
            'perusahaan'    => $perusahaan,
            'produk'        => $produk,
            'kategori'      => $builder_produk_kategori->get()->getResultArray(),
        ];

        return view('resource/perusahaan/list_produk', $data);
    }
}
