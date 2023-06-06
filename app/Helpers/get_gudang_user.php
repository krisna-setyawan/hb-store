<?php

use App\Models\Warehouse\GudangPJModel;

function getIdGudangByIdUser($id_user)
{
    $modelGudangPJ = new GudangPJModel();
    return $modelGudangPJ->getGudangByPJ($id_user);
}
