<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\UserModel;
use App\Models\Hrm\GroupModel;
use App\Models\Hrm\GroupUserModel;


use CodeIgniter\RESTful\ResourceController;

class ListGroup extends ResourceController
{

    public function index($id_group = null)
    {
        $modelUser = new UserModel();
        $modelGroup = new GroupModel();
        $modelGroupUser = new GroupUserModel();
        $group = $modelGroup->find($id_group);
        $user = $modelUser->findAll();
        $groupuser = $modelGroupUser
            ->select('auth_groups_users.user_id,auth_groups_users.group_id,us.id as id_user, us.name, us.email, us.username')
            ->join('users as us', 'us.id = auth_groups_users.user_id', 'LEFT')
            ->where('auth_groups_users.group_id', $id_group)
            ->findAll();
        $data = [
            'group' => $groupuser,
            'id_group' => $id_group,
            'user'   => $user,
            'nama_group' => $group['name']
        ];
        return view('hrm/user/group/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        if ($this->request->isAJAX()) {

            $modelUser = new UserModel();
            $modelGroup = new GroupModel();
            $user = $modelUser->findAll();

            $data = [
                'id_group' => $this->request->getPost('id'),
                'user'   => $user,
            ];

            $json = [
                'data'          => view('hrm/user/group/add', $data),
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
                'user'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'user harus diisi',
                    ]
                ]
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_user_id' => $validation->getError('user_id'),

                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelUser = new UserModel();
                $modelGroup = new GroupModel();
                $modelGroupUser = new GroupUserModel();
                $data = [
                    'user_id' => $this->request->getPost('user'),
                    'group_id' => $this->request->getPost('group_id'),
                ];
                $modelGroupUser->save($data);
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


    public function delete($user_id = null, $group_id = null)
    {
        $modelGroupUser = new GroupUserModel();

        $modelGroupUser->where(['user_id' => $user_id, 'group_id' => $group_id])->delete();

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->back();
    }
}
