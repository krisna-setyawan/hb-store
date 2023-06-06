<?php

namespace App\Controllers\Resource;

use App\Models\Resource\JasaModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Jasa extends ResourcePresenter
{
    protected $helpers = ['form'];


    public function index()
    {
        $modelJasa = new JasaModel();
        $jasa = $modelJasa->getJasa();

        $data = [
            'jasa' => $jasa
        ];

        return view('resource/jasa/index', $data);
    }


    public function show($id = null)
    {
        //
    }


    public function new()
    {
        $db = \Config\Database::connect();
        $builder_jasa_kategori = $db->table('jasa_kategori');

        $data = [
            'validation'    => \Config\Services::validation(),
            'kategori'      => $builder_jasa_kategori->get()->getResultArray()
        ];
        return view('resource/jasa/add', $data);
    }


    public function create()
    {
        $validasi = [
            'nama' => [
                'rules' => 'required|is_unique[jasa.nama]',
                'errors' => [
                    'required' => '{field} jasa harus diisi.',
                    'is_unique' => 'nama jasa sudah ada dalam database.'
                ]
            ],
            'biaya' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} jasa harus diisi.',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} jasa harus diisi.',
                ]
            ],
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kategori jasa harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            return redirect()->to('/resource-jasa/new')->withInput();
        }

        $db = \Config\Database::connect();
        $builder_jasa_kategori = $db->table('jasa_kategori');

        if (strpos($this->request->getPost('kategori'), '-krisna-') !== false) {
            $post_kategori = explode('-', $this->request->getPost('kategori'));
            $the_id_kategori = $post_kategori[0];
        } else {
            $builder_jasa_kategori->insert(['nama' => $this->request->getPost('kategori')]);
            $the_id_kategori = $db->insertID();
        }

        $modelJasa = new JasaModel();

        $slug = url_title($this->request->getPost('nama'), '-', true);

        $biaya = str_replace(".", "", $this->request->getPost('biaya'));

        $data = [
            'id_kategori' => $the_id_kategori,
            'nama' => $this->request->getPost('nama'),
            'slug' => $slug,
            'biaya' => $biaya,
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];
        $modelJasa->save($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/resource-jasa');
    }


    public function edit($id = null)
    {
        $modelJasa = new JasaModel();
        $db = \Config\Database::connect();
        $builder_jasa_kategori = $db->table('jasa_kategori');

        $data = [
            'validation'    => \Config\Services::validation(),
            'jasa'          => $modelJasa->where(['id' => $id])->first(),
            'kategori'      => $builder_jasa_kategori->get()->getResultArray()
        ];

        return view('resource/jasa/edit', $data);
    }


    public function update($id = null)
    {
        $modelJasa = new JasaModel();
        $old_jasa = $modelJasa->find($id);

        if ($old_jasa['nama'] == $this->request->getPost('nama')) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[jasa.nama]';
        }

        $validasi = [
            'nama' => [
                'rules' => $rule_nama,
                'errors' => [
                    'required' => '{field} jasa harus diisi.',
                    'is_unique' => 'nama jasa sudah ada dalam database.'
                ]
            ],
            'biaya' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} jasa harus diisi.',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} jasa harus diisi.',
                ]
            ],
            'kategori' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kategori jasa harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            return redirect()->to('/resource-jasa/' . $old_jasa["id"] . '/edit')->withInput();
        }

        $db = \Config\Database::connect();
        $builder_jasa_kategori = $db->table('jasa_kategori');

        if (strpos($this->request->getPost('kategori'), '-krisna-') !== false) {
            $post_kategori = explode('-', $this->request->getPost('kategori'));
            $the_id_kategori = $post_kategori[0];
        } else {
            $builder_jasa_kategori->insert(['nama' => $this->request->getPost('kategori')]);
            $the_id_kategori = $db->insertID();
        }

        $slug = url_title($this->request->getPost('nama'), '-', true);

        $biaya = str_replace(".", "", $this->request->getPost('biaya'));

        $data = [
            'id'        => $id,
            'id_kategori' => $the_id_kategori,
            'nama'      => $this->request->getPost('nama'),
            'slug'      => $slug,
            'biaya'     => $biaya,
            'deskripsi'    => $this->request->getPost('deskripsi'),
        ];
        $modelJasa->save($data);

        session()->setFlashdata('pesan', 'Data berhasil diedit.');

        return redirect()->to('/resource-jasa');
    }


    public function remove($id = null)
    {
        //
    }


    public function delete($id = null)
    {
        $modelJasa = new JasaModel();

        $modelJasa->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/resource-jasa');
    }
}
