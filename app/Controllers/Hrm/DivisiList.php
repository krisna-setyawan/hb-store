<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\KaryawanModel;
use App\Models\Hrm\DivisiModel;
use App\Models\Hrm\KaryawanDivisiModel;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\RESTful\ResourceController;


class DivisiList extends ResourceController
{


    public function index($id_divisi = null)
    {
        $modelKaryawanDivisi = new KaryawanDivisiModel();
        $modelDivisi = new DivisiModel();
        $divisi = $modelDivisi->find($id_divisi);
        $karyawan = $modelKaryawanDivisi
            ->select('karyawan_divisi.id as id, k.id as id_karyawan, k.id_divisi,k.nama_lengkap, k.jabatan, k.pendidikan, k.no_telp, k.email')
            ->join('karyawan as k', 'k.id = karyawan_divisi.id_karyawan', 'LEFT')
            ->where('karyawan_divisi.id_divisi', $id_divisi)
            ->findAll();
        $data = [
            'karyawan' => $karyawan,
            'id_divisi' => $id_divisi,
            'nama_divisi' => $divisi['nama']
        ];
        return view('hrm/divisi/list/index', $data);
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelKaryawan = new KaryawanModel();
            $modelDivisi = new DivisiModel();
            $karyawan      = $modelKaryawan->find($id);

            $data = [
                'karyawan' => $karyawan,
            ];
            $json = [
                'data' => view('hrm/divisi/list/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function new($id = null)
    {
        if ($this->request->isAJAX()) {

            $modelKaryawan = new KaryawanModel();
            $modelDivisi = new DivisiModel();
            $karyawan = $modelKaryawan->findAll();
            $divisi = $modelDivisi->find($id);

            $data = [
                'karyawan'        => $karyawan,
                'divisi'        => $divisi,
            ];

            $json = [
                'data'          => view('hrm/divisi/list/add', $data),
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
                'karyawan'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'karyawan harus diisi',
                    ]
                ],
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_karyawan' => $validation->getError('karyawan'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelKaryawan = new KaryawanModel();
                $modelDivisi = new DivisiModel();
                $modelKaryawanDivisi = new KaryawanDivisiModel();

                $data = [
                    'id_karyawan' => $this->request->getPost('karyawan'),
                    'id_divisi'   => $this->request->getPost('id_divisi'),
                ];
                $modelKaryawanDivisi->save($data);
                $json = [
                    'success' => 'Berhasil menambah data karyawan'
                ];
                echo json_encode($json);
            }
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
        $modelKaryawanDivisi = new KaryawanDivisiModel();

        $modelKaryawanDivisi->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->back();
    }
}
