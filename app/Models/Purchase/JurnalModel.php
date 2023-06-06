<?php

namespace App\Models\Purchase;

use CodeIgniter\Model;

class JurnalModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaksi_jurnal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nomor_transaksi','referensi','tanggal','total_transaksi','created_at', 'updated_at', 'deleted_at'
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


    public function getJurnal($idJurnal)
    {
        $data =  $this->db->table($this->table)
            ->where('transaksi_jurnal.deleted_at', null)
            ->where('nomer_transaksi',$idJurnal)
            ->get()
            ->getRowArray();

        return $data;
    }
}
