<?php

namespace App\Models\Api;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'produk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sku', 'hs_code', 'nama', 'slug', 'satuan',
        'tipe', 'jenis', 'harga_jual',
        'berat', 'panjang', 'lebar', 'tinggi'
    ];

    // Dates
    protected $useTimestamps = true;
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


    public function getProducts()
    {
        $data =  $this->db->table($this->table)
            ->select('id as id_produk, sku, hs_code, nama as produk, stok, slug, satuan, tipe, jenis, harga_jual, berat, panjang, lebar, tinggi')
            ->orderBy('id', 'asc')
            ->get()
            ->getResultArray();

        return $data;
    }

    public function getProduct($sku)
    {
        $data =  $this->db->table($this->table)
            ->select('sku, hs_code, nama, slug, satuan, tipe, jenis, harga_jual, berat, panjang, lebar, tinggi')
            ->where('produk.sku', $sku)
            ->get()
            ->getRowArray();

        return $data;
    }
}
