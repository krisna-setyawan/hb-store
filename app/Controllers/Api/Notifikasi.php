<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Notifikasi extends ResourceController
{
    protected $modelName    = 'App\Models\Api\NotifikasiModel';
    protected $format       = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($sku = null)
    {
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
        $dataInsert = [
            'untuk' => $this->request->getVar('untuk'),
            'notif'  => $this->request->getVar('notif'),
        ];
        $this->model->insert($dataInsert);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => 'Berhasil kirim notifikasi.'
        ];
        return $this->respondCreated($response);
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
