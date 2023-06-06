<?php

namespace App\Controllers\Resource;

use App\Models\Resource\GudangPJModel;
use CodeIgniter\RESTful\ResourcePresenter;
use Myth\Auth\Models\PermissionModel;

class GudangPJ extends ResourcePresenter
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
        $modelGudangPJ = new GudangPJModel();
        $id_gudang = $this->request->getPost('id_gudang');

        $jml_admin = $modelGudangPJ->where(['id_gudang' => $id_gudang])->countAllResults();

        $data = [
            'id_gudang' => $this->request->getPost('id_gudang'),
            'id_user' => $this->request->getPost('id_user'),
            'urutan' => $jml_admin + 1,
        ];
        $modelGudangPJ->save($data);

        $modelPermissions = new PermissionModel();
        $modelPermissions->addPermissionToUser(13, intval($this->request->getPost('id_user')));

        session()->setFlashdata('pesan', 'Penanggung Jawab Gudang berhasil ditambahkan.');

        return redirect()->to('/resource-gudang/' . $id_gudang . '/edit');
    }


    public function edit($id = null)
    {
        $modelGudangPJ = new GudangPJModel();
        echo json_encode($modelGudangPJ->find($id));
    }


    public function update($id = null)
    {
        $modelGudangPJ = new GudangPJModel();
        $id_gudang = $this->request->getPost('id_gudang');

        $data = [
            'id'            => $id,
            'urutan'        => $this->request->getPost('edit-urutan'),
        ];
        $modelGudangPJ->save($data);

        session()->setFlashdata('pesan', 'Penanggung Jawab Gudang berhasil diedit.');

        return redirect()->to('/resource-gudang/' . $id_gudang . '/edit');
    }


    public function remove($id = null)
    {
        //
    }


    public function delete($id = null)
    {
        $modelGudangPJ = new GudangPJModel();
        $id_gudang = $this->request->getPost('id_gudang');
        $pj = $modelGudangPJ->find($id);
        $urutan_pj = $pj['urutan'];

        $pj_bawahnya = $modelGudangPJ->where(['id_gudang' => $id_gudang, 'urutan >' => $urutan_pj])->findAll();

        foreach ($pj_bawahnya as $pjb) {
            $modelGudangPJ->save([
                'id'        => $pjb['id'],
                'urutan'    => $pjb['urutan'] - 1,
            ]);
        }

        $modelGudangPJ->delete($id);

        $modelPermissions = new PermissionModel();
        $modelPermissions->removePermissionFromUser(13, intval($pj['id_user']));

        session()->setFlashdata('pesan', 'Penanggung Jawab Gudang berhasil dihapus.');
        return redirect()->to('/resource-gudang/' . $id_gudang . '/edit');
    }
}
