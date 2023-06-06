<?php

namespace App\Models\Sales;

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
        'id_kategori', 'id_gudang', 'id_ruangan', 'id_rak', 'sku', 'hs_code', 'nama', 'slug', 'satuan',
        'tipe', 'jenis', 'hg_produk_penyusun', 'harga_beli', 'harga_jual', 'stok',
        'berat', 'panjang', 'lebar', 'tinggi', 'minimal_penjualan', 'kelipatan_penjualan',
        'status_marketing', 'note', 'created_at', 'updated_at', 'deleted_at'
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


    public function getProduk($id_produk)
    {
        $data =  $this->db->table($this->table)
            ->select('produk.*, produk_kategori.nama as kategori')
            ->join('produk_kategori', 'produk.id_kategori = produk_kategori.id', 'left')
            ->where('produk.id', $id_produk)
            ->get()
            ->getRowArray();

        return $data;
    }

    public function getProdukFormPenjualanDetailCustomer($id_customer)
    {
        $data =  $this->db->table('penjualan_detail')
            ->select('penjualan_detail.*, produk.nama as produk, produk.stok')
            ->join('produk', 'penjualan_detail.id_produk = produk.id', 'left')
            ->join('penjualan', 'penjualan.id = penjualan_detail.id_penjualan')
            ->where('penjualan.id_customer', $id_customer)
            ->where('penjualan.status', 'sampai')
            ->orderBy('penjualan.id', 'desc')
            ->get()
            ->getResultArray();

        return $data;
    }

    public function findProdukByNamaSKU($nama_sku)
    {
        $data =  $this->db->table('produk')
            ->select('produk.*')
            ->like('produk.nama', $nama_sku)
            ->orLike('produk.sku', $nama_sku)
            ->orderBy('produk.nama', 'asc')
            ->get()
            ->getResultArray();

        return $data;
    }
}
