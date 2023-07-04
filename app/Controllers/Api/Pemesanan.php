<?php

namespace App\Controllers\Api;

use App\Models\Api\PemesananDetailModel;
use App\Models\Api\PemesananModel;
use CodeIgniter\RESTful\ResourceController;

class Pemesanan extends ResourceController
{
    protected $format       = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($kode_trx_api = null)
    {
        $modelPemesanan = new PemesananModel();
        $modelPemesananDetail = new PemesananDetailModel();

        $pemesanan = $modelPemesanan->getPemesanan($kode_trx_api);

        $data = [
            'message' => 'success',
            'pemesanan' => $pemesanan,
            'list_produk' => $modelPemesananDetail->getListProdukPemesanan($pemesanan['id']),
            'total_harga' => $modelPemesananDetail->sumTotalHargaProduk($pemesanan['id'])
        ];
        return $this->respond($data, 200);
    }



    public function ditolak($kode_trx_api = null)
    {
        $kode_trx_api = $this->request->getVar('kode_trx_api');

        $modelPemesanan = new PemesananModel();

        $modelPemesanan->where('kode_trx_api', $kode_trx_api)->set(['status' => 'Ditolak',])->update();

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => 'Berhasil menolak order.'
        ];
        return $this->respondCreated($response);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
