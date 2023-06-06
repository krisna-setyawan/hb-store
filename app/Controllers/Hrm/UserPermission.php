<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\UserModel;
use App\Models\Hrm\PermissionModel;
use App\Models\Hrm\UserPermissionModel;
use App\Models\Hrm\GroupModel;
use App\Models\Hrm\GroupPermissionModel;
use App\Models\Hrm\GroupUserModel;

use CodeIgniter\RESTful\ResourceController;

class UserPermission extends ResourceController
{

    public function index($userId = null)
    {
        $modelPermission = new PermissionModel();
        $modelUser = new UserModel();
        $modelUserPermission = new UserPermissionModel();
        $user = $modelUser->find($userId);
        $permission = $modelPermission->findAll();
        $userpermission = $modelPermission->getDataPermissionUser($userId);
        $grouppermission = $modelPermission->getDataPermissionGroup($userId);
        $data = [
            'user_permission' => $userpermission,
            'group_permission' => $grouppermission,
            'id_user' => $userId,
            'permission' => $permission,
            'nama_user' => $user->name
        ];
        return view('hrm/user/user_permission/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        if ($this->request->isAJAX()) {

            $modelPermission = new PermissionModel();
            $modelUser = new UserModel();
            $permission = $modelPermission->findAll();

            $data = [
                'id_user'      => $this->request->getPost('id'),
                'permission'   => $permission,
            ];

            $json = [
                'data'          => view('hrm/user/user_permission/add', $data),
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
                    'error_permission' => $validation->getError('permission'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelPermission = new PermissionModel();
                $modelUser = new UserModel();
                $modelUserPermission = new UserPermissionModel();
                $data = [
                    'permission_id' => $this->request->getPost('permission'),
                    'user_id' => $this->request->getPost('user_id'),
                ];
                $modelUserPermission->save($data);

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


    public function delete($permission_id = null, $user_id = null)
    {
        $modelUserPermission = new PermissionModel();

        $modelUserPermission->removePermissionFromUser(intval($permission_id), intval($user_id));

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->back();
    }
}
