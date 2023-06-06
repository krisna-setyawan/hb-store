<?php

namespace App\Models\Warehouse;

use CodeIgniter\Model;

class LokasiProdukModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lokasi_produk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [
        'id_produk', 'id_gudang', 'id_ruangan', 'id_rak', 'stok'
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



    public function getLokasiProduk($id_produk)
    {
        $data =  $this->db->table('lokasi_produk')
            ->select('lokasi_produk.*, gudang.nama as gudang, sum(lokasi_produk.stok) as total_stok')
            ->join('gudang', 'lokasi_produk.id_gudang = gudang.id', 'left')
            ->where('lokasi_produk.id_produk', $id_produk)
            ->groupBy('lokasi_produk.id_gudang')
            ->get()
            ->getResultArray();

        return $data;
    }

    public function getProdukByGudang($id_gudang)
    {
        $data =  $this->db->table('lokasi_produk')
            ->select('lokasi_produk.*, produk.nama as nama, sum(lokasi_produk.stok) as total_stok')
            ->join('produk', 'lokasi_produk.id_produk = produk.id', 'left')
            ->where('lokasi_produk.id_gudang', $id_gudang)
            ->groupBy('lokasi_produk.id_produk')
            ->get()
            ->getResultArray();

        return $data;
    }

    // cari produk tak terlacak lokasinya
    public function getProdukUnasigned()
    {
        $data =  $this->db->table('produk')
            ->select('produk.id, produk.nama, produk.stok - COALESCE(SUM(lokasi_produk.stok), 0) AS stok_tak_terlacak')
            ->join('lokasi_produk', 'lokasi_produk.id_produk = produk.id', 'left')
            ->groupBy('produk.id, produk.nama')
            ->having('stok_tak_terlacak >', 0)
            ->orHaving('stok_tak_terlacak', null, true)
            ->get()
            ->getResultArray();

        return $data;
    }


    public function getProdukByIdProdukIdGudang($id_gudang, $id_produk)
    {
        $data =  $this->db->table('lokasi_produk')
            ->select('lokasi_produk.*, produk.nama as nama, sum(lokasi_produk.stok) as total_stok')
            ->join('produk', 'lokasi_produk.id_produk = produk.id', 'left')
            ->where('lokasi_produk.id_gudang', $id_gudang)
            ->where('lokasi_produk.id_produk', $id_produk)
            ->groupBy('lokasi_produk.id_produk')
            ->get()
            ->getResultArray();

        return $data;
    }
}
