<?php

namespace App\Models\Resource;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_customer', 'nama', 'jenis_customer', 'id_perusahaan', 'slug', 'no_telp', 'email', 'status',
        'saldo_utama', 'saldo_belanja', 'saldo_lain', 'tgl_registrasi', 'note',
        'created_at', 'updated_at', 'deleted_at',
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


    public function getCustomers()
    {
        $data =  $this->db->table($this->table)
            ->select('customer.*, GROUP_CONCAT(karyawan.nama_lengkap SEPARATOR ",<br> ") as admin, GROUP_CONCAT(users.id SEPARATOR ", ") as id_admin')
            ->join('customer_penanggungjawab', 'customer.id = customer_penanggungjawab.id_customer', 'left')
            ->join('users', 'customer_penanggungjawab.id_user = users.id', 'left')
            ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
            ->where('customer.deleted_at', null)
            ->groupBy('customer.id')
            ->orderBy('customer.id', 'desc')
            ->get()
            ->getResultArray();

        return $data;
    }


    public function getCustomersWithAdmins($id_customer)
    {
        $data =  $this->db->table($this->table)
            ->select('customer.*, GROUP_CONCAT(customer_penanggungjawab.id_user SEPARATOR ", ") as id_admin')
            ->join('customer_penanggungjawab', 'customer.id = customer_penanggungjawab.id_customer', 'left')
            ->where('customer.id', $id_customer)
            ->groupBy('customer.id')
            ->get()
            ->getRowArray();

        return $data;
    }
}
