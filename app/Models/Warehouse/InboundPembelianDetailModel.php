<?php

namespace App\Models\Warehouse;

use CodeIgniter\Model;


class InboundPembelianDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'inbound_pembelian_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pembelian',
        'id_inbound_pembelian',
        'id_produk',
        'qty_beli',
        'qty_diterima_sebelumnya',
        'qty_diterima_sekarang',
        'qty_kurang'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    function getListProduk($id_inbound_pembelian)
    {
        $data =  $this->db->table($this->table)
            ->select('inbound_pembelian_detail.*, produk.nama as produk, produk.sku as sku')
            ->join('produk', 'inbound_pembelian_detail.id_produk = produk.id', 'left')
            ->where('inbound_pembelian_detail.id_inbound_pembelian', $id_inbound_pembelian)
            ->get()
            ->getResultArray();

        return $data;
    }


    public function getListProdukdanTotalDiterima($id_pembelian)
    {
        $data =  $this->db->table($this->table)
            ->select('inbound_pembelian_detail.*, produk.nama as produk, produk.sku as sku, SUM(qty_diterima_sekarang) as sudah_diterima')
            ->join('produk', 'inbound_pembelian_detail.id_produk = produk.id', 'left')
            ->where('inbound_pembelian_detail.id_pembelian', $id_pembelian)
            ->groupBy('inbound_pembelian_detail.id_produk')
            ->orderBy('inbound_pembelian_detail.id', 'asc')
            ->get()
            ->getResultArray();

        return $data;
    }


    public function sumTotalQtyKurang($id_inbound_pembelian)
    {
        $data =  $this->db->table($this->table)
            ->select('inbound_pembelian_detail.id_pembelian, sum(qty_kurang) as total_qty_kurang')
            ->where('inbound_pembelian_detail.id_inbound_pembelian', $id_inbound_pembelian)
            ->groupBy('inbound_pembelian_detail.id_inbound_pembelian ')
            ->get()
            ->getRowArray();

        return $data;
    }


    public function sumDiterimaSekarang($id_inbound_pembelian)
    {
        $data =  $this->db->table($this->table)
            ->select('inbound_pembelian_detail.id_pembelian, sum(qty_diterima_sekarang) as total_qty_diterima_sekarang')
            ->where('inbound_pembelian_detail.id_inbound_pembelian', $id_inbound_pembelian)
            ->groupBy('inbound_pembelian_detail.id_inbound_pembelian ')
            ->get()
            ->getRowArray();

        return $data;
    }
}
