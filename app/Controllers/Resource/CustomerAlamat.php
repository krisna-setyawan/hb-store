<?php

namespace App\Controllers\Resource;

use App\Models\Resource\CustomerAlamatModel;
use CodeIgniter\RESTful\ResourcePresenter;

class CustomerAlamat extends ResourcePresenter
{
    public function index()
    {
        //
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        //
    }


    public function create()
    {
        $modelCustomerAlamat = new CustomerAlamatModel();
        $id_customer = $this->request->getPost('id_customer');

        $data = [
            'id_customer' => $this->request->getPost('id_customer'),
            'nama' => $this->request->getPost('nama'),
            'id_provinsi' => $this->request->getPost('id_provinsi'),
            'id_kota' => $this->request->getPost('id_kota'),
            'id_kecamatan' => $this->request->getPost('id_kecamatan'),
            'id_kelurahan' => $this->request->getPost('id_kelurahan'),
            'detail_alamat' => $this->request->getPost('detail_alamat'),
            'penerima' => $this->request->getPost('penerima'),
            'no_telp' => $this->request->getPost('no_telp'),
        ];
        $modelCustomerAlamat->save($data);

        session()->setFlashdata('pesan', 'Alamat Baru berhasil ditambahkan.');

        return redirect()->to('/resource-customer/' . $id_customer . '/edit');
    }


    public function edit($id = null)
    {
        //
    }


    public function update($id = null)
    {
        //
    }


    public function remove($id = null)
    {
        //
    }


    public function delete($id = null)
    {
        $id_customer = $this->request->getPost('id_customer');

        $modelCustomerAlamat = new CustomerAlamatModel();

        $modelCustomerAlamat->delete($id);

        session()->setFlashdata('pesan', 'Alamat berhasil dihapus.');
        return redirect()->to('/resource-customer/' . $id_customer . '/edit');
    }
}
