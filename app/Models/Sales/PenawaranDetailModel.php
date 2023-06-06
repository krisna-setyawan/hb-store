<?php

namespace App\Models\Sales;

use CodeIgniter\Model;

class PenawaranDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'penawaran_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_penawaran',
        'id_produk',
        'qty',
        'harga_satuan',
        'total_harga'
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

    function getListProdukPenawaran($id_penawaran)
    {
        $data =  $this->db->table($this->table)
            ->select('penawaran_detail.*, produk.nama as produk, produk.sku as sku')
            ->join('produk', 'penawaran_detail.id_produk = produk.id', 'left')
            ->where('penawaran_detail.id_penawaran', $id_penawaran)
            ->get()
            ->getResultArray();

        return $data;
    }

    function sumTotalHargaProduk($id_penawaran)
    {
        $data =  $this->db->table($this->table)
            ->selectSum('total_harga')
            ->where('id_penawaran', $id_penawaran)
            ->get()
            ->getRowArray();

        return $data;
    }
}
