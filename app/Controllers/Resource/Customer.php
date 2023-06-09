<?php

namespace App\Controllers\Resource;

use App\Models\Resource\CustomerAlamatModel;
use App\Models\Resource\CustomerModel;
use App\Models\Resource\CustomerPJModel;
use App\Models\Resource\CustomerRekeningModel;
use App\Models\Resource\ProvinsiModel;
use App\Models\Resource\UserModel;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\Config\Services;

class Customer extends ResourcePresenter
{
    protected $helpers = ['form'];


    public function index()
    {
        $modelCustomer = new CustomerModel();
        $customer = $modelCustomer->getCustomers();

        $data = [
            'customer' => $customer
        ];

        return view('resource/customer/index', $data);
    }


    public function show($id = null)
    {
        if ($this->request->isAJAX()) {
            $modelCustomer = new CustomerModel();
            $modelCustomerPJ = new CustomerPJModel();
            $modelCustomerAlamat = new CustomerAlamatModel();
            $modelCustomerRekening = new CustomerRekeningModel();

            $data = [
                'customer'  => $modelCustomer->find($id),
                'pj'        => $modelCustomerPJ->getPJByCustomer($id),
                'alamat'    => $modelCustomerAlamat->getAlamatByCustomer($id),
                'rekening'  => $modelCustomerRekening->where(['id_customer' => $id])->findAll(),
            ];

            $json = [
                'data' => view('resource/customer/show', $data),
            ];

            echo json_encode($json);
        } else {
            return 'Tidak bisa load';
        }
    }


    public function new()
    {
        $id_perusahaan = $_ENV['ID_PERUSAHAAN'];

        // Membuat objek HTTP client
        $client = Services::curlrequest();

        // Membuat URL API
        $url = $_ENV['URL_API'] . 'public/get-perusahaan';

        // Melakukan permintaan GET ke URL API
        $response = $client->request('GET', $url);

        // Mengambil status kode HTTP
        $status = $response->getStatusCode();

        // Mengambil body respons sebagai string
        $responseJson = $response->getBody();

        $responseArray = json_decode($responseJson, true);

        $perusahaan = $responseArray['data_perusahaan'];

        $data = [
            'id_perusahaan' => $id_perusahaan,
            'perusahaan'    => $perusahaan,
            'validation'    => \Config\Services::validation()
        ];

        return view('resource/customer/add', $data);
    }


