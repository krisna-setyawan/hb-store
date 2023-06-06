<?php

namespace App\Database\Seeds;

use App\Models\Resource\KaryawanModel;
use CodeIgniter\Database\Seeder;
use App\Models\Resource\UserModel;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Password;

class UserSeeder extends Seeder
{
    public function run()
    {
        $karyawan = new KaryawanModel();
        $users = new UserModel();
        $groups = new GroupModel();

        // Menambah superadmin
        //1
        // Programmer
        $karyawan->insert([
            'id_grup'          => 1,
            'id_divisi'        => null,
            'nik'              => '001',
            'jabatan'          => 'Manajer',
            'nama_lengkap'     => 'Krisna',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'krisna@gmail.com',
        ]);
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Krisna',
            'email' => 'krisna@gmail.com',
            'username' => 'krisna',
            'password_hash' => Password::hash('krisna'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 1);


        // Programmer
        $karyawan->insert([
            'id_grup'          => 1,
            'id_divisi'        => null,
            'nik'              => '0011',
            'jabatan'          => 'Programmer',
            'nama_lengkap'     => 'Ferika',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'ferika@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Ferika',
            'email' => 'ferika@gmail.com',
            'username' => 'ferika',
            'password_hash' => Password::hash('ferika'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 1);



        // OWNER
        $karyawan->insert([
            'id_grup'          => 2,
            'id_divisi'        => null,
            'nik'              => '002',
            'jabatan'          => 'Dirut',
            'nama_lengkap'     => 'Farhan',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'farhan@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Farhan',
            'email' => 'farhan@gmail.com',
            'username' => 'farhan',
            'password_hash' => Password::hash('farhan'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 2);


        // Manajer
        $karyawan->insert([
            'id_grup'          => 3,
            'id_divisi'        => null,
            'nik'              => '003',
            'jabatan'          => 'Manajer',
            'nama_lengkap'     => 'Muin',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'muin@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Muin',
            'email' => 'muin@gmail.com',
            'username' => 'muin',
            'password_hash' => Password::hash('muin'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 3);


        // Manajer
        $karyawan->insert([
            'id_grup'          => 3,
            'id_divisi'        => null,
            'nik'              => '0031',
            'jabatan'          => '-',
            'nama_lengkap'     => 'Anam',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'anam@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Anam',
            'email' => 'anam@gmail.com',
            'username' => 'anam',
            'password_hash' => Password::hash('anam'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 3);


        // SPV
        $karyawan->insert([
            'id_grup'          => 4,
            'id_divisi'        => null,
            'nik'              => '004',
            'jabatan'          => 'Marketing',
            'nama_lengkap'     => 'Boy',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'boy@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Boy',
            'email' => 'boy@gmail.com',
            'username' => 'boy',
            'password_hash' => Password::hash('boy'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 4);


        // SPV
        $karyawan->insert([
            'id_grup'          => 4,
            'id_divisi'        => null,
            'nik'              => '0041',
            'jabatan'          => 'Procurement',
            'nama_lengkap'     => 'fifa',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'fifa@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Fifa',
            'email' => 'fifa@gmail.com',
            'username' => 'fifa',
            'password_hash' => Password::hash('fifa'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 4);


        // HR
        $karyawan->insert([
            'id_grup'          => 5,
            'id_divisi'        => null,
            'nik'              => '005',
            'jabatan'          => 'HRD',
            'nama_lengkap'     => 'Alim',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'alim@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Alim',
            'email' => 'alim@gmail.com',
            'username' => 'alim',
            'password_hash' => Password::hash('alim'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 5);


        // Team Finance
        $karyawan->insert([
            'id_grup'          => 6,
            'id_divisi'        => null,
            'nik'              => '006',
            'jabatan'          => 'Finance',
            'nama_lengkap'     => 'fifi',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'fifi@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Fifi',
            'email' => 'fifi@gmail.com',
            'username' => 'fifi',
            'password_hash' => Password::hash('fifi'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 6);


        // Team Procurement
        $karyawan->insert([
            'id_grup'          => 7,
            'id_divisi'        => null,
            'nik'              => '007',
            'jabatan'          => 'Procurement',
            'nama_lengkap'     => 'Riska',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'riska@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Riska',
            'email' => 'riska@gmail.com',
            'username' => 'riska',
            'password_hash' => Password::hash('riska'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 7);


        // Team Procurement
        $karyawan->insert([
            'id_grup'          => 7,
            'id_divisi'        => null,
            'nik'              => '0071',
            'jabatan'          => 'Procurement',
            'nama_lengkap'     => 'Adin',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'adin@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Adin',
            'email' => 'adin@gmail.com',
            'username' => 'adin',
            'password_hash' => Password::hash('adin'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 7);


        // Team Analyst
        $karyawan->insert([
            'id_grup'          => 8,
            'id_divisi'        => null,
            'nik'              => '006',
            'jabatan'          => 'Analyst',
            'nama_lengkap'     => 'Feby',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'feby@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Feby',
            'email' => 'feby@gmail.com',
            'username' => 'feby',
            'password_hash' => Password::hash('feby'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 8);


        // Team Resource & IT supp
        $karyawan->insert([
            'id_grup'          => 9,
            'id_divisi'        => null,
            'nik'              => '009',
            'jabatan'          => 'Resource',
            'nama_lengkap'     => 'Yosi',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'yosi@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Yosi',
            'email' => 'yosi@gmail.com',
            'username' => 'yosi',
            'password_hash' => Password::hash('yosi'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 9);
        $groups->addUserToGroup($users->getInsertID(), 12);


        // Team Gudang
        $karyawan->insert([
            'id_grup'          => 10,
            'id_divisi'        => null,
            'nik'              => '010',
            'jabatan'          => '-',
            'nama_lengkap'     => 'Kevin',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'kevin@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Kevin',
            'email' => 'kevin@gmail.com',
            'username' => 'kevin',
            'password_hash' => Password::hash('kevin'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 10);


        // Team Sales
        $karyawan->insert([
            'id_grup'          => 11,
            'id_divisi'        => null,
            'nik'              => '011',
            'jabatan'          => 'Sales',
            'nama_lengkap'     => 'Amy',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'amy@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Amy',
            'email' => 'amy@gmail.com',
            'username' => 'amy',
            'password_hash' => Password::hash('amy'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 11);


        // Team Sales
        $karyawan->insert([
            'id_grup'          => 11,
            'id_divisi'        => null,
            'nik'              => '0111',
            'jabatan'          => 'Sales',
            'nama_lengkap'     => 'Galuh',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'galuh@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Galuh',
            'email' => 'galuh@gmail.com',
            'username' => 'galuh',
            'password_hash' => Password::hash('galuh'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 11);


        // Team Marketing
        $karyawan->insert([
            'id_grup'          => 13,
            'id_divisi'        => null,
            'nik'              => '013',
            'jabatan'          => 'Marketing',
            'nama_lengkap'     => 'Dina',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'dina@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Dina',
            'email' => 'dina@gmail.com',
            'username' => 'dina',
            'password_hash' => Password::hash('dina'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 13);


        // Team Marketing
        $karyawan->insert([
            'id_grup'          => 13,
            'id_divisi'        => null,
            'nik'              => '0131',
            'jabatan'          => 'Marketing',
            'nama_lengkap'     => 'Ila',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'ila@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'Ila',
            'email' => 'ila@gmail.com',
            'username' => 'ila',
            'password_hash' => Password::hash('ila'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 13);


        // Team Service
        $karyawan->insert([
            'id_grup'          => 14,
            'id_divisi'        => null,
            'nik'              => '014',
            'jabatan'          => 'Sales',
            'nama_lengkap'     => 'Mahbub',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'mahbub@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'mahbub',
            'email' => 'mahbub@gmail.com',
            'username' => 'mahbub',
            'password_hash' => Password::hash('mahbub'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 14);


        // Team Service
        $karyawan->insert([
            'id_grup'          => 14,
            'id_divisi'        => null,
            'nik'              => '014',
            'jabatan'          => 'Sales',
            'nama_lengkap'     => 'Desyta',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'PEREMPUAN',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'desyta@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'desyta',
            'email' => 'desyta@gmail.com',
            'username' => 'desyta',
            'password_hash' => Password::hash('desyta'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 14);


        // Team Creative
        $karyawan->insert([
            'id_grup'          => 15,
            'id_divisi'        => null,
            'nik'              => '015',
            'jabatan'          => 'Marketing',
            'nama_lengkap'     => 'Bagas',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'bagas@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'bagas',
            'email' => 'bagas@gmail.com',
            'username' => 'bagas',
            'password_hash' => Password::hash('bagas'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 15);


        // Team Creative
        $karyawan->insert([
            'id_grup'          => 15,
            'id_divisi'        => null,
            'nik'              => '0151',
            'jabatan'          => 'Marketing',
            'nama_lengkap'     => 'Adit',
            'alamat'           => 'BLITAR',
            'jenis_kelamin'    => 'LAKI-LAKI',
            'tempat_lahir'     => 'BLITAR',
            'tanggal_lahir'    => '2001-01-01',
            'agama'            => 'ISLAM',
            'pendidikan'       => 'D IV / S I',
            'no_telp'          => '085123123123',
            'email'            => 'adit@gmail.com',
        ]);
        // tambahkan user aplikasinya
        $users->insert([
            'id_karyawan' => $karyawan->getInsertID(),
            'name' => 'adit',
            'email' => 'adit@gmail.com',
            'username' => 'adit',
            'password_hash' => Password::hash('adit'),
            'active' => 1
        ]);
        // langsung menambahkan user kedalam group
        $groups->addUserToGroup($users->getInsertID(), 15);
    }
}
