<?php

namespace App\Models\Sales;

use CodeIgniter\Model;

class PenjualanDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'penjualan_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_penjualan',
        'id_produk',
        'qty',
        'harga_satuan',
        'diskon',
        'biaya_tambahan',
        'total_harga',
        'berat',
        'catatan',
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

    function getListProdukPenjualan($id_penjualan)
    {
        $data =  $this->db->table($this->table)
            ->select('penjualan_detail.*, produk.nama as produk, produk.sku as sku, produk.satuan as satuan, sum(lokasi_produk.stok) as stok')
            ->join('produk', 'penjualan_detail.id_produk = produk.id', 'left')
            ->join('lokasi_produk', 'penjualan_detail.id_produk = lokasi_produk.id_produk', 'left')
            ->where('penjualan_detail.id_penjualan', $id_penjualan)
            ->groupBy('lokasi_produk.id_produk')
            ->get()
            ->getResultArray();

        return $data;
    }

    function sumTotalHargaProduk($id_penjualan)
    {
        $data =  $this->db->table($this->table)
            ->selectSum('total_harga')
            ->where('id_penjualan', $id_penjualan)
            ->get()
            ->getRowArray();

        return $data;
    }
}
