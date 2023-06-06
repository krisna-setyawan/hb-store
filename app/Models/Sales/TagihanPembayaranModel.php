<?php

namespace App\Models\Sales;

use CodeIgniter\Model;

class TagihanPembayaranModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tagihan_pembayaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_tagihan', 'id_user', 'tanggal_bayar', 'jumlah_bayar'
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



    public function getPembayaranByIdTagihan($id_tagihan)
    {
        $data =  $this->db->table($this->table)
            ->select('tagihan_pembayaran.*, karyawan.nama_lengkap as admin')
            ->join('users', 'tagihan_pembayaran.id_user = users.id', 'left')
            ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
            ->where('id_tagihan', $id_tagihan)
            ->get()
            ->getResultArray();

        return $data;
    }
}