    public function create()
    {
        $validasi = [
            'id_customer' => [
                'rules' => 'required|is_unique[customer.id_customer]',
                'errors' => [
                    'required' => 'ID customer harus diisi.',
                    'is_unique' => 'ID customer sudah ada dalam database.'
                ]
            ],
            'nama' => [
                'rules' => 'required|is_unique[customer.nama]',
                'errors' => [
                    'required' => '{field} customer harus diisi.',
                    'is_unique' => 'nama customer sudah ada dalam database.'
                ]
            ],
            'no_telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No telepon customer harus diisi.',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[customer.email]',
                'errors' => [
                    'required' => '{field} customer harus diisi.',
                    'is_unique' => 'email customer sudah ada dalam database.',
                    'valid_email' => 'format penulisan email salah.'
                ]
            ],
            'saldo_utama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Awal Saldo Utama harus diisi.',
                ]
            ],
            'saldo_belanja' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Awal Saldo Belanja harus diisi.',
                ]
            ],
            'saldo_lain' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Awal Saldo Lain harus diisi.',
                ]
            ],
            'tgl_registrasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tgl Registrasi harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            return redirect()->to('/resource-customer/new')->withInput();
        }

        $modelCustomer = new CustomerModel();

        $slug = url_title($this->request->getPost('nama'), '-', true);
        $saldo_utama = str_replace(".", "", $this->request->getPost('saldo_utama'));
        $saldo_belanja = str_replace(".", "", $this->request->getPost('saldo_belanja'));
        $saldo_lain = str_replace(".", "", $this->request->getPost('saldo_lain'));

        $jenis_customer = ($this->request->getPost('perusahaan') == 'Non Haebot') ? 'Non-Haebot' : 'Haebot';

        $data = [
            'id_customer'       => $this->request->getPost('id_customer'),
            'jenis_customer'    => $jenis_customer,
            'id_perusahaan'     => $this->request->getPost('id_perusahaan'),
            'nama'              => $this->request->getPost('nama'),
            'slug'              => $slug,
            'no_telp'           => $this->request->getPost('no_telp'),
            'email'             => $this->request->getPost('email'),
            'status'            => 'Active',
            'saldo_utama'       => $saldo_utama,
            'saldo_belanja'     => $saldo_belanja,
            'saldo_lain'        => $saldo_lain,
            'tgl_registrasi'    => $this->request->getPost('tgl_registrasi'),
            'note'              => $this->request->getPost('note'),
        ];
        $modelCustomer->save($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/resource-customer');
    }


    public function edit($id = null)
    {
        $id_perusahaan = $_ENV['ID_PERUSAHAAN'];

        // Membuat objek HTTP client
        $client = Services::curlrequest();

        // Membuat URL API
        $url = $_ENV['URL_API'] . 'public/get-perusahaan';

        // Melakukan permintaan GET ke URL API
        $response = $client->request('GET', $url);

        // Mengambil status kode HTTP
        $status = $response->getStatusCode();

        // Mengambil body respons sebagai string
        $responseJson = $response->getBody();

        $responseArray = json_decode($responseJson, true);

        $perusahaan = $responseArray['data_perusahaan'];

        $modelCustomer = new CustomerModel();
        $modelCustomerPJ = new CustomerPJModel();
        $modelCustomerAlamat = new CustomerAlamatModel();
        $modelCustomerRekening = new CustomerRekeningModel();
        $modelProvinsi = new ProvinsiModel();
        $modelUser = new UserModel();

        $pj = $modelCustomerPJ->getPJByCustomer($id);
        if ($pj) {
            $users = $modelUser->getUserPJWithKaryawanName(array_column($pj, 'id_user'));
        } else {
            $users = $modelUser->getAllUserWithKaryawanName();
        }

        $data = [
            'id_perusahaan'     => $id_perusahaan,
            'perusahaan'        => $perusahaan,
            'validation'        => \Config\Services::validation(),
            'customer'          => $modelCustomer->where(['id' => $id])->first(),
            'pj'                => $pj,
            'alamat'            => $modelCustomerAlamat->getAlamatByCustomer($id),
            'rekening'          => $modelCustomerRekening->where(['id_customer' => $id])->findAll(),
            'provinsi'          => $modelProvinsi->orderBy('nama')->findAll(),
            'users'             => $users
        ];

        return view('resource/customer/edit', $data);
    }


    public function update($id = null)
    {
        $modelCustomer = new CustomerModel();
        $old_customer = $modelCustomer->find($id);

        if ($old_customer['id_customer'] == $this->request->getPost('id_customer')) {
            $rule_id_customer = 'required';
        } else {
            $rule_id_customer = 'required|is_unique[customer.id_customer]';
        }

        if ($old_customer['nama'] == $this->request->getPost('nama')) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[customer.nama]';
        }

        if ($old_customer['email'] == $this->request->getPost('email')) {
            $rule_email = 'required|valid_email';
        } else {
            $rule_email = 'required|valid_email|is_unique[customer.email]';
        }

        $validasi = [
            'id_customer' => [
                'rules' => $rule_id_customer,
                'errors' => [
                    'required' => 'ID customer harus diisi.',
                    'is_unique' => 'ID customer sudah ada dalam database.'
                ]
            ],
            'nama' => [
                'rules' => $rule_nama,
                'errors' => [
                    'required' => '{field} customer harus diisi.',
                    'is_unique' => 'nama customer sudah ada dalam database.'
                ]
            ],
            'no_telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No telepon customer harus diisi.',
                ]
            ],
            'email' => [
                'rules' => $rule_email,
                'errors' => [
                    'required' => '{field} customer harus diisi.',
                    'is_unique' => 'email customer sudah ada dalam database.',
                    'valid_email' => 'format penulisan email salah.'
                ]
            ],
            'tgl_registrasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tgl Registrasi harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            return redirect()->to('/resource-customer/' . $old_customer["id"] . '/edit')->withInput();
        }

        $slug = url_title($this->request->getPost('nama'), '-', true);

        $jenis_customer = ($this->request->getPost('perusahaan') == 'Non Haebot') ? 'Non-Haebot' : 'Haebot';

        $data = [
            'id'                => $id,
            'id_customer'       => $this->request->getPost('id_customer'),
            'jenis_customer'    => $jenis_customer,
            'id_perusahaan'     => $this->request->getPost('id_perusahaan'),
            'nama'              => $this->request->getPost('nama'),
            'slug'              => $slug,
            'no_telp'           => $this->request->getPost('no_telp'),
            'email'             => $this->request->getPost('email'),
            'status'            => $this->request->getPost('status'),
            'tgl_registrasi'    => $this->request->getPost('tgl_registrasi'),
            'note'              => $this->request->getPost('note'),
        ];
        $modelCustomer->save($data);

        session()->setFlashdata('pesan', 'Data berhasil diedit.');

        return redirect()->to('/resource-customer');
    }


    public function remove($id = null)
    {
        //
    }


    public function delete($id = null)
    {
        $modelCustomer = new CustomerModel();

        $modelCustomer->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/resource-customer');
    }
}
