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
            $data =  $db->table('pemesanan')
                ->select('pemesanan.id, pemesanan.no_pemesanan, pemesanan.tanggal, supplier.nama as supplier, pemesanan.status, users.name as admin')
                ->join('supplier', 'pemesanan.id_supplier = supplier.id', 'left')
                ->join('users', 'users.id = pemesanan.id_user', 'left')
                ->where('pemesanan.deleted_at', null)
                ->where('pemesanan.status', 'Ordered')
                ->orWhere('pemesanan.status', 'Fixing')
                ->orderBy('pemesanan.id', 'desc');

            return DataTable::of($data)
                ->addNumbering('no')
                ->add('aksi', function ($row) {
                    return '
                        <form action="' . site_url() . 'purchase-pembelian" method="POST" class="d-inline">
                            ' . csrf_field() . '
                            <input type="hidden" name="no_pemesanan" value="' . $row->no_pemesanan . '">
                            <button title="Buat Pembelian" type="submit" class="px-2 py-0 btn btn-sm btn-outline-primary"><i class="fa-fw fa-solid fa-pen"></i></button>
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
