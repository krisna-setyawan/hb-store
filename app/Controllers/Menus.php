<?php

namespace App\Controllers;

use App\Models\Warehouse\GudangPJModel;

class Menus extends BaseController
{
    public function data_master()
    {
        return view('menus/data_master');
    }

    public function hrm()
    {
        return view('menus/hrm');
    }

    public function finance()
    {
        return view('menus/finance');
    }

    public function purchase()
    {
        return view('menus/purchase');
    }

    public function sales()
    {
        return view('menus/sales');
    }

    public function warehouse()
    {
        $model_gudangPJ = new GudangPJModel();

        $data['list_gudang_user'] = $model_gudangPJ->getListGudangByPJ(user()->id);
        return view('menus/warehouse', $data);
    }
}
