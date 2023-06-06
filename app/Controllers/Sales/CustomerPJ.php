<?php

namespace App\Controllers\Sales;

use App\Models\Sales\CustomerPJModel;
use App\Models\Sales\PermissionModel;
// use Myth\Auth\Models\PermissionModel;
use CodeIgniter\RESTful\ResourcePresenter;

class CustomerPJ extends ResourcePresenter
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
        $modelCustomerPJ = new CustomerPJModel();
        $id_customer = $this->request->getPost('id_customer');

        $jml_admin = $modelCustomerPJ->where(['id_customer' => $id_customer])->countAllResults();

        $data = [
            'id_customer' => $this->request->getPost('id_customer'),
            'id_user' => $this->request->getPost('id_user'),
            'urutan' => $jml_admin + 1,
        ];
        $modelCustomerPJ->save($data);

        $modelPermissions = new PermissionModel();
        $modelPermissions->addPermissionToUser(12, intval($this->request->getPost('id_user')));

        session()->setFlashdata('pesan', 'Admin Customer berhasil ditambahkan.');

        return redirect()->to('/sales-customer/' . $id_customer . '/edit');
    }


    public function edit($id = null)
    {
        $modelCustomerPJ = new CustomerPJModel();
        echo json_encode($modelCustomerPJ->find($id));
    }


    public function update($id = null)
    {
        $modelCustomerPJ = new CustomerPJModel();
        $id_customer = $this->request->getPost('id_customer');

        $data = [
            'id'            => $id,
            'urutan'        => $this->request->getPost('edit-urutan'),
        ];
        $modelCustomerPJ->save($data);

        session()->setFlashdata('pesan', 'Admin Customer berhasil diedit.');

        return redirect()->to('/sales-customer/' . $id_customer . '/edit');
    }


    public function remove($id = null)
    {
        //
    }


    public function delete($id = null)
    {
        $modelCustomerPJ = new CustomerPJModel();
        $id_customer = $this->request->getPost('id_customer');
        $pj = $modelCustomerPJ->find($id);
        $urutan_pj = $pj['urutan'];

        $pj_bawahnya = $modelCustomerPJ->where(['id_customer' => $id_customer, 'urutan >' => $urutan_pj])->findAll();

        foreach ($pj_bawahnya as $pjb) {
            $modelCustomerPJ->save([
                'id'        => $pjb['id'],
                'urutan'    => $pjb['urutan'] - 1,
            ]);
        }

        $modelCustomerPJ->delete($id);

        $modelPermissions = new PermissionModel();
        $modelPermissions->removePermissionFromUser(12, intval($pj['id_user']));

        session()->setFlashdata('pesan', 'Admin Customer berhasil dihapus.');
        return redirect()->to('/sales-customer/' . $id_customer . '/edit');
    }
}
