<?php

namespace App\Controllers\Finance;

use App\Controllers\BaseController;

class Menu extends BaseController
{
    public function Akun()
    {
        return view('finance/menu/menuAkun');
    }


    public function Laporan()
    {
        return view('finance/menu/menuLaporan');
    }
}
