<?php

namespace App\Controllers\Hrm;

use Myth\Auth\Models\PermissionModel;
use App\Models\Hrm\GroupModel;
use App\Models\Hrm\GroupPermissionModel;
use CodeIgniter\RESTful\ResourceController;

class GroupPermission extends ResourceController
{
    public function index($id_group = null)
    {
        $modelPermission = new PermissionModel();
        $modelGroup = new GroupModel();
        $modelGroupPermission = new GroupPermissionModel();
        $permission = $modelPermission->findAll();
        $group = $modelGroup->find($id_group);
        $grouppermission = $modelGroupPermission
            ->select('ap.id, ap.name, ap.description, auth_groups_permissions.permission_id, auth_groups_permissions.group_id')
            ->join('auth_permissions as ap', 'ap.id = auth_groups_permissions.permission_id', 'LEFT')
            ->where('auth_groups_permissions.group_id', $id_group)
            ->findAll();
        $data = [
            'group' => $grouppermission,
            'id_group' => $id_group,
            'permission'   => $permission,
            'nama_group' => $group['name']
        ];
        return view('hrm/user/group_permission/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        if ($this->request->isAJAX()) {

            $modelPermission = new PermissionModel();
            $modelGroup = new GroupModel();
            $permission = $modelPermission->findAll();

            $data = [
                'id_group' => $this->request->getPost('id'),
                'permission'   => $permission,
            ];


            $json = [
                'data'          => view('hrm/user/group_permission/add', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function create()
    {
        if ($this->request->isAJAX()) {
            $validasi = [
                'permission'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'permission harus diisi',
                    ]
                ]
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_permission_id' => $validation->getError('permission_id'),

                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelpermission = new permissionModel();
                $modelGroup = new GroupModel();
                $modelGroupPermission = new GroupPermissionModel();
                $data = [
                    'permission_id' => $this->request->getPost('permission'),
                    'group_id' => $this->request->getPost('group_id'),
                ];
                $modelGroupPermission->save($data);
                $json = [
                    'success' => 'Berhasil menambah data karyawan'
                ];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function edit($id = null)
    {
        //
    }


    public function update($id = null)
    {
        //
    }


    public function delete($permission_id = null, $group_id = null)
    {
        $modelGroupPermission = new GroupPermissionModel();

        $modelGroupPermission->where(['permission_id' => $permission_id, 'group_id' => $group_id])->delete();

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->back();
    }
}
