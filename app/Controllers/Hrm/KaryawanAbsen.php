<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\KaryawanModel;
use App\Models\Hrm\KaryawanAbsenModel;

use CodeIgniter\RESTful\ResourceController;

class KaryawanAbsen extends ResourceController
{
    public function index($id_karyawan = null)
    {
        $modelKaryawan = new KaryawanModel();
        $modelKaryawanAbsen = new KaryawanAbsenModel();
        $karyawan = $modelKaryawan->find($id_karyawan);
        $absen = $modelKaryawanAbsen
            ->select('karyawan_absen.id as ka_id,karyawan_absen.id_karyawan,karyawan_absen.tanggal_absen,karyawan_absen.status,karyawan.nama_lengkap,karyawan.id as karyawan_id,karyawan_absen.total_menit')
            ->join('karyawan', 'karyawan_absen.id_karyawan = karyawan.id')
            ->where('karyawan_absen.id_karyawan', $id_karyawan)
            ->findAll();
        $data = [
            'absen' => $absen,
            'id_karyawan' => $id_karyawan,
            'karyawan_name' => $karyawan['nama_lengkap'],
            'karyawan_id' => $karyawan,
        ];
        return view('hrm/absensi/karyawan_absensi/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        if ($this->request->isAJAX()) {

            $modelKaryawan = new KaryawanModel();
            $modelKaryawanAbsen = new KaryawanAbsenModel();
            $absen = $modelKaryawanAbsen->findAll();

            $data = [
                'id_karyawan'      => $this->request->getPost('id'),
                'absen'        => $absen,
            ];

            $json = [
                'data'          => view('hrm/absensi/karyawan_absensi/add', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function create()
    {
        if ($this->request->isAJAX()) {
            $validasi = [
                'tanggal_absen'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'tanggal_absen harus diisi',
                    ]
                ],
                'status'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'status harus diisi',
                    ]
                ]
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_tanggal_absen' => $validation->getError('tanggal_absen'),
                    'error_status' => $validation->getError('status'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelKaryawanAbsen = new KaryawanAbsenModel();
                $data = [
                    'id_karyawan' => $this->request->getPost('karyawan_id'),
                    'tanggal_absen' => $this->request->getPost('tanggal_absen'),
                    'status' => $this->request->getPost('status'),
                ];

                $modelKaryawanAbsen->save($data);

                $json = [
                    'success' => 'Berhasil menambah data karyawan'
                ];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function edit($id = null)
    {
        //
    }


    public function update($id = null)
    {
        //
    }


    public function delete($id = null)
    {
        //
    }
}
