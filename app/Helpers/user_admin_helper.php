<?php

use App\Models\Resource\UserModel;

function getKaryawanByIdUser($id)
{
    $modelUser = new UserModel();
    return $modelUser->getKaryawanByIdUser($id);
}
