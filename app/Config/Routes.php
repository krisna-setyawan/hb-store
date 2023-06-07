<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'AuthController::login');


// ------------------------------------------------------------------------------------------------------------------ API
$routes->get('hbapi-get-produks', 'Api\Produk::index');
$routes->get('hbapi-get-produk/(:any)', 'Api\Produk::show/$1');



$routes->group('', ['filter' => 'isLoggedIn'], function ($routes) {

    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'permission:Dashboard']);
    $routes->get('data-master', 'Menus::data_master', ['filter' => 'permission:Data Master']);
    $routes->get('hrm', 'Menus::hrm', ['filter' => 'permission:SDM']);
    $routes->get('finance', 'Menus::finance', ['filter' => 'permission:Keuangan']);
    $routes->get('purchase', 'Menus::purchase', ['filter' => 'permission:Pembelian']);
    $routes->get('sales', 'Menus::sales', ['filter' => 'permission:Penjualan']);
    $routes->get('warehouse', 'Menus::warehouse', ['filter' => 'permission:Gudang']);








    // ------------------------------------------------------------------------------------------------------------------ DATA MASTER
    // ------------------------------------------------------------------------------------------------------------------ DATA MASTER
    // GetData
    $routes->get('/wilayah/kota_by_provinsi', 'GetWilayah::KotaByProvinsi');
    $routes->get('/wilayah/kecamatan_by_kota', 'GetWilayah::KecamatanByKota');
    $routes->get('/wilayah/kelurahan_by_kecamatan', 'GetWilayah::KelurahanByKecamatan');

    // Supplier
    $routes->get('resource-supplier', 'Resource\Supplier::index', ['filter' => 'permission:Data Master']);
    $routes->get('resource-supplier/(:num)', 'Resource\Supplier::show/$1', ['filter' => 'permission:Data Master']);
    $routes->post('resource-supplier', 'Resource\Supplier::create', ['filter' => 'permission:Data Master,Admin Supplier']);
    $routes->get('resource-supplier/new', 'Resource\Supplier::new', ['filter' => 'permission:Data Master,Admin Supplier']);
    $routes->get('resource-supplier/(:num)/edit', 'Resource\Supplier::edit/$1', ['filter' => 'permission:Data Master,Admin Supplier']);
    $routes->put('resource-supplier/(:num)', 'Resource\Supplier::update/$1  ', ['filter' => 'permission:Data Master,Admin Supplier']);
    // $routes->delete('supplier/(:num) ', 'Resource\Supplier::delete/$1', ['filter' => 'permission:Data Master,Admin Supplier']);
    $routes->resource('resource-supplier', ['controller' => 'Resource\Supplier', 'filter' => 'permission:Data Master']);
    $routes->resource('resource-supplierpj', ['controller' => 'Resource\SupplierPJ', 'filter' => 'permission:Data Master']);
    $routes->resource('resource-supplieralamat', ['controller' => 'Resource\SupplierAlamat', 'filter' => 'permission:Data Master']);
    $routes->resource('resource-supplierlink', ['controller' => 'Resource\SupplierLink', 'filter' => 'permission:Data Master']);
    $routes->resource('resource-suppliercs', ['controller' => 'Resource\SupplierCs', 'filter' => 'permission:Data Master']);

    // Produk
    $routes->resource('resource-produk', ['controller' => 'Resource\Produk', 'filter' => 'permission:Data Master']);
    $routes->get('resource-getdataproduk', 'Resource\Produk::getDataProduk', ['filter' => 'permission:Data Master']);
    $routes->post('resource-produkplan', 'Resource\ProdukPlan::create', ['filter' => 'permission:Data Master']);

    // Customer
    $routes->get('resource-customer', 'Resource\Customer::index', ['filter' => 'permission:Data Master']);
    $routes->get('resource-customer/(:num)', 'Resource\Customer::show/$1', ['filter' => 'permission:Data Master']);
    $routes->post('resource-customer', 'Resource\Customer::create', ['filter' => 'permission:Data Master,Admin Customer']);
    $routes->get('resource-customer/new', 'Resource\Customer::new', ['filter' => 'permission:Data Master,Admin Customer']);
    $routes->get('resource-customer/(:num)/edit', 'Resource\Customer::edit/$1', ['filter' => 'permission:Data Master,Admin Customer']);
    $routes->put('customer/(:num)', 'Resource\Customer::update/$1  ', ['filter' => 'permission:Data Master,Admin Customer']);
    // $routes->delete('customer/(:num) ', 'Resource\Customer::delete/$1', ['filter' => 'permission:Data Master,Admin Customer']);
    $routes->resource('resource-customer', ['controller' => 'Resource\Customer', 'filter' => 'permission:Data Master']);
    $routes->resource('resource-customerpj', ['controller' => 'Resource\CustomerPJ', 'filter' => 'permission:Data Master']);
    $routes->resource('resource-customeralamat', ['controller' => 'Resource\CustomerAlamat', 'filter' => 'permission:Data Master']);
    $routes->resource('resource-customerrekening', ['controller' => 'Resource\CustomerRekening', 'filter' => 'permission:Data Master']);

    // Gudang
    $routes->get('resource-gudang', 'Resource\Gudang::index', ['filter' => 'permission:Data Master']);
    $routes->get('resource-gudang/(:num)', 'Resource\Gudang::show/$1', ['filter' => 'permission:Data Master']);
    $routes->post('resource-gudang', 'Resource\Gudang::create', ['filter' => 'permission:Data Master,Penanggung Jawab Gudang']);
    $routes->get('resource-gudang/new', 'Resource\Gudang::new', ['filter' => 'permission:Data Master,Penanggung Jawab Gudang']);
    $routes->get('resource-gudang/(:num)/edit', 'Resource\Gudang::edit/$1', ['filter' => 'permission:Data Master,Penanggung Jawab Gudang']);
    $routes->put('resource-gudang/(:num)', 'Resource\Gudang::update/$1  ', ['filter' => 'permission:Data Master,Penanggung Jawab Gudang']);
    // $routes->delete('gudang/(:num) ', 'Resource\Gudang::delete/$1', ['filter' => 'permission:Data Master,Penanggung Jawab Gudang']);
    $routes->resource('resource-gudang', ['controller' => 'Resource\Gudang', 'filter' => 'permission:Data Master']);
    $routes->resource('resource-gudangpj', ['controller' => 'Resource\GudangPJ', 'filter' => 'permission:Data Master']);

    $routes->resource('resource-ekspedisi', ['controller' => 'Resource\Ekspedisi', 'filter' => 'permission:Data Master']);
    $routes->resource('resource-jasa', ['controller' => 'Resource\Jasa', 'filter' => 'permission:Data Master']);

    // Perusahaan
    $routes->get('resource-perusahaan', 'Resource\Perusahaan::index', ['filter' => 'permission:Data Master']);
    $routes->get('resource-perusahaan/(:any)', 'Resource\Perusahaan::show/$1', ['filter' => 'permission:Data Master']);









    // ------------------------------------------------------------------------------------------------------------------ HRM ----
    // ------------------------------------------------------------------------------------------------------------------ HRM ----

    // Karyawan
    $routes->get('hrm-karyawan/redirect/(:any)', 'Hrm\Karyawan::redirect/$1', ['filter' => 'permission:SDM']);
    $routes->resource('hrm-karyawan', ['controller' => 'Hrm\Karyawan', 'filter' => 'permission:SDM']);


    // Divisi
    $routes->get('hrm-divisi/redirect/(:any)', 'Hrm\Divisi::redirect/$1', ['filter' => 'permission:SDM']);
    $routes->resource('hrm-divisi', ['controller' => 'Hrm\Divisi', 'filter' => 'permission:SDM']);


    //list
    $routes->get('hrm-list/(:num)', 'Hrm\DivisiList::index/$1', ['filter' => 'permission:SDM']);
    $routes->get('hrm-detail-list/(:num)', 'Hrm\DivisiList::show/$1', ['filter' => 'permission:SDM']);
    $routes->get('hrm-list-new/(:num)', 'Hrm\DivisiList::new/$1', ['filter' => 'permission:SDM']);
    $routes->post('hrm-list/create', 'Hrm\DivisiList::create', ['filter' => 'permission:SDM']);
    $routes->delete('hrm-list-delete/(:num)', 'Hrm\DivisiList::delete/$1', ['filter' => 'permission:SDM']);


    //user-group
    $routes->get('hrm-user-group/(:num)', 'Hrm\ListGroup::index/$1', ['filter' => 'permission:SDM']);
    $routes->post('hrm-group/create', 'Hrm\ListGroup::create', ['filter' => 'permission:SDM']);
    $routes->post('hrm-group-new', 'Hrm\ListGroup::new', ['filter' => 'permission:SDM']);
    $routes->delete('hrm-group-delete/(:num)/(:num)', 'Hrm\ListGroup::delete/$1/$2', ['filter' => 'permission:SDM']);


    //user-permission
    $routes->get('hrm-permission/(:num)', 'Hrm\UserPermission::index/$1', ['filter' => 'permission:SDM']);
    $routes->post('hrm-permission/create', 'Hrm\UserPermission::create', ['filter' => 'permission:SDM']);
    $routes->post('hrm-permission-new', 'Hrm\UserPermission::new', ['filter' => 'permission:SDM']);
    $routes->delete('hrm-user-permission/(:num)/(:num)', 'Hrm\UserPermission::delete/$1/$2', ['filter' => 'permission:SDM']);


    //group-permission
    $routes->get('hrm-group-permission/(:num)', 'Hrm\GroupPermission::index/$1', ['filter' => 'permission:SDM']);
    $routes->post('hrm-group-permission/create', 'Hrm\GroupPermission::create', ['filter' => 'permission:SDM']);
    $routes->post('hrm-group-permission-new', 'Hrm\GroupPermission::new', ['filter' => 'permission:SDM']);
    $routes->delete('hrm-group-permission/(:num)/(:num)', 'Hrm\GroupPermission::delete/$1/$2', ['filter' => 'permission:SDM']);


    //user
    $routes->get('hrm-user-permission-view', 'Hrm\User::view_user_permission', ['filter' => 'permission:SDM']);
    $routes->get('hrm-user-group-view', 'Hrm\User::view_group_user', ['filter' => 'permission:SDM']);
    $routes->get('hrm-group-permission-view', 'Hrm\User::view_group_permission', ['filter' => 'permission:SDM']);
    $routes->resource('hrm-user', ['controller' => 'Hrm\User', 'filter' => 'permission:SDM']);


    //rekrutment
    $routes->resource('hrm-rekrutmen', ['controller' => 'Hrm\Rekrutmen', 'filter' => 'permission:SDM']);


    //absensi
    $routes->resource('hrm-absensi', ['controller' => 'Hrm\Absensi', 'filter' => 'permission:SDM']);
    $routes->get('hrm-karyawan-absensi/(:num)', 'Hrm\KaryawanAbsen::index/$1', ['filter' => 'permission:SDM']);
    $routes->post('hrm-view-absensi-filter', 'Hrm\Absensi::viewAbsensi', ['filter' => 'permission:SDM']);
    $routes->post('hrm-karyawan-absen-new', 'Hrm\KaryawanAbsen::new', ['filter' => 'permission:SDM']);
    $routes->post('hrm-karyawan-absen/create', 'Hrm\KaryawanAbsen::create', ['filter' => 'permission:SDM']);


    //log absen
    $routes->get('hrm-log-absensi/(:num)/(:num)', 'Hrm\LogAbsen::index/$1/$2', ['filter' => 'permission:SDM']);
    $routes->post('hrm-log-absen-new', 'Hrm\LogAbsen::new', ['filter' => 'permission:SDM']);
    $routes->post('hrm-log-absen/create', 'Hrm\LogAbsen::create', ['filter' => 'permission:SDM']);
    $routes->delete('hrm-log-absen/(:num)', 'Hrm\LogAbsen::delete/$1', ['filter' => 'permission:SDM']);


    //pelanggaran
    $routes->resource('hrm-pelanggaran', ['controller' => 'Hrm\Pelanggaran', 'filter' => 'permission:SDM']);


    //pelanggaran karywan
    $routes->get('hrm-pelanggaran-karyawan/', 'Hrm\Pelanggaran::ViewKaryawan', ['filter' => 'permission:SDM']);
    $routes->get('hrm-menu-pelanggaran/', 'Hrm\Pelanggaran::ViewMenu', ['filter' => 'permission:SDM']);


    //point pelanggaran
    $routes->get('hrm-point-pelanggaran/(:num)', 'Hrm\PointPelanggaran::index/$1', ['filter' => 'permission:SDM']);
    $routes->post('hrm-point-pelanggaran/new', 'Hrm\PointPelanggaran::new', ['filter' => 'permission:SDM']);
    $routes->post('hrm-point-pelanggaran/create', 'Hrm\PointPelanggaran::create', ['filter' => 'permission:SDM']);
    $routes->delete('hrm-point-pelanggaran-delete/(:num)', 'Hrm\PointPelanggaran::delete/$1', ['filter' => 'permission:SDM']);


    //file karyawan
    $routes->get('hrm-file-karyawan/(:num)', 'Hrm\FileKaryawan::index/$1', ['filter' => 'permission:SDM']);
    $routes->get('hrm-file-karyawan/show/(:num)', 'Hrm\FileKaryawan::show/$1', ['filter' => 'permission:SDM']);
    $routes->get('hrm-file-karyawan/edit/(:num)/(:num)', 'Hrm\FileKaryawan::edit/$1/$2', ['filter' => 'permission:SDM']);
    $routes->get('hrm-file-karyawan/new/(:num)', 'Hrm\FileKaryawan::new/$1', ['filter' => 'permission:SDM']);
    $routes->post('hrm-tambah-file', 'Hrm\FileKaryawan::create', ['filter' => 'permission:SDM']);
    $routes->put('hrm-file-karyawan/update/(:num)', 'Hrm\FileKaryawan::update/$1', ['filter' => 'permission:SDM']);
    $routes->delete('hrm-file-karyawan/delete/(:num)', 'Hrm\FileKaryawan::delete/$1', ['filter' => 'permission:SDM']);









    // ------------------------------------------------------------------------------------------------------------------ FINANCE ----
    // ------------------------------------------------------------------------------------------------------------------ FINANCE ----


    $routes->get('finance-akun', 'Finance\Menu::Akun', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-laporan', 'Finance\Menu::Laporan', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-kategori', 'Finance\KategoriAkun::index', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-listakun', 'Finance\Akun::index', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-jurnalumum', 'Finance\Jurnal::index', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-neraca', 'Finance\Neraca::index', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-labarugi', 'Finance\LabaRugi::index', ['filter' => 'permission:Keuangan']);


    // Tagihan
    $routes->get('finance-tagihan', 'Finance\Tagihan::index', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-getDataTagihan', 'Finance\Tagihan::getDataTagihan', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-tagihan/(:num)', 'Finance\Tagihan::show/$1', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-tambahTagihan', 'Finance\Tagihan::new', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-tagihan/keakun', 'Finance\Tagihan::keakun', ['filter' => 'permission:Keuangan']);
    $routes->post('finance-tagihan/create', 'Finance\Tagihan::create', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-tagihan/(:num)/bayar', 'Finance\Tagihan::bayarTagihan/$1', ['filter' => 'permission:Keuangan']);
    $routes->post('finance-tagihan/doPay', 'Finance\Tagihan::payTagihan', ['filter' => 'permission:Keuangan']);


    //Kategori Akun
    $routes->get('finance-getDataKategori', 'Finance\KategoriAkun::getDataKategori', ['filter' => 'permission:Keuangan']);
    $routes->resource('finance-KategoriAkun', ['controller' => 'Finance\KategoriAkun', 'filter' => 'permission:Keuangan']);


    //Akun
    $routes->get('finance-getdataakun', 'Finance\Akun::getDataAkun', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-akun/buku/(:num)', 'Finance\Akun::buku/$1', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-listBuku', 'Finance\Akun::getListBukuBesar', ['filter' => 'permission:Keuangan']);
    $routes->resource('finance-akun', ['controller' => 'Finance\Akun', 'filter' => 'permission:Keuangan']);


    //Jurnal Umum
    $routes->get('finance-getdatajurnal', 'Finance\Jurnal::getDataJurnal', ['filter' => 'permission:Keuangan']);
    $routes->resource('finance-jurnal', ['controller' => 'Finance\Jurnal', 'filter' => 'permission:Keuangan']);
    $routes->get('finance-hapusBaris/(:num)/(:num)', 'Finance\Jurnal::hapusBaris/$1/$2', ['filter' => 'permission:Keuangan']);
    $routes->get('finance-getlistakun', 'Finance\Jurnal::akun', ['filter' => 'permission:Keuangan']);


    //Neraca
    $routes->get('finance-listNeraca', 'Finance\Neraca::getListNeraca', ['filter' => 'permission:Keuangan']);


    //Laba Rugi
    $routes->get('finance-listLabaRugi', 'Finance\LabaRugi::getListLabaRugi', ['filter' => 'permission:Keuangan']);









    // ------------------------------------------------------------------------------------------------------------------ PURCHASE ----
    // ------------------------------------------------------------------------------------------------------------------ PURCHASE ----

    // Supplier
    $routes->get('purchase-supplier', 'Purchase\Supplier::index', ['filter' => 'permission:Data Master']);
    $routes->get('purchase-supplier/(:num)', 'Purchase\Supplier::show/$1', ['filter' => 'permission:Data Master']);
    $routes->post('purchase-supplier', 'Purchase\Supplier::create', ['filter' => 'permission:Data Master,Admin Supplier']);
    $routes->get('purchase-supplier/new', 'Purchase\Supplier::new', ['filter' => 'permission:Data Master,Admin Supplier']);
    $routes->get('purchase-supplier/(:num)/edit', 'Purchase\Supplier::edit/$1', ['filter' => 'permission:Data Master,Admin Supplier']);
    $routes->put('purchase-supplier/(:num)', 'Purchase\Supplier::update/$1  ', ['filter' => 'permission:Data Master,Admin Supplier']);
    // $routes->delete('purchase-supplier/(:num) ', 'Purchase\Supplier::delete/$1', ['filter' => 'permission:Data Master,Admin Supplier']);
    $routes->resource('purchase-supplier', ['controller' => 'Purchase\Supplier', 'filter' => 'permission:Data Master']);
    $routes->resource('purchase-supplierpj', ['controller' => 'Purchase\SupplierPJ', 'filter' => 'permission:Data Master']);
    $routes->resource('purchase-supplieralamat', ['controller' => 'Purchase\SupplierAlamat', 'filter' => 'permission:Data Master']);
    $routes->resource('purchase-supplierlink', ['controller' => 'Purchase\SupplierLink', 'filter' => 'permission:Data Master']);
    $routes->resource('purchase-suppliercs', ['controller' => 'Purchase\SupplierCs', 'filter' => 'permission:Data Master']);

    // Produk
    $routes->resource('purchase-produk', ['controller' => 'Purchase\Produk', 'filter' => 'permission:Data Master']);
    $routes->get('purchase-getdataproduk', 'Purchase\Produk::getDataProduk', ['filter' => 'permission:Data Master']);
    $routes->post('purchase-produkplan', 'Purchase\ProdukPlan::create', ['filter' => 'permission:Data Master']);

    // Pemesanan
    $routes->resource('purchase-pemesanan', ['controller' => 'Purchase\Pemesanan', 'filter' => 'permission:Pembelian']);
    $routes->get('purchase-getdatapemesanan', 'Purchase\Pemesanan::getDataPemesanan', ['filter' => 'permission:Pembelian']);
    $routes->get('purchase-repeat_pemesanan/(:any)', 'Purchase\Pemesanan::repeatPemesanan/$1', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-save_repeat_pemesanan', 'Purchase\Pemesanan::saveRepeat', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-alasan_hapus_pemesanan', 'Purchase\Pemesanan::alasanHapusPemesanan', ['filter' => 'permission:Pembelian']);
    // Pemesanan Detail
    $routes->get('purchase-get_produk_add_list/(:any)', 'Purchase\Pemesanan_detail::getProdukForAddList/$1', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-find_produk_by_nama_sku', 'Purchase\Pemesanan_detail::findProdukByNamaSKU', ['filter' => 'permission:Pembelian']);
    $routes->get('purchase-list_pemesanan/(:any)', 'Purchase\Pemesanan_detail::List_pemesanan/$1', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-ganti_no_pemesanan', 'Purchase\Pemesanan_detail::gantiNoPemesanan', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-simpan_pemesanan', 'Purchase\Pemesanan_detail::simpanPemesanan', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-kirim_pemesanan', 'Purchase\Pemesanan_detail::kirimPemesanan', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-produks_pemesanan', 'Purchase\Pemesanan_detail::getListProdukPemesanan', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-check_list_produk', 'Purchase\Pemesanan_detail::checkListProduk', ['filter' => 'permission:Pembelian']);
    $routes->resource('purchase-pemesanan_detail', ['controller' => 'Purchase\Pemesanan_detail', 'filter' => 'permission:Pembelian']);

    // Fixing Pemesanan
    $routes->get('purchase-fixing_pemesanan', 'Purchase\Pemesanan_fixing::index', ['filter' => 'permission:Pembelian']);
    $routes->get('purchase-get_pemesanan_ordered', 'Purchase\Pemesanan_fixing::getDataPemesananOrdered', ['filter' => 'permission:Pembelian']);
    // Fixing Pemesanan Detail
    $routes->get('purchase-list_fixing/(:any)', 'Purchase\Pemesanan_detail_fixing::ListFixing/$1', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-produks_pembelian', 'Purchase\Pemesanan_detail_fixing::getListProdukPembelian', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-ganti_no_pembelian', 'Purchase\Pemesanan_detail_fixing::gantiNoPembelian', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-fixing_produk_create', 'Purchase\Pemesanan_detail_fixing::create', ['filter' => 'permission:Pembelian']);
    $routes->put('purchase-fixing_produk_update/(:any)', 'Purchase\Pemesanan_detail_fixing::update/$1', ['filter' => 'permission:Pembelian']);
    $routes->delete('purchase-fixing_produk_delete/(:any)', 'Purchase\Pemesanan_detail_fixing::delete/$1', ['filter' => 'permission:Pembelian']);

    // Pembelian
    $routes->resource('purchase-pembelian', ['controller' => 'Purchase\Pembelian', 'filter' => 'permission:Pembelian']);
    $routes->get('purchase-get_data_pembelian', 'Purchase\Pembelian::getDataPembelian', ['filter' => 'permission:Pembelian']);
    $routes->get('purchase-show_data_pembelian/(:any)', 'Purchase\Pembelian::show/$1', ['filter' => 'permission:Pembelian']);
    $routes->get('purchase-show_tagihan_pembelian/(:any)', 'Purchase\Pembelian::showTagihan/$1', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-tambah_tagihan', 'Purchase\Pembelian::tambahTagihan', ['filter' => 'permission:Pembelian']);
    $routes->get('purchase-show_rincian_tagihan/(:any)', 'Purchase\Pembelian::showRincianTagihan/$1', ['filter' => 'permission:Pembelian']);
    $routes->get('purchase-show_pembayaran_tagihan/(:any)', 'Purchase\Pembelian::showPembayaranTagihan/$1', ['filter' => 'permission:Pembelian']);
    $routes->get('purchase-get_list_inbound_pembelian/(:any)', 'Purchase\Pembelian::listInboundPembelian/$1');
    $routes->get('purchase-show_detail_inbound/(:any)', 'Purchase\Pembelian::showDetailInbound/$1');
    $routes->post('purchase-check_produk_pembelian', 'Purchase\Pembelian::checkProdukPembelian', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-simpan_pembelian', 'Purchase\Pembelian::simpanPembelian', ['filter' => 'permission:Pembelian']);
    $routes->post('purchase-buat_pembelian', 'Purchase\Pembelian::buatPembelian', ['filter' => 'permission:Pembelian']);









    // ------------------------------------------------------------------------------------------------------------------ SALES ----
    // ------------------------------------------------------------------------------------------------------------------ SALES ----

    // Customer
    $routes->get('sales-customer', 'Sales\Customer::index', ['filter' => 'permission:Data Master']);
    $routes->get('sales-customer/(:num)', 'Sales\Customer::show/$1', ['filter' => 'permission:Data Master']);
    $routes->post('sales-customer', 'Sales\Customer::create', ['filter' => 'permission:Data Master,Admin Customer']);
    $routes->get('sales-customer/new', 'Sales\Customer::new', ['filter' => 'permission:Data Master,Admin Customer']);
    $routes->get('sales-customer/(:num)/edit', 'Sales\Customer::edit/$1', ['filter' => 'permission:Data Master,Admin Customer']);
    $routes->put('sales-customer/(:num)', 'Sales\Customer::update/$1  ', ['filter' => 'permission:Data Master,Admin Customer']);
    // $routes->delete('sales-customer/(:num) ', 'Sales\Customer::delete/$1', ['filter' => 'permission:Data Master,Admin Customer']);
    $routes->resource('sales-customer', ['controller' => 'Sales\Customer', 'filter' => 'permission:Data Master']);
    $routes->resource('sales-customerpj', ['controller' => 'Sales\CustomerPJ', 'filter' => 'permission:Data Master']);
    $routes->resource('sales-customeralamat', ['controller' => 'Sales\CustomerAlamat', 'filter' => 'permission:Data Master']);
    $routes->resource('sales-customerrekening', ['controller' => 'Sales\CustomerRekening', 'filter' => 'permission:Data Master']);

    // Produk
    $routes->resource('sales-produk', ['controller' => 'Sales\Produk', 'filter' => 'permission:Data Master']);
    $routes->get('sales-getdataproduk', 'Sales\Produk::getDataProduk', ['filter' => 'permission:Data Master']);
    $routes->post('sales-produkplan', 'Sales\ProdukPlan::create', ['filter' => 'permission:Data Master']);



    // Penawaran
    $routes->resource('sales-penawaran', ['controller' => 'Sales\Penawaran', 'filter' => 'permission:Penjualan']);
    $routes->get('sales-getdatapenawaran', 'Sales\Penawaran::getDataPenawaran', ['filter' => 'permission:Penjualan']);
    $routes->get('sales-repeat_penawaran/(:any)', 'Sales\Penawaran::repeatPenawaran/$1', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-save_repeat_penawaran', 'Sales\Penawaran::saveRepeat', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-alasan_hapus_penawaran', 'Sales\Penawaran::alasanHapusPenawaran', ['filter' => 'permission:Penjualan']);
    // Penawaran Detail
    $routes->get('sales-get_produk_add_list/(:any)', 'Sales\Penawaran_detail::getProdukForAddList/$1', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-find_produk_by_nama_sku', 'Sales\Penawaran_detail::findProdukByNamaSKU', ['filter' => 'permission:Penjualan']);
    $routes->get('sales-list_penawaran/(:any)', 'Sales\Penawaran_detail::List_penawaran/$1', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-ganti_no_penawaran', 'Sales\Penawaran_detail::gantiNoPenawaran', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-simpan_penawaran', 'Sales\Penawaran_detail::simpanPenawaran', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-kirim_penawaran', 'Sales\Penawaran_detail::kirimPenawaran', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-produks_penawaran', 'Sales\Penawaran_detail::getListProdukPenawaran', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-check_list_produk', 'Sales\Penawaran_detail::checkListProduk', ['filter' => 'permission:Penjualan']);
    $routes->resource('sales-penawaran_detail', ['controller' => 'Sales\Penawaran_detail', 'filter' => 'permission:Penjualan']);

    // Fixing Penawaran
    $routes->get('sales-fixing_penawaran', 'Sales\Penawaran_fixing::index', ['filter' => 'permission:Penjualan']);
    $routes->get('sales-get_penawaran_ordered', 'Sales\Penawaran_fixing::getDataPenawaranOrdered', ['filter' => 'permission:Penjualan']);
    // Fixing Penawaran Detail
    $routes->get('sales-list_fixing/(:any)', 'Sales\Penawaran_detail_fixing::ListFixing/$1', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-get_list_alamat_customer', 'Sales\Penawaran_detail_fixing::getListAlamatCustomer', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-get_alamat_customer', 'Sales\Penawaran_detail_fixing::getAlamatCustomer', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-produks_penjualan', 'Sales\Penawaran_detail_fixing::getListProdukPenjualan', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-ganti_no_penjualan', 'Sales\Penawaran_detail_fixing::gantiNoPenjualan', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-fixing_produk_create', 'Sales\Penawaran_detail_fixing::create', ['filter' => 'permission:Penjualan']);
    $routes->put('sales-fixing_produk_update/(:any)', 'Sales\Penawaran_detail_fixing::update/$1', ['filter' => 'permission:Penjualan']);
    $routes->delete('sales-fixing_produk_delete/(:any)', 'Sales\Penawaran_detail_fixing::delete/$1', ['filter' => 'permission:Penjualan']);

    // Penjualan
    $routes->resource('sales-penjualan', ['controller' => 'Sales\Penjualan', 'filter' => 'permission:Penjualan']);
    $routes->get('sales-get_data_penjualan', 'Sales\Penjualan::getDataPenjualan', ['filter' => 'permission:Penjualan']);
    $routes->get('sales-show_data_penjualan/(:any)', 'Sales\Penjualan::show/$1', ['filter' => 'permission:Penjualan']);
    $routes->get('sales-show_tagihan_penjualan/(:any)', 'Sales\Penjualan::showTagihan/$1', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-tambah_tagihan', 'Sales\Penjualan::tambahTagihan', ['filter' => 'permission:Penjualan']);
    $routes->get('sales-show_rincian_tagihan/(:any)', 'Sales\Penjualan::showRincianTagihan/$1', ['filter' => 'permission:Penjualan']);
    $routes->get('sales-show_pembayaran_tagihan/(:any)', 'Sales\Penjualan::showPembayaranTagihan/$1', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-check_produk_penjualan', 'Sales\Penjualan::checkProdukPenjualan', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-simpan_penjualan', 'Sales\Penjualan::simpanPenjualan', ['filter' => 'permission:Penjualan']);
    $routes->post('sales-buat_penjualan', 'Sales\Penjualan::buatPenjualan', ['filter' => 'permission:Penjualan']);









    // ------------------------------------------------------------------------------------------------------------------ WAREHOUSE ----
    // ------------------------------------------------------------------------------------------------------------------ WAREHOUSE ----

    $routes->get('warehouse-ruangan-rak/(:any)', 'Warehouse\Menu::RuanganRak/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-inbound/(:any)', 'Warehouse\Menu::inbound/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-outbound/(:any)', 'Warehouse\Menu::outbound/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-ruangan/(:any)', 'Warehouse\Ruangan::ruangan/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-produkruangan/(:any)', 'Warehouse\LokasiProduk::indexRuangan/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-rak/(:any)', 'Warehouse\Rak::rak/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-produkrak/(:any)', 'Warehouse\LokasiProduk::indexRak/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-stockopname/(:any)', 'Warehouse\StockOpname::opname/$1', ['filter' => 'permission:Gudang']);



    // Produk
    $routes->get('warehouse-produk/(:any)', 'Warehouse\Produk::produk/$1', ['filter' => 'permission:Data Master,Penanggung Jawab Gudang'], ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-getdataproduk/(:any)', 'Warehouse\Produk::getDataProduk/$1', ['filter' => 'permission:Data Master,Penanggung Jawab Gudang'], ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-produk_detail/(:any)', 'Warehouse\Produk::show/$1', ['filter' => 'permission:Data Master,Penanggung Jawab Gudang'], ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-produkplan', 'Warehouse\ProdukPlan::create', ['filter' => 'permission:Data Master,Penanggung Jawab Gudang'], ['filter' => 'permission:Gudang']);


    // Ruangan
    $routes->resource('warehouse-master_ruangan', ['controller' => 'Warehouse\Ruangan', 'filter' => 'permission:Gudang']);
    $routes->get('warehouse-getdataruangan', 'Warehouse\Ruangan::getDataRuangan', ['filter' => 'permission:Gudang']);


    // Rak
    $routes->resource('warehouse-master_rak', ['controller' => 'Warehouse\Rak', 'filter' => 'permission:Gudang']);
    $routes->get('warehouse-getdatarak', 'Warehouse\Rak::getDataRak', ['filter' => 'permission:Gudang']);


    // Lokasi Produk
    $routes->get('warehouse-getdataruanganproduk/(:any)', 'Warehouse\LokasiProduk::getDataRuanganProduk/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-getdatarakproduk/(:any)', 'Warehouse\LokasiProduk::getDataRakProduk/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-lokasiproduk/new/(:any)', 'Warehouse\LokasiProduk::new_produk/$1', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-lokasiproduk/(:any)', 'Warehouse\LokasiProduk::create_produk/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-lokasiproduk/rak_byruangan', 'Warehouse\LokasiProduk::RakbyRuangan', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-lokasiproduk/stok_byidproduk', 'Warehouse\LokasiProduk::StokbyProduk', ['filter' => 'permission:Gudang']);


    // Stock Opname
    $routes->get('warehouse-master_stockopname/new', 'Warehouse\StockOpname::new', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-master_stockopname/', 'Warehouse\StockOpname::create', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-getdatastok', 'Warehouse\StockOpname::getDataStok', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-detailstock/(:num)', 'Warehouse\StockOpname::show/$1', ['filter' => 'permission:Gudang']);


    // Stock Opname Detail
    $routes->get('warehouse-list_stok/(:any)', 'Warehouse\StockOpnameDetail::ListProdukStockOpname/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-stokbyproduk', 'Warehouse\StockOpnameDetail::StokbyProduk', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-addproduklistStockopname/', 'Warehouse\StockOpnameDetail::create', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-list_stok_produk', 'Warehouse\StockOpnameDetail::getListProdukStock', ['filter' => 'permission:Gudang']);
    $routes->delete('warehouse-stok_produk_delete/(:any)', 'Warehouse\StockOpnameDetail::delete/$1', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-stok_produk_update/(:any)', 'Warehouse\StockOpnameDetail::update/$1', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-check_list_produk', 'Warehouse\StockOpnameDetail::checkListProduk', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-simpanstok', 'Warehouse\StockOpnameDetail::updateStatusStock', ['filter' => 'permission:Gudang']);


    // Inbound Pembelian
    $routes->get('warehouse-inboundPembelian', 'Warehouse\InboundPembelian::index', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-getDataPembelian', 'Warehouse\InboundPembelian::getDataPembelian', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-get_list_inbound_pembelian/(:any)', 'Warehouse\InboundPembelian::listInboundPembelian/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-show_detail_inbound/(:any)', 'Warehouse\InboundPembelian::showDetailInbound/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-do_inbound_pembelian/(:any)', 'Warehouse\InboundPembelian::create_inbound_pembelian/$1', ['filter' => 'permission:Gudang']);

    $routes->get('warehouse-detail_inbound_pembelian/(:any)', 'Warehouse\InboundPembelianDetail::listProdukInbPembelian/$1', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-update_detail_inbpembelian/(:any)', 'Warehouse\InboundPembelianDetail::update/$1', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-validasi_simpan_inbound_pembelian', 'Warehouse\InboundPembelianDetail::validasiSave', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-simpan_inbound/(:any)', 'Warehouse\InboundPembelianDetail::saveInbound/$1', ['filter' => 'permission:Gudang']);


    // Outbound Penjualan
    $routes->get('warehouse-outboundPenjualan', 'Warehouse\OutboundPenjualan::index', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-getDataPenjualan', 'Warehouse\OutboundPenjualan::getDataPenjualan', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-get_list_outbound_penjualan/(:any)', 'Warehouse\OutboundPenjualan::listOutboundPenjualan/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-show_detail_outbound/(:any)', 'Warehouse\OutboundPenjualan::showDetailOutbound/$1', ['filter' => 'permission:Gudang']);
    $routes->get('warehouse-do_outbound_penjualan/(:any)', 'Warehouse\OutboundPenjualan::create_outbound_penjualan/$1', ['filter' => 'permission:Gudang']);

    $routes->get('warehouse-detail_outbound_penjualan/(:any)', 'Warehouse\OutboundPenjualanDetail::listProdukOutPenjualan/$1', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-update_detail_outpenjualan/(:any)', 'Warehouse\OutboundPenjualanDetail::update/$1', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-validasi_simpan_outbound_penjualan', 'Warehouse\OutboundPenjualanDetail::validasiSave', ['filter' => 'permission:Gudang']);
    $routes->post('warehouse-simpan_outbound/(:any)', 'Warehouse\OutboundPenjualanDetail::saveOutbound/$1', ['filter' => 'permission:Gudang']);
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
