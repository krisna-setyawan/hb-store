<?php

namespace App\Models\Sales;

use CodeIgniter\Model;


class PenjualanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'penjualan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_penawaran',
        'id_customer',
        'id_user',
        'no_penjualan',
        'tanggal',
        'status',
        'status_pembayaran',
        'status_outbound',
        'panjang',
        'lebar',
        'tinggi',
        'berat',
        'carton_koli',
        'nama_alamat',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_kelurahan',
        'detail_alamat',
        'penerima',
        'no_telp',
        'total_harga_produk',
        'ongkir',
        'jasa_kirim',
        'diskon',
        'grand_total',
        'kode_promo',
        'catatan',
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


    public function getPenjualan($no)
    {
        $data =  $this->db->table($this->table)
            ->select('penjualan.*, customer.nama as customer, customer.no_telp as telp_customer, karyawan.nama_lengkap as admin, provinsi.nama as provinsi, kota.nama as kota, kecamatan.nama as kecamatan, kelurahan.nama as kelurahan')
            ->join('customer', 'penjualan.id_customer = customer.id', 'left')
            ->join('users', 'penjualan.id_user = users.id', 'left')
            ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
            ->join('provinsi', 'penjualan.id_provinsi = provinsi.id', 'left')
            ->join('kota', 'penjualan.id_kota = kota.id', 'left')
            ->join('kecamatan', 'penjualan.id_kecamatan = kecamatan.id', 'left')
            ->join('kelurahan', 'penjualan.id_kelurahan = kelurahan.id', 'left')
            ->where('penjualan.deleted_at', null)
            ->where('no_penjualan', $no)
            ->get()
            ->getRowArray();

        return $data;
    }

    public function getPenjualanByIdPenawaran($id_penawaran)
    {
        $data =  $this->db->table($this->table)
            ->select('penjualan.*, customer.nama as customer, karyawan.nama_lengkap as admin, penawaran.no_penawaran')
            ->join('penawaran', 'penjualan.id_penawaran = penawaran.id', 'left')
            ->join('customer', 'penjualan.id_customer = customer.id', 'left')
            ->join('users', 'penjualan.id_user = users.id', 'left')
            ->join('karyawan', 'users.id_karyawan = karyawan.id', 'left')
            ->where('penjualan.deleted_at', null)
            ->where('id_penawaran', $id_penawaran)
            ->get()
            ->getRowArray();

        return $data;
    }
}
