<?php

namespace App\Models\Resource;

use CodeIgniter\Model;

class AkunModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'akun';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode','nama','id_kategori', 'saldo', 'created_at', 'updated_at', 'deleted_at'
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


    public function getAkun($idAkun)
    {
        $data =  $this->db->table($this->table)
            ->join('akun_kategori', 'akun.id_kategori = akun_kategori.id', 'left')
            ->where('akun.id', $idAkun)
            ->get()
            ->getRowArray();

        return $data;
    }
}
