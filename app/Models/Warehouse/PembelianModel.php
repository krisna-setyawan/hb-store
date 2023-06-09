<?php

namespace App\Models\Warehouse;

use CodeIgniter\Model;


class PembelianModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pembelian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pemesanan',
        'id_pemesanan_fixing',
        'id_supplier',
        'id_user',
        'id_gudang',
        'jenis_supplier',
        'id_perusahaan',
        'no_pembelian',
        'invoice',
        'tanggal',
        'status',
        'status_pembayaran',
        'status_inbound',
        'panjang',
        'lebar',
        'tinggi',
        'berat',
        'carton_koli',
        'exw',
        'hf',
        'ppn_hf',
        'ongkir_port',
        'ongkir_laut_udara',
        'ongkir_transit',
        'ongkir_gudang',
        'bm',
        'ppn',
        'pph',
        'grand_total',
        'catatan',
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


    public function getPembelian($no)
    {
        $data =  $this->db->table($this->table)
            ->select('pembelian.*, supplier.nama as supplier, supplier.no_telp as telp_supplier, gudang.nama as gudang, karyawan.nama_lengkap as admin, pemesanan.no_pemesanan')
            ->join('pemesanan', 'pembelian.id_pemesanan = pemesanan.id', 'left')
            ->join('supplier', 'pembelian.id_supplier = supplier.id', 'left')
            ->join('gudang', 'pembelian.id_gudang = gudang.id', 'left')
            ->join('users', 'pembelian.id_user = users.id', 'left')
            ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
            ->where('pembelian.deleted_at', null)
            ->where('no_pembelian', $no)
            ->get()
            ->getRowArray();

        return $data;
    }

    public function getPembelianById($id)
    {
        $data =  $this->db->table($this->table)
            ->select('pembelian.*, supplier.nama as supplier, supplier.no_telp as telp_supplier, gudang.nama as gudang, karyawan.nama_lengkap as admin, pemesanan.no_pemesanan')
            ->join('pemesanan', 'pembelian.id_pemesanan = pemesanan.id', 'left')
            ->join('supplier', 'pembelian.id_supplier = supplier.id', 'left')
            ->join('gudang', 'pembelian.id_gudang = gudang.id', 'left')
            ->join('users', 'pembelian.id_user = users.id', 'left')
            ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
            ->where('pembelian.deleted_at', null)
            ->where('pembelian.id', $id)
            ->get()
            ->getRowArray();

        return $data;
    }

    public function getDataPembelian($id_gudang)
    {
        $data =  $this->db->table($this->table)
            ->select('pembelian.*, supplier.nama as supplier, supplier.no_telp as telp_supplier, gudang.nama as gudang, karyawan.nama_lengkap as admin')
            ->join('supplier', 'pembelian.id_supplier = supplier.id', 'left')
            ->join('gudang', 'pembelian.id_gudang = gudang.id', 'left')
            ->join('users', 'pembelian.id_user = users.id', 'left')
            ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
            ->where('pembelian.deleted_at', null)
            ->where('id_gudang', $id_gudang)
            ->get()
            ->getResultArray();

        return $data;
    }
}
