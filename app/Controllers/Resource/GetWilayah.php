<?php

namespace App\Controllers;

class GetWilayah extends BaseController
{
    public function KotaByProvinsi()
    {
        $id_provinsi = $this->request->getVar('id_provinsi');

        $db      = \Config\Database::connect();
        $builderKota = $db->table('kota');
        $builderKota->select('*');
        $builderKota->where('id_provinsi', $id_provinsi);
        $builderKota->orderBy('nama');
        $list_kota = $builderKota->get()->getResult();

        if ($list_kota) {
            foreach ($list_kota as $kt) {
                echo " <option value='$kt->id'> $kt->nama </option> ";
            }
        } else {
            echo " <option selected value=''>Kota Tidak Ditemukan</option> ";
        }
    }

    public function KecamatanByKota()
    {
        $id_kota = $this->request->getVar('id_kota');

        $db      = \Config\Database::connect();
        $builderKecamatan = $db->table('kecamatan');
        $builderKecamatan->select('*');
        $builderKecamatan->where('id_kota', $id_kota);
        $builderKecamatan->orderBy('nama');
        $list_kecamatan = $builderKecamatan->get()->getResult();

        if ($list_kecamatan) {
            foreach ($list_kecamatan as $kt) {
                echo " <option value='$kt->id'> $kt->nama </option> ";
            }
        } else {
            echo " <option selected value=''>Kecamatan Tidak Ditemukan</option> ";
        }
    }

    public function KelurahanByKecamatan()
    {
        $id_kecamatan = $this->request->getVar('id_kecamatan');

        $db      = \Config\Database::connect();
        $builderKelurahan = $db->table('kelurahan');
        $builderKelurahan->select('*');
        $builderKelurahan->where('id_kecamatan', $id_kecamatan);
        $builderKelurahan->orderBy('nama');
        $list_kelurahan = $builderKelurahan->get()->getResult();

        if ($list_kelurahan) {
            foreach ($list_kelurahan as $kt) {
                echo " <option value='$kt->id'> $kt->nama </option> ";
            }
        } else {
            echo " <option selected value=''>Kelurahan Tidak Ditemukan</option> ";
        }
    }
}
