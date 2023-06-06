<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\AbsensiModel;
use App\Models\Hrm\KaryawanModel;
use App\Models\Hrm\KaryawanAbsenModel;

use CodeIgniter\RESTful\ResourceController;

class Absensi extends ResourceController
{

    public function index()
    {
        $modelKaryawan = new KaryawanModel();
        $modelKaryawanAbsen = new KaryawanAbsenModel();

        // Mengambil data bulan dan tahun dari form filter tanggal
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $karyawan = $modelKaryawan
            ->select('karyawan.*')
            ->findAll();
        $data = [];
        foreach ($karyawan as $row) {
            // Menambahkan kondisi bulan dan tahun pada pemanggilan method total_menit
            $total_menit = $modelKaryawanAbsen->total_menit($row['id'], $bulan, $tahun);
            $row['total_menit'] = $total_menit;
            $data['karyawan'][] = $row;
        }

        $data['bulan'] = null;
        $data['tahun'] = null;
        return view('hrm/absensi/index', $data);
    }


    public function viewAbsensi()
    {
        $modelKaryawan = new KaryawanModel();
        $modelKaryawanAbsen = new KaryawanAbsenModel();

        // Mengambil data bulan dan tahun dari form filter tanggal
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $karyawan = $modelKaryawan
            ->select('karyawan.*')
            ->findAll();
        $data = [];
        foreach ($karyawan as $row) {
            // Menambahkan kondisi bulan dan tahun pada pemanggilan method total_menit
            $total_menit = $modelKaryawanAbsen->total_menit($row['id'], $bulan, $tahun);
            $row['total_menit'] = $total_menit;
            $data['karyawan'][] = $row;
        }

        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        return view('hrm/absensi/index', $data);
    }


    public function show($id = null)
    {
    }


    public function new()
    {
    }


    public function create()
    {
    }


    public function edit($id = null)
    {
    }


    public function update($id = null)
    {
    }


    public function delete($id = null)
    {
    }
}
