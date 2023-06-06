<?php

namespace App\Models\Warehouse;

use CodeIgniter\Model;


class OutboundPenjualanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'outbound_penjualan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_penjualan',
        'id_pj',
        'id_gudang',
        'no_outbound',
        'tanggal',
        'status_simpan'
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

    public function getListOutboundPenjualan($id_penjualan)
    {
        $data =  $this->db->table($this->table)
            ->select('outbound_penjualan.*, users.name as pj, gudang.nama as gudang')
            ->join('users', 'outbound_penjualan.id_pj = users.id', 'left')
            ->join('gudang', 'outbound_penjualan.id_gudang = gudang.id', 'left')
            ->where('outbound_penjualan.id_penjualan', $id_penjualan)
            ->get()
            ->getResultArray();

        return $data;
    }
}
