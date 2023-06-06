<?php

namespace App\Models\Hrm;

use CodeIgniter\Model;

class KaryawanAbsenModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'karyawan_absen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_karyawan', 'tanggal_absen', 'status', 'total_menit'
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

    public function total_menit($id_karyawan, $bulan, $tahun)
    {
        $this->selectSum('total_menit');
        $this->where('id_karyawan', $id_karyawan);

        // Menambahkan kondisi bulan dan tahun pada query
        if (!empty($bulan)) {
            $this->where('MONTH(tanggal_absen)', $bulan);
        }
        if (!empty($tahun)) {
            $this->where('YEAR(tanggal_absen)', $tahun);
        }

        $query = $this->get();
        return $query->getRow()->total_menit;
    }
}
