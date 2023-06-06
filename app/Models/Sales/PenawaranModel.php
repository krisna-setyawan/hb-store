<?php

namespace App\Models\Sales;

use CodeIgniter\Model;

class PenawaranModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'penawaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_customer',
        'id_user',
        'no_penawaran',
        'tanggal',
        'total_harga_produk',
        'status',
        'alasan_dihapus'
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


    public function getPenawaran($no)
    {
        $data =  $this->db->table($this->table)
            ->select('penawaran.*, customer.nama as customer, karyawan.nama_lengkap as admin')
            ->join('customer', 'penawaran.id_customer = customer.id', 'left')
            ->join('users', 'penawaran.id_user = users.id', 'left')
            ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
            // ->where('penawaran.deleted_at', null)
            ->where('no_penawaran', $no)
            ->get()
            ->getRowArray();

        return $data;
    }
}
