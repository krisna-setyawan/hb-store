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
    public function show($no_pemesanan = null)
    {
        $modelPemesanan = new PemesananModel();
        $modelPemesananDetail = new PemesananDetailModel();

        $pemesanan = $modelPemesanan->getPemesanan($no_pemesanan);

        $data = [
            'message' => 'success',
            'pemesanan' => $pemesanan,
            'list_produk' => $modelPemesananDetail->getListProdukPemesanan($pemesanan['id']),
            'total_harga' => $modelPemesananDetail->sumTotalHargaProduk($pemesanan['id'])
        ];
        return $this->respond($data, 200);
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
