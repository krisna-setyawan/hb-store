<?php

namespace App\Controllers\Hrm;

use App\Models\Hrm\KaryawanAbsenModel;
use App\Models\Hrm\LogAbsenModel;
use App\Models\Hrm\KaryawanModel;

use CodeIgniter\RESTful\ResourceController;

class LogAbsen extends ResourceController
{

    public function index($id_karyawan = null, $id_karyawan_absen = null)
    {
        $modelLogAbsen = new LogAbsenModel();
        $modelKaryawanAbsen = new KaryawanAbsenModel();
        $modelKaryawan = new KaryawanModel;
        $karyawan = $modelKaryawan->find($id_karyawan);
        $absen = $modelKaryawanAbsen->find($id_karyawan_absen);
        $log = $modelLogAbsen
            ->select('log_absen.*,karyawan_absen.id as absen_id')
            ->join('karyawan_absen', 'log_absen.id_absen=karyawan_absen.id')
            ->where('log_absen.id_absen', $id_karyawan_absen)
            ->findAll();
        $data = [
            'log' => $log,
            'id_absen' => $id_karyawan_absen,
            'karyawan_name' => $karyawan['nama_lengkap'],
            'karyawan_id' => $id_karyawan,
            'tanggal_absen' => $absen['tanggal_absen']
        ];
        return view('hrm/absensi/log_absensi/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        if ($this->request->isAJAX()) {

            $modelLogAbsen = new LogAbsenModel();
            $modelKaryawanAbsen = new KaryawanAbsenModel();
            $log = $modelLogAbsen->findAll();
            $karyawan = $modelKaryawanAbsen->find($this->request->getPost('id'));

            $data = [
                'id_absen'      => $this->request->getPost('id'),
                'log'        => $log,
                'tanggal_absen' => $karyawan['tanggal_absen']

            ];

            $json = [
                'data'          => view('hrm/absensi/log_absensi/add', $data),
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
                'log_date'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'tanggal harus diisi',

                    ]
                ],
                'log_time'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'waktu harus diisi',
                    ]
                ],
                'keterangan' => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'keterangan harus diisi',
                    ]
                ]
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();
                $error = [
                    'error_log_date' => $validation->getError('log_date'),
                    'error_log_time' => $validation->getError('log_time'),
                    'error_keterangan' => $validation->getError('keterangan'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $id_absen = $this->request->getPost('absen_id');
                $hasil_cek = $this->total_menit($id_absen);

                if ($hasil_cek == "ada") {
                    $modelKaryawanAbsen = new KaryawanAbsenModel();
                    $db      = \Config\Database::connect();
                    $builder = $db->table('log_absen');
                    $logabsen = $builder
                        ->getWhere(['id_absen' => $id_absen, 'keterangan' => 'Masuk'])->getRowArray();
                    $waktu_masuk = strtotime($logabsen['log_date'] . ' ' . $logabsen['log_time']);
                    $waktu_akhir = strtotime($this->request->getPost('log_date') . ' ' . $this->request->getPost('log_time'));
                    $diff    = $waktu_akhir - $waktu_masuk;
                    $menit    = $diff / (60);

                    $data1 = [
                        'id' => $id_absen,
                        'total_menit' => $menit
                    ];
                    $modelKaryawanAbsen->save($data1);
                }
                $modelLogAbsen = new LogAbsenModel();
                $data = [
                    'id_absen' => $this->request->getPost('absen_id'),
                    'log_date' => $this->request->getPost('log_date'),
                    'log_time' => $this->request->getPost('log_time'),
                    'keterangan' => $this->request->getPost('keterangan'),
                ];
                $modelLogAbsen->save($data);


                $json = [
                    'success' => 'Berhasil menambah data Log absen'
                ];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }

    public function total_menit($id_absen)
    {
        $modelKaryawanAbsen = new KaryawanAbsenModel();
        $modelLogAbsen = new LogAbsenModel();

        $logabsen = $modelLogAbsen
            ->where(['id_absen' => $id_absen])
            ->findAll();
        if (!$logabsen) {
            return "tidak";
        } else {
            return "ada";
        }
    }


    public function edit($id = null)
    {
    }


    public function update($id = null)
    {
        if ($this->request->isAJAX()) {
            $validasi = [
                'log_date'  => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required' => 'tanggal harus diisi',
                    ]
                ],
                'log_time'  => [
                    'rules'     => 'required|is_unique[log_absen.log_time]',
                    'errors'    => [
                        'required' => 'waktu harus diisi',
                        'is_unique' => 'waktu sudah ada'
                    ]
                ]
            ];

            if (!$this->validate($validasi)) {
                $validation = \Config\Services::validation();

                $error = [
                    'error_log_date' => $validation->getError('log_date'),
                    'error_log_time' => $validation->getError('log_time'),
                ];

                $json = [
                    'error' => $error
                ];
            } else {
                $modelLogAbsen = new LogAbsenModel();
                $data = [
                    'id' => $id,
                    'id_absen' => $this->request->getPost('absen_id'),
                    'log_date' => $this->request->getPost('log_date'),
                    'log_time' => $this->request->getPost('log_time'),
                ];

                $modelLogAbsen->save($data);

                $json = [
                    'success' => 'Berhasil Data data Log Absen'
                ];
            }
            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function delete($id = null)
    {
        $modelLogAbsen = new LogAbsenModel();


        $modelLogAbsen->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->back();
    }
}
