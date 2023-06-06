<?php

namespace App\Models\Resource;

use CodeIgniter\Model;

class JasaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jasa';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kategori', 'nama', 'slug', 'biaya', 'deskripsi', 'created_at', 'updated_at', 'deleted_at',];

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

    public function getJasa()
    {
        return $this->db->table($this->table)
            ->select('jasa.*, jasa_kategori.nama as kategori_jasa')
            ->join('jasa_kategori', 'jasa_kategori.id = jasa.id_kategori')
            ->where('jasa.deleted_at', null)
            ->get()->getResultArray();
    }
}
