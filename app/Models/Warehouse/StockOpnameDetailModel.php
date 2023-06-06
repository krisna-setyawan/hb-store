<?php

namespace App\Models\Warehouse;

use CodeIgniter\Model;

class StockOpnameDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'stock_opname_list_produk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_stock_opname', 'id_produk', 'jumlah_fisik', 'jumlah_virtual', 'selisih'
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


    function getListProdukStock($idStockOpname)
    {
        $data =  $this->db->table($this->table)
            ->select('stock_opname_list_produk.*, produk.nama as produk')
            ->join('produk', 'stock_opname_list_produk.id_produk = produk.id', 'left')
            ->where('stock_opname_list_produk.id_stock_opname', $idStockOpname)
            ->get()
            ->getResultArray();

        return $data;
    }
}
