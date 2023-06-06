<?php

namespace App\Controllers\Sales;

use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class Penawaran_fixing extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];


    public function index()
    {
        return view('sales/penawaran_fixing/index');
    }


    public function getDataPenawaranOrdered()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $data =  $db->table('penawaran')
                ->select('penawaran.id, penawaran.no_penawaran, penawaran.tanggal, customer.nama as customer, penawaran.status, users.name as admin')
                ->join('customer', 'penawaran.id_customer = customer.id', 'left')
                ->join('users', 'users.id = penawaran.id_user', 'left')
                ->where('penawaran.deleted_at', null)
                ->where('penawaran.status', 'Ordered')
                ->orWhere('penawaran.status', 'Fixing')
                ->orderBy('penawaran.id', 'desc');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                        <form action="' . site_url() . 'sales-penjualan" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            <input type="hidden" name="no_penawaran" value="' . $row->no_penawaran . '">
                            <button title="Buat Penjualan" type="submit" class="px-2 py-0 btn btn-sm btn-outline-primary"><i class="fa-fw fa-solid fa-pen"></i></button>
                        </form>
                        
                        <form id="form_delete" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                        <button onclick="confirm_delete(' . $row->id . ')" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>';
                }, 'last')
                ->toJson(true);
        } else {
            return "Tidak bisa load data.";
        }
    }
}
