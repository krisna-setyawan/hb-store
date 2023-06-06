<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Resource\PelanggaranModel;

class PelanggaranSeeder extends Seeder
{
    public function run()
    {
        $pelanggaran = new PelanggaranModel();
        $pelanggaran->insert([ //1
            'nama_pelanggaran' => 'Karyawan tidak masuk kerja tanpa keterangan atau alfa',
            'range_point' => '20'
        ]);
        $pelanggaran->insert([ //2
            'nama_pelanggaran' => 'Tidak masuk kerja dengan keterangan sakit lebih dari 2 hari tanpa Surat Keterangan Sakit',
            'range_point' => '10'
        ]);
        $pelanggaran->insert([ //3
            'nama_pelanggaran' => 'Karyawan WFA namun tidak merespon ketika diperlukan maksimal 60 menit',
            'range_point' => '5'
        ]);
        $pelanggaran->insert([ //4
            'nama_pelanggaran' => 'Karyawan tidak melakukan konfirmasi atau koordinasi sebelum; libur, izin libur, izin masuk setengah hari, izin WFA, izin lembur, izin sakit, izin khusus, atau izin lain',
            'range_point' => '2-20',
        ]);
        $pelanggaran->insert([ //5
            'nama_pelanggaran' => 'Karyawan datang terlambat atau pulang lebih awal dari jam kerja',
            'range_point' => '2',
        ]);
        $pelanggaran->insert([ //6
            'nama_pelanggaran' => 'Karyawan mengabaikan atau tidak mengerjakan tugas',
            'range_point' => '5'
        ]);
        $pelanggaran->insert([ //7
            'nama_pelanggaran' => 'Karyawan melawan perintah penanggung jawab tanpa alasan yang tepat',
            'range_point' => '5-10'
        ]);
        $pelanggaran->insert([ //8
            'nama_pelanggaran' => 'Karyawan memanfaatkan jabatan, wewenang, fasilitas, dan hal lain yang dapat merugikan',
            'range_point' => '10-30'
        ]);
        $pelanggaran->insert([ //9
            'nama_pelanggaran' => 'Karyawan memanipulasi data Perusahaan yang dapat merugikan Perusahaan',
            'range_point' => '30-100',
        ]);
        $pelanggaran->insert([ //10
            'nama_pelanggaran' => 'Karyawan membuang sampah sembarang dalam lingkungan Perusahaan',
            'range_point' => '2',
        ]);
        $pelanggaran->insert([ //11
            'nama_pelanggaran' => 'Karyawan tidak melaksanakan piket saat jadwalnya piket',
            'range_point' => '5',
        ]);
        $pelanggaran->insert([ //12
            'nama_pelanggaran' => 'Karyawan mengganggu kenyamanan pihak lain tanpa izin pihak yang bersangkutan',
            'range_point' => '5',
        ]);
        $pelanggaran->insert([ //13
            'nama_pelanggaran' => 'Karyawan menghina atau merendahkan pihak lain tanpa izin pihak yang bersangkutan',
            'range_point' => '5',
        ]);
        $pelanggaran->insert([ //14
            'nama_pelanggaran' => 'Karyawan mencampuri urusan pribadi pihak lain tanpa izin pihak yang bersangkutan',
            'range_point' => '5',
        ]);
        $pelanggaran->insert([ //15
            'nama_pelanggaran' => 'Karyawan membawa permasalahan pribadi ke dalam Perusahaan yang mana dapat mempengaruhi urusan pekerjaan',
            'range_point' => '5',
        ]);
        $pelanggaran->insert([ //16
            'nama_pelanggaran' => 'Karyawan membuat kegaduhan atau suasana yang tidak kondusif dalam Perusahaan',
            'range_point' => '5',
        ]);
        $pelanggaran->insert([ //17
            'nama_pelanggaran' => 'Karyawan berkelahi atau melakukan tindak kekerasan dalam lingkungan Perusahaan',
            'range_point' => '10-100',
        ]);
        $pelanggaran->insert([ //18
            'nama_pelanggaran' => 'Karyawan menjalin hubungan asmara dalam lingkungan Perusahaan',
            'range_point' => '5-50',
        ]);
        $pelanggaran->insert([ //19
            'nama_pelanggaran' => 'Karyawan melakukan tindak pelecehan sexual dan atau perbuatan asusila dalam lingkungan Perusahaan',
            'range_point' => '100',
        ]);
        $pelanggaran->insert([ //20
            'nama_pelanggaran' => 'Karyawan melakukan sesuatu yang berbahaya dan atau melanggar hukum dalam lingkungan Perusahaan',
            'range_point' => '100',
        ]);
        $pelanggaran->insert([ //21
            'nama_pelanggaran' => 'Karyawan membawa sesuatu yang berbahaya dan atau melanggar hukum dalam lingkungan Perusahaan',
            'range_point' => '50-100',
        ]);
        $pelanggaran->insert([ //22
            'nama_pelanggaran' => 'kali Karyawan berhubungan dengan sesuatu yang berbahaya dan atau melanggar hukum dalam lingkungan Perusahaan',
            'range_point' => '10-100',
        ]);
        $pelanggaran->insert([ //23
            'nama_pelanggaran' => 'Karyawan terlibat secara tidak langsung atau setidaknya mengetahui, ketidaksesuaian atau suatu pelanggaran yang terjadi dalam lingkungan Perusahaan, dan tidak melapor kepada Penanggung jawab',
            'range_point' => '',
        ]);
        $pelanggaran->insert([ //24
            'nama_pelanggaran' => 'Karyawan merusak atau menghilangkan sarana dan prasarana Perusahaan',
            'range_point' => '1-50',
        ]);
        $pelanggaran->insert([ //25
            'nama_pelanggaran' => 'Karyawan membawa narkoba atau obat-obatan terlarang',
            'range_point' => '100',
        ]);
        $pelanggaran->insert([ //26
            'nama_pelanggaran' => 'Karyawan membawa minuman beralkohol dalam lingkungan Perusahaan',
            'range_point' => '50-100',
        ]);
        $pelanggaran->insert([ //27
            'nama_pelanggaran' => 'Karyawan membawa sesuatu yang dapat menimbulkan konflik, rasis dan sara, seperti atribut partai politik, keagamaan, kebudayaan, dan lain-lain dalam lingkungan Perusahaan',
            'range_point' => '5-50',
        ]);
        $pelanggaran->insert([ //28
            'nama_pelanggaran' => 'Karyawan merokok / vape / sejenisnya dalam lingkungan Perusahaan',
            'range_point' => '2-5',
        ]);
        $pelanggaran->insert([ //29
            'nama_pelanggaran' => 'Karyawan berkata kotor atau kasar dalam lingkungan Perusahaan yang mana dapat mempengaruhi urusan pekerjaan',
            'range_point' => '1-2',
        ]);
        $pelanggaran->insert([ //30
            'nama_pelanggaran' => 'Karyawan cengeng dan mempermasalahkan sesuatu yang bukan merupakan masalah',
            'range_point' => '1',
        ]);
        $pelanggaran->insert([ //31
            'nama_pelanggaran' => 'Karyawan tidak melakukan pelanggaran selama 6 hari akan mendapat tambahan point',
            'range_point' => '2',
        ]);
    }
}
