<?php

namespace App\Models\Purchase;

use CodeIgniter\Model;

class PemesananFixingDetailModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pemesanan_fixing_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pemesanan_fixing',
        'id_produk',
        'sku',
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

    function getListProdukPemesananFixing($id_pemesanan_fixing)
    {
        $data =  $this->db->table($this->table)
            ->select('pemesanan_fixing_detail.*, produk.nama as produk, produk.sku as sku')
            ->join('produk', 'pemesanan_fixing_detail.id_produk = produk.id', 'left')
            ->where('pemesanan_fixing_detail.id_pemesanan_fixing', $id_pemesanan_fixing)
            ->get()
            ->getResultArray();

        return $data;
    }

    function sumTotalHargaProduk($id_pemesanan_fixing)
    {
        $data =  $this->db->table($this->table)
            ->selectSum('total_harga')
            ->where('id_pemesanan_fixing', $id_pemesanan_fixing)
            ->get()
            ->getRowArray();

        return $data;
    }
}
