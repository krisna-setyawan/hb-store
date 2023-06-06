<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\UserModel;
use App\Models\Hrm\GroupModel;
use App\Models\Hrm\GroupUserModel;

use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    public function index()
    {
        $modelUser = new UserModel();
        $user = $modelUser->findAll();

        $data = [
            'user' => $user
        ];

        return view('hrm/user/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
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


    public function view_group_user()
    {
        $modelGroup = new GroupModel();
        $group = $modelGroup->findAll();

        $data = [
            'group' => $group
        ];

        return view('hrm/user/v_group', $data);
    }
    public function view_user_permission()
    {
        $modelUser = new UserModel();
        $user = $modelUser->findAll();

        $data = [
            'user' => $user
        ];

        return view('hrm/user/v_userpermission', $data);
    }
    public function view_group_permission()
    {
        $modelGroup = new GroupModel();
        $group = $modelGroup->findAll();

        $data = [
            'group' => $group
        ];

        return view('hrm/user/v_grouppermission', $data);
    }
}
