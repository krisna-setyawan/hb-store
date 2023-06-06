<?php

namespace App\Models\Sales;

use CodeIgniter\Model;

class CustomerPJModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer_penanggungjawab';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

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


    public function getPJByCustomer($id_customer)
    {
        $data =  $this->db->table($this->table)
            ->select('customer_penanggungjawab.*, karyawan.nama_lengkap as nama_pj')
            ->join('users', 'customer_penanggungjawab.id_user = users.id', 'left')
            ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
            ->where('customer_penanggungjawab.id_customer', $id_customer)
            ->get()
            ->getResultArray();

        return $data;
    }
}
