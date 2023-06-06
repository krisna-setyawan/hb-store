<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\KaryawanModel;
use App\Models\Hrm\PelanggaranModel;
use App\Models\Hrm\PointPelanggaranModel;
use CodeIgniter\RESTful\ResourceController;

class PointPelanggaran extends ResourceController
{
    public function index($id_karyawan = null)
    {
        $modelKaryawan = new KaryawanModel();
        $modelPelanggaran = new PelanggaranModel();
        $modelPointPelanggaran = new PointPelanggaranModel();
        $pelanggaran = $modelPelanggaran->findAll();
        $karyawan = $modelKaryawan->find($id_karyawan);
        $PointPelanggaran = $modelPointPelanggaran
            ->select('p.nama_pelanggaran, point_pelanggaran.*, sum(point_pelanggaran.point) as total_point')
            ->join('pelanggaran p', 'p.id = point_pelanggaran.id_pelanggaran', 'LEFT')
            ->where('point_pelanggaran.id_karyawan', $id_karyawan)
            ->groupBy('point_pelanggaran.id_pelanggaran')
            ->findAll();
        $total_point = 0;
        foreach ($PointPelanggaran as $item) {
            $total_point += $item['total_point'];
        }
        $data = [
            'point_pelanggaran' => $PointPelanggaran,
            'id_karyawan' => $id_karyawan,
            'pelanggaran' => $pelanggaran,
            'nama_karyawan' => $karyawan['nama_lengkap'],
            'total_point' => $total_point
        ];
        return view('hrm/pelanggaran/point_pelanggaran/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        if ($this->request->isAJAX()) {
            $modelPelanggaran = new PelanggaranModel();
            $modelKaryawan = new KaryawanModel();
            $modelPointPelanggaran = new PointPelanggaranModel();
            $PointPelanggaran = $modelPointPelanggaran->findAll();
            $pelanggaran = $modelPelanggaran->findAll();

            $data = [
                'id_karyawan' => $this->request->getPost('id'),
                'pelanggaran' => $pelanggaran,
                'point_pelanggaran' => $PointPelanggaran
            ];

            $json = [
                'data' => view('hrm/pelanggaran/point_pelanggaran/add', $data)
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
                'pelanggaran'       => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Pelanggaran harus diisi.',
                    ]
                ],
                'point'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Point pelanggaran harus diisi.',
                    ]
                ],
                'tanggal'  => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Tanggal pelanggaran harus diisi.',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_pelanggaran'       => $validation->getError('pelanggaran'),
                    'error_point'  => $validation->getError('point'),
                    'error_tanggal'  => $validation->getError('tanggal')
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelPointPelanggaran = new PointPelanggaranModel();

                $data = [
                    'id_pelanggaran' => $this->request->getPost('pelanggaran'),
                    'tanggal'        => $this->request->getPost('tanggal'),
                    'point'          => $this->request->getPost('point'),
                    'id_karyawan'    => $this->request->getPost('karyawan_id'),
                ];
                $modelPointPelanggaran->insert($data);

                $json = [
                    'success' => 'Berhasil menambah data pelanggaran'
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
        $modelPointPelanggaran = new PointPelanggaranModel();
        $modelPointPelanggaran->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->back();
    }
}
