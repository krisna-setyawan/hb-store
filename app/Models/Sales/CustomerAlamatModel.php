<?php

namespace App\Models\Sales;

use CodeIgniter\Model;

class CustomerAlamatModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'customer_alamat';
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

    public function getAlamatByCustomer($id_customer)
    {
        $data =  $this->db->table($this->table)
            ->select('customer_alamat.*, provinsi.nama as provinsi, kota.nama as kota, kecamatan.nama as kecamatan, kelurahan.nama as kelurahan')
            ->join('provinsi', 'customer_alamat.id_provinsi = provinsi.id', 'left')
            ->join('kota', 'customer_alamat.id_kota = kota.id', 'left')
            ->join('kecamatan', 'customer_alamat.id_kecamatan = kecamatan.id', 'left')
            ->join('kelurahan', 'customer_alamat.id_kelurahan = kelurahan.id', 'left')
            ->where('customer_alamat.id_customer', $id_customer)
            ->get()
            ->getResultArray();

        return $data;
    }

    public function getFirstAlamatCustomer($id_customer)
    {
        $data =  $this->db->table($this->table)
            ->select('customer_alamat.*, provinsi.nama as provinsi, kota.nama as kota, kecamatan.nama as kecamatan, kelurahan.nama as kelurahan')
            ->join('provinsi', 'customer_alamat.id_provinsi = provinsi.id', 'left')
            ->join('kota', 'customer_alamat.id_kota = kota.id', 'left')
            ->join('kecamatan', 'customer_alamat.id_kecamatan = kecamatan.id', 'left')
            ->join('kelurahan', 'customer_alamat.id_kelurahan = kelurahan.id', 'left')
            ->where('customer_alamat.id_customer', $id_customer)
            ->get()
            ->getRowArray();

        return $data;
    }

    public function getAlamatById($id)
    {
        $data =  $this->db->table($this->table)
            ->select('customer_alamat.*, provinsi.nama as provinsi, kota.nama as kota, kecamatan.nama as kecamatan, kelurahan.nama as kelurahan')
            ->join('provinsi', 'customer_alamat.id_provinsi = provinsi.id', 'left')
            ->join('kota', 'customer_alamat.id_kota = kota.id', 'left')
            ->join('kecamatan', 'customer_alamat.id_kecamatan = kecamatan.id', 'left')
            ->join('kelurahan', 'customer_alamat.id_kelurahan = kelurahan.id', 'left')
            ->where('customer_alamat.id', $id)
            ->get()
            ->getRowArray();

        return $data;
    }
}
