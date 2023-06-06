<?php

namespace App\Models\Warehouse;

use CodeIgniter\Model;


class OutboundPenjualanDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'outbound_penjualan_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_penjualan',
        'id_outbound_penjualan',
        'id_produk',
        'qty_beli',
        'qty_dikirim_sebelumnya',
        'qty_dikirim_sekarang',
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


    function getListProduk($id_outbound_penjualan, $idGudang)
    {
        $data =  $this->db->table($this->table)
            ->select('outbound_penjualan_detail.*, produk.nama as produk, produk.sku as sku, produk.satuan as satuan, sum(lokasi_produk.stok) as stok')
            ->join('produk', 'outbound_penjualan_detail.id_produk = produk.id', 'left')
            ->join('lokasi_produk', 'outbound_penjualan_detail.id_produk = lokasi_produk.id_produk', 'left')
            ->where('outbound_penjualan_detail.id_outbound_penjualan', $id_outbound_penjualan)
            ->where('lokasi_produk.id_gudang', $idGudang)
            ->groupBy('lokasi_produk.id_produk')
            ->get()
            ->getResultArray();

        return $data;
    }

    function getListProdukForDetail($id_outbound_penjualan)
    {
        $data =  $this->db->table($this->table)
            ->select('outbound_penjualan_detail.*, produk.nama as produk, produk.sku as sku, produk.satuan as satuan, sum(lokasi_produk.stok) as stok')
            ->join('produk', 'outbound_penjualan_detail.id_produk = produk.id', 'left')
            ->join('lokasi_produk', 'outbound_penjualan_detail.id_produk = lokasi_produk.id_produk', 'left')
            ->where('outbound_penjualan_detail.id_outbound_penjualan', $id_outbound_penjualan)
            ->groupBy('lokasi_produk.id_produk')
            ->get()
            ->getResultArray();

        return $data;
    }


    public function getListProdukdanTotalDikirim($id_penjualan)
    {
        $data =  $this->db->table($this->table)
            ->select('outbound_penjualan_detail.*, produk.nama as produk, produk.sku as sku, SUM(qty_dikirim_sekarang) as sudah_dikirim')
            ->join('produk', 'outbound_penjualan_detail.id_produk = produk.id', 'left')
            ->where('outbound_penjualan_detail.id_penjualan', $id_penjualan)
            ->groupBy('outbound_penjualan_detail.id_produk')
            ->orderBy('outbound_penjualan_detail.id', 'asc')
            ->get()
            ->getResultArray();

        return $data;
    }


    public function sumTotalQtyKurang($id_outbound_penjualan)
    {
        $data =  $this->db->table($this->table)
            ->select('outbound_penjualan_detail.id_penjualan, sum(qty_kurang) as total_qty_kurang')
            ->where('outbound_penjualan_detail.id_outbound_penjualan', $id_outbound_penjualan)
            ->groupBy('outbound_penjualan_detail.id_outbound_penjualan ')
            ->get()
            ->getRowArray();

        return $data;
    }


    public function sumDikirimSekarang($id_outbound_penjualan)
    {
        $data =  $this->db->table($this->table)
            ->select('outbound_penjualan_detail.id_penjualan, sum(qty_dikirim_sekarang) as total_qty_dikirim_sekarang')
            ->where('outbound_penjualan_detail.id_outbound_penjualan', $id_outbound_penjualan)
            ->groupBy('outbound_penjualan_detail.id_outbound_penjualan ')
            ->get()
            ->getRowArray();

        return $data;
    }
}
