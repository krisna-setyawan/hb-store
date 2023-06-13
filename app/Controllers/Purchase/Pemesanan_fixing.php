<?php

namespace App\Controllers\Purchase;

use CodeIgniter\RESTful\ResourcePresenter;
use \Hermawan\DataTables\DataTable;

class Pemesanan_fixing extends ResourcePresenter
{
    protected $helpers = ['form', 'nomor_auto_helper'];


    public function index()
    {
        return view('purchase/pemesanan_fixing/index');
    }


    public function getDataPemesananOrdered()
    {
        if ($this->request->isAJAX()) {
            $db = \Config\Database::connect();
            $data =  $db->table('pemesanan_fixing')
                ->select('pemesanan_fixing.id, pemesanan_fixing.no_pemesanan, pemesanan_fixing.tanggal, supplier.nama as supplier, pemesanan_fixing.status, users.name as admin')
                ->join('supplier', 'pemesanan_fixing.id_supplier = supplier.id', 'left')
                ->join('users', 'users.id = pemesanan_fixing.id_user', 'left')
                ->where('pemesanan_fixing.deleted_at', null)
                ->where('pemesanan_fixing.status !=', 'Batal')
                ->orWhere('pemesanan_fixing.status !=', 'Pembelian')
                ->orderBy('pemesanan_fixing.id', 'desc');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                        <a href"' . site_url() . 'purchase-list_fixing/' . $row->no_pemesanan . '">
                            <button title="Fixing" class="px-2 py-0 btn btn-sm btn-outline-primary">    
                                <i class="fa-fw fa-solid fa-pen"></i>
                            </button>
                        </a>
                        
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

// <form action="' . site_url() . 'purchase-pembelian" method="POST" class="d-inline">
// ' . csrf_field() . '
// <input type="hidden" name="no_pemesanan" value="' . $row->no_pemesanan . '">
// <button title="Buat Pembelian" type="submit" class="px-2 py-0 btn btn-sm btn-outline-primary"><i class="fa-fw fa-solid fa-pen"></i></button>
// </form>
