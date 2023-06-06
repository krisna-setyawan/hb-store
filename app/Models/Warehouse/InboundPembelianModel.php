<?php

namespace App\Models\Warehouse;

use CodeIgniter\Model;


class InboundPembelianModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'inbound_pembelian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pembelian',
        'id_pj',
        'no_inbound',
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

    public function getListInboundPembelian($id_pembelian)
    {
        $data =  $this->db->table($this->table)
            ->select('inbound_pembelian.*, users.name as pj')
            ->join('users', 'inbound_pembelian.id_pj = users.id', 'left')
            ->where('inbound_pembelian.id_pembelian', $id_pembelian)
            ->get()
            ->getResultArray();

        return $data;
    }
}
