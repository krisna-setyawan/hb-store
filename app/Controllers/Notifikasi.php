<?php

namespace App\Controllers;

use App\Models\Api\NotifikasiModel;

class Notifikasi extends BaseController
{
    public function index()
    {
        if ($this->request->isAJAX()) {
            $modelNotifikasi = new NotifikasiModel();

            $notif = $modelNotifikasi->where('status', 'Unread')->findAll();
            $jml_data = $modelNotifikasi->where('status', 'Unread')->countAllResults();

            $json = [
                'notif' => $notif,
                'jml' => $jml_data,
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }
}
