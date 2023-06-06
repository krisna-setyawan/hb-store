<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\KaryawanModel;
use App\Models\Hrm\FileKaryawanModel;
use CodeIgniter\RESTful\ResourceController;

class FileKaryawan extends ResourceController
{
    protected $helpers = ['form'];

    public function index($id_karyawan = null)
    {
        $modelKaryawan = new KaryawanModel();
        $modelFileKaryawan = new FileKaryawanModel();
        $karyawan = $modelKaryawan->find($id_karyawan);
        $filekaryawan = $modelFileKaryawan
            ->select('file_karyawan.*, karyawan.id as karyawan_id')
            ->join('karyawan', 'file_karyawan.id_karyawan = karyawan.id', 'LEFT')
            ->where('file_karyawan.id_karyawan', $id_karyawan)
            ->findAll();

        $data = [
            'file' => $filekaryawan,
            'id_karyawan' => $id_karyawan,
            'karyawan_name' => $karyawan['nama_lengkap'],
        ];

        return view('hrm/karyawan/file_karyawan/index', $data);
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelFileKaryawan = new FileKaryawanModel();
            $file      = $modelFileKaryawan->find($id);

            $data = [
                'file' => $file,
            ];
            $json = [
                'data' => view('hrm/karyawan/file_karyawan/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load show';
        }
    }


    public function new($id_karyawan = null)
    {
        $modelKaryawan = new KaryawanModel();
        $karyawan = $modelKaryawan->find($id_karyawan);
        $data = [
            'karyawan_name' => $karyawan['nama_lengkap'],
            'id_karyawan' => $id_karyawan,
            'validation' => \Config\Services::validation(),
        ];
        return view('hrm/karyawan/file_karyawan/add', $data);
    }


    public function create()
    {
        $validasi = [
            'nama'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'nama harus diisi',
                ]
            ],
            'tgl_upload'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'tgl_upload harus diisi',
                ]
            ],
            'nama_file' => [
                'rules' => 'uploaded[nama_file]|max_size[nama_file,5120]|ext_in[nama_file,jpg,png,jpeg,pdf]|mime_in[nama_file,application/pdf,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    'uploaded' => 'Pilih File Terlebih dahulu',
                    'ext_in'   => 'File harus jpg,png,pdf',
                    'max_size' => 'Maksimal Ukuran file 5Mb',
                    'mime_in'  => 'File Harus sesuai'
                ]
            ]
        ];
        if (!$this->validate($validasi)) {
            return redirect()->to('hrm-file-karyawan/new/' . $this->request->getPost('id_karyawan'))->withInput();
        } else {
            $modelFileKaryawan = new FileKaryawanModel();
            $karyawan_file = $this->request->getFile('nama_file');
            $namaFile = $karyawan_file->getRandomName();
            $karyawan_file->move('file_karyawan', $namaFile);

            $data = [
                'id_karyawan' => $this->request->getPost('id_karyawan'),
                'nama' => $this->request->getPost('nama'),
                'tgl_upload' => $this->request->getPost('tgl_upload'),
                'nama_file' => $namaFile
            ];

            $modelFileKaryawan->save($data);
            session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
            return redirect()->to('hrm-file-karyawan/' . $this->request->getPost('id_karyawan'));
        }
    }


    public function edit($id = null, $id_karyawan = null)
    {
        $filekaryawan = new FileKaryawanModel();
        $file = $filekaryawan->find($id);
        $modelKaryawan = new KaryawanModel();
        $karyawan = $modelKaryawan->find($id_karyawan);
        $data = [
            'id_karyawan' => $id_karyawan,
            'karyawan_name' => $karyawan['nama_lengkap'],
            'file' => $file,
            'validation' => \Config\Services::validation()
        ];
        return view('hrm/karyawan/file_karyawan/edit', $data);
    }


    public function update($id = null)
    {
        $validasi = [
            'nama'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'nama harus diisi',
                ]
            ],
            'tgl_upload'  => [
                'rules'     => 'required',
                'errors'    => [
                    'required' => 'tgl_upload harus diisi',
                ]
            ],
            'nama_file' => [
                'rules' => 'uploaded[nama_file]|max_size[nama_file,5120]|ext_in[nama_file,jpg,png,jpeg,pdf]|mime_in[nama_file,application/pdf,image/jpg,image/png,image/jpeg]',
                'errors' => [
                    'uploaded' => 'Pilih File Terlebih dahulu',
                    'ext_in'   => 'File harus jpg,png,pdf',
                    'max_size' => 'Maksimal Ukuran file 5Mb',
                    'mime_in'  => 'File Harus sesuai'
                ]
            ]
        ];
        if (!$this->validate($validasi)) {
            return redirect()->to('hrm-file-karyawan/edit/' . $id . '/' . $this->request->getPost('id_karyawan'))->withInput();
        } else {
            $modelFileKaryawan = new FileKaryawanModel();
            $file = $modelFileKaryawan->find($id);
            unlink('file_karyawan/' . $file['nama_file']);
            $karyawan_file = $this->request->getFile('nama_file');
            $namaFile = $karyawan_file->getRandomName();
            $karyawan_file->move('file_karyawan', $namaFile);

            $data = [
                'id' => $id,
                'id_karyawan' => $this->request->getPost('id_karyawan'),
                'nama' => $this->request->getPost('nama'),
                'tgl_upload' => $this->request->getPost('tgl_upload'),
                'nama_file' => $namaFile
            ];

            $modelFileKaryawan->save($data);
            session()->setFlashdata('pesan', 'Data berhasil diedit.');
            return redirect()->to('hrm-file-karyawan/' . $this->request->getPost('id_karyawan'));
        }
    }


    public function delete($id = null)
    {
        $modelFileKaryawan = new FileKaryawanModel();

        $file = $modelFileKaryawan->find($id);

        unlink('file_karyawan/' . $file['nama_file']);

        $modelFileKaryawan->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->back();
    }
}
