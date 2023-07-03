<?php

use CodeIgniter\Config\Services;

function get_data_perushaan($id_perusahaan)
{
    $client = Services::curlrequest();

    $url_get_perusahaan = $_ENV['URL_API'] . 'public/get-perusahaan/' . $id_perusahaan;
    $response_get_perusahaan = $client->request('GET', $url_get_perusahaan);
    $status = $response_get_perusahaan->getStatusCode();
    $responseJson = $response_get_perusahaan->getBody();
    $responseArray = json_decode($responseJson, true);
    $perusahaan = $responseArray['data_perusahaan'][0];

    return $perusahaan;
}





// membuat kode api transaksi unik
function get_kode_trx_api()
{
    date_default_timezone_set('Asia/Jakarta');

    $timestamp = time(); // Mendapatkan UNIX timestamp saat ini
    return $timestamp;
}





function nomor_pemesanan_auto($tgl)
{
    $db = db_connect();

    $quer = "SELECT max(right(no_pemesanan, 2)) AS kode FROM pemesanan WHERE tanggal = '$tgl'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = ((int)$query['kode']) + 1;
        $kd = sprintf("%02s", $no);
    } else {
        $kd = "01";
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomor_auto = 'PMS' . date('dmy', strtotime($tgl)) . $kd;

    return $nomor_auto;
}






// FINANCE -------------------------------------------------------------------------------------------------

function jurnal_nomor_auto($tgl)
{
    $db    = db_connect();

    $quer  = "SELECT max(right(nomor_transaksi, 2)) AS nomor FROM transaksi_jurnal WHERE tanggal = '$tgl' AND nomor_transaksi LIKE '%MNL%'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $nomor = ((int)$query['nomor']) + 1;
        $kode  = sprintf("%02s", $nomor);
    } else {
        $kode = "01";
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomorAuto = 'MNL' . date('dmy', strtotime($tgl)) . $kode;

    return $nomorAuto;
}


function tagihan_nomor_auto($tgl)
{
    $db    = db_connect();

    $quer  = "SELECT max(right(no_tagihan, 2)) AS nomor FROM tagihan WHERE tanggal = '$tgl' AND no_tagihan LIKE '%TGH%'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $nomor = ((int)$query['nomor']) + 1;
        $kode  = sprintf("%02s", $nomor);
    } else {
        $kode = "01";
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomorAuto = 'TGH' . date('dmy', strtotime($tgl)) . $kode;

    return $nomorAuto;
}


function nomor_jurnal_auto_tagihan()
{
    $db = db_connect();

    $quer = "SELECT max(right(nomor_transaksi, 5)) AS kode FROM transaksi_jurnal WHERE nomor_transaksi LIKE '%JRN/TGH%'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = ((int)$query['kode']) + 1;
        $kd = sprintf("%05s", $no);
    } else {
        $kd = "00001";
    }
    $nomor_auto = 'JRN/TGH' . $kd;

    return $nomor_auto;
}







// PURCHASE -------------------------------------------------------------------------------------------------

function nomor_pembelian_auto($tgl)
{
    $db = db_connect();

    $quer = "SELECT max(right(no_pembelian, 2)) AS kode FROM pembelian WHERE tanggal = '$tgl'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = ((int)$query['kode']) + 1;
        $kd = sprintf("%02s", $no);
    } else {
        $kd = "01";
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomor_auto = 'PMB' . date('dmy', strtotime($tgl)) . $kd;

    return $nomor_auto;
}



function nomor_jurnal_auto_pembelian()
{
    $db = db_connect();

    $quer = "SELECT max(right(nomor_transaksi, 5)) AS kode FROM transaksi_jurnal WHERE nomor_transaksi LIKE '%JRN/PMB%'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = ((int)$query['kode']) + 1;
        $kd = sprintf("%05s", $no);
    } else {
        $kd = "00001";
    }
    $nomor_auto = 'JRN/PMB' . $kd;

    return $nomor_auto;
}



function nomor_tagihan_pembelian_auto($no_pembelian)
{
    $db = db_connect();

    $quer = "SELECT no_tagihan FROM tagihan WHERE id = (SELECT MAX(id) FROM tagihan WHERE no_tagihan LIKE '%$no_pembelian%');";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = intval(str_replace($no_pembelian . '-', '', $query['no_tagihan'])) + 1;
    } else {
        $no = 1;
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomor_auto = $no_pembelian . '-' . $no;

    return $nomor_auto;
}








// SALES -------------------------------------------------------------------------------------------------

function nomor_penawaran_auto($tgl)
{
    $db = db_connect();

    $quer = "SELECT max(right(no_penawaran, 2)) AS kode FROM penawaran WHERE tanggal = '$tgl'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = ((int)$query['kode']) + 1;
        $kd = sprintf("%02s", $no);
    } else {
        $kd = "01";
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomor_auto = 'PNW' . date('dmy', strtotime($tgl)) . $kd;

    return $nomor_auto;
}



function nomor_penjualan_auto($tgl)
{
    $db = db_connect();

    $quer = "SELECT max(right(no_penjualan, 2)) AS kode FROM penjualan WHERE tanggal = '$tgl'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = ((int)$query['kode']) + 1;
        $kd = sprintf("%02s", $no);
    } else {
        $kd = "01";
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomor_auto = 'PJL' . date('dmy', strtotime($tgl)) . $kd;

    return $nomor_auto;
}



function nomor_jurnal_auto_penjualan()
{
    $db = db_connect();

    $quer = "SELECT max(right(nomor_transaksi, 5)) AS kode FROM transaksi_jurnal WHERE nomor_transaksi LIKE '%JRN/PJL%'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = ((int)$query['kode']) + 1;
        $kd = sprintf("%05s", $no);
    } else {
        $kd = "00001";
    }
    $nomor_auto = 'JRN/PJL' . $kd;

    return $nomor_auto;
}



function nomor_tagihan_penjualan_auto($no_penjualan)
{
    $db = db_connect();

    $quer = "SELECT no_tagihan FROM tagihan WHERE id = (SELECT MAX(id) FROM tagihan WHERE no_tagihan LIKE '%$no_penjualan%');";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = intval(str_replace($no_penjualan . '-', '', $query['no_tagihan'])) + 1;
    } else {
        $no = 1;
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomor_auto = $no_penjualan . '-' . $no;

    return $nomor_auto;
}








// WAREHOUSE -------------------------------------------------------------------------------------------------

function nomor_stockopname_auto($tgl)
{
    $db = db_connect();

    $quer = "SELECT max(right(nomor, 2)) AS kode FROM stock_opname WHERE tanggal = '$tgl'";
    $query = $db->query($quer)->getRowArray();

    if ($query) {
        $no = ((int)$query['kode']) + 1;
        $kd = sprintf("%02s", $no);
    } else {
        $kd = "01";
    }
    date_default_timezone_set('Asia/Jakarta');
    $nomor_auto = 'SON' . date('dmy', strtotime($tgl)) . $kd;

    return $nomor_auto;
}
