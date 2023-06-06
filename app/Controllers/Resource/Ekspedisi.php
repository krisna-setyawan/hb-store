<?php

namespace App\Controllers\Resource;

use App\Models\Resource\EkspedisiModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Ekspedisi extends ResourcePresenter
{
    protected $helpers = ['form'];
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $modelEkspedisi = new EkspedisiModel();
        $ekspedisi = $modelEkspedisi->findAll();

        $data = [
            'ekspedisi' => $ekspedisi
        ];

        return view('resource/ekspedisi/index', $data);
    }

    /**
     * Present a view to present a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        $data = ['validation' => \Config\Services::validation()];
        return view('resource/ekspedisi/add', $data);
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        $validasi = [
            'nama' => [
                'rules' => 'required|is_unique[ekspedisi.nama]',
                'errors' => [
                    'required' => '{field} ekspedisi harus diisi.',
                    'is_unique' => 'nama ekspedisi sudah ada dalam database.'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} ekspedisi harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            return redirect()->to('/resource-ekspedisi/new')->withInput();
        }

        $modelEkspedisi = new EkspedisiModel();

        $slug = url_title($this->request->getPost('nama'), '-', true);

        $data = [
            'nama' => $this->request->getPost('nama'),
            'slug' => $slug,
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];
        $modelEkspedisi->save($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/resource-ekspedisi');
    }

    /**
     * Present a view to edit the properties of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $modelEkspedisi = new EkspedisiModel();

        $data = [
            'validation' => \Config\Services::validation(),
            'ekspedisi' => $modelEkspedisi->where(['id' => $id])->first()
        ];

        return view('resource/ekspedisi/edit', $data);
    }

    /**
     * Process the updating, full or partial, of a specific resource object.
     * This should be a POST.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $modelEkspedisi = new EkspedisiModel();
        $old_ekspedisi = $modelEkspedisi->find($id);

        if ($old_ekspedisi['nama'] == $this->request->getPost('nama')) {
            $rule_nama = 'required';
        } else {
            $rule_nama = 'required|is_unique[ekspedisi.nama]';
        }

        $validasi = [
            'nama' => [
                'rules' => $rule_nama,
                'errors' => [
                    'required' => '{field} ekspedisi harus diisi.',
                    'is_unique' => 'nama ekspedisi sudah ada dalam database.'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} ekspedisi harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($validasi)) {
            return redirect()->to('/resource-ekspedisi/' . $old_ekspedisi["id"] . '/edit')->withInput();
        }

        $slug = url_title($this->request->getPost('nama'), '-', true);

        $data = [
            'id'        => $id,
            'nama'      => $this->request->getPost('nama'),
            'slug'      => $slug,
            'deskripsi'    => $this->request->getPost('deskripsi'),
        ];
        $modelEkspedisi->save($data);

        session()->setFlashdata('pesan', 'Data berhasil diedit.');

        return redirect()->to('/resource-ekspedisi');
    }

    /**
     * Present a view to confirm the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function remove($id = null)
    {
        //
    }

    /**
     * Process the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $modelEkspedisi = new EkspedisiModel();

        $modelEkspedisi->delete($id);

        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/resource-ekspedisi');
    }
}
