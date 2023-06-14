<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Fix List Produk Penjualan</h3>
        </div>
        <div class="me-2">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>sales-fixing_penawaran">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header text-light" style="background-color: #3A98B9;">
                    List Produk
                </div>
                <div class="card-body" style="background-color: #E6ECF0;">

                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <select class="form-select" id="id_produk">
                                <option id="id_produk_default" value=""></option>
                                <?php foreach ($produk as $pr) : ?>
                                    <option value="<?= $pr['id'] ?>"><?= $pr['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <input autocomplete="off" type="text" class="form-control" placeholder="Qty" id="qty">
                            <button class="btn btn-secondary px-2" type="button" id="tambah_produk"><i class="fa-fw fa-solid fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                            <thead>
                                <tr>
                                    <th class="text-center" width="3%">#</th>
                                    <th class="text-center" width="10%">SKU</th>
                                    <th class="text-center" width="30%">Produk</th>
                                    <th class="text-center" width="11%">Satuan</th>
                                    <th class="text-center" width="5%">Qty</th>
                                    <th class="text-center" width="11%">Add Cost</th>
                                    <th class="text-center" width="11%">Diskon</th>
                                    <th class="text-center" width="11%">Total</th>
                                    <th class="text-center" width="8%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel_list_produk">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="container mb-5">
            <form id="form_penjualan" autocomplete="off" action="<?= site_url() ?>sales-buat_penjualan" method="post">
                <div class="row mt-4">

                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header text-light" style="background-color: #3A98B9;">
                                Detail Penjualan
                            </div>
                            <div class="card-body" style="background-color: #E6ECF0;">

                                <div class="mb-2">Nomor Penawaran : <b><?= $penjualan['no_penawaran'] ?></b></div>
                                <div class="mb-2" id="text_no_penjualan">Nomor Penjualan : <b><?= $penjualan['no_penjualan'] ?></b></div>
                                <div class="mb-2">Admin : <b><?= user()->name ?></b></div>

                                <hr>

                                <?= csrf_field() ?>

                                <input type="hidden" name="id_penjualan" value="<?= $penjualan['id'] ?>">
                                <input type="hidden" name="id_admin" value="<?= user()->id ?>">
                                <input type="hidden" id="no_penjualan" name="no_penjualan" value="<?= $penjualan['no_penjualan'] ?>">
                                <input type="hidden" id="grand_total" name="grand_total" value="<?= number_format(($penjualan['total_harga_produk'] + $penjualan['ongkir']) - $penjualan['diskon'], 0, ',', '.') ?>">

                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal Penjualan</label>
                                    <input onchange="ganti_no_penjualan()" type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $penjualan['tanggal'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="customer" class="form-label">Customer</label>
                                    <select class="form-select" id="customer" name="customer" onchange="change_customer()">
                                        <?php foreach ($customer as $sup) : ?>
                                            <option <?= ($sup['id'] == $penjualan['id_customer']) ? 'selected' : '' ?> value="<?= $sup['id'] ?>"><?= $sup['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <input type="hidden" name="id_customer" id="id_customer">
                                </div>

                                <div class="mb-2">
                                    <label for="alamat_customer" class="form-label">Alamat Kirim</label>
                                    <select onchange="change_alamat_customer()" class="form-select" id="alamat_customer" name="alamat_customer">
                                        <?php foreach ($alamat_customer as $al_cust) : ?>
                                            <option <?= ($al_cust['nama'] == $penjualan['nama_alamat'] && $al_cust['id_customer'] == $penjualan['id_customer']) ? 'selected' : '' ?> value="<?= $al_cust['id'] ?>"><?= $al_cust['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <input type="hidden" name="nama_alamat" id="nama_alamat">
                                    <input type="hidden" name="id_provinsi" id="id_provinsi">
                                    <input type="hidden" name="id_kota" id="id_kota">
                                    <input type="hidden" name="id_kecamatan" id="id_kecamatan">
                                    <input type="hidden" name="id_kelurahan" id="id_kelurahan">
                                    <input type="hidden" name="detail_alamat" id="detail_alamat">
                                    <input type="hidden" name="penerima" id="penerima">
                                    <input type="hidden" name="no_telp" id="no_telp">
                                </div>

                                <div class="mb-2 ms-1">
                                    <p class="mb-0" id="text-nama_alamat"></p>
                                    <p class="mb-0" id="text-alamat"></p>
                                    <p class="mb-0" id="text-penerima"></p>
                                    <p class="mb-0" id="text-telp"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header text-light" style="background-color: #3A98B9;">
                                Biaya
                            </div>
                            <div class="card-body" style="background-color: #E6ECF0;">

                                <div class="mb-3">
                                    <label for="total_harga_produk" class="form-label">Total Harga Produk</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp. </span>
                                        <input readonly type="text" class="form-control triger-hitung-total" id="total_harga_produk" name="total_harga_produk" value="<?= number_format($penjualan['total_harga_produk'], 0, ',', '.') ?>">
                                    </div>
                                </div>

                                <!-- <div class="mb-3">
                                    <label for="jasa_kirim" class="form-label">Jasa Kirim</label>
                                    <input type="text" class="form-control" id="jasa_kirim" name="jasa_kirim" value="<?= $penjualan['jasa_kirim'] ?>">
                                </div> -->

                                <!-- <div class="mb-3">
                                    <label for="ongkir" class="form-label">Ongkir</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp. </span>
                                        <input type="text" class="form-control triger-hitung-total" id="ongkir" name="ongkir" value="<?= number_format($penjualan['ongkir'], 0, ',', '.') ?>">
                                    </div>
                                </div> -->

                                <div class="mb-3">
                                    <label for="kode_promo" class="form-label">Kode Promo</label>
                                    <input type="text" class="form-control" id="kode_promo" name="kode_promo" value="<?= $penjualan['kode_promo'] ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="diskon" class="form-label">Diskon</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp. </span>
                                        <input type="text" class="form-control triger-hitung-total" id="diskon" name="diskon" value="<?= number_format($penjualan['diskon'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header text-light" style="background-color: #3A98B9;">
                                Simpan dan Buat
                            </div>
                            <div class="card-body" style="background-color: #E6ECF0;">
                                <div class="mb-4">
                                    <h4>Grand Total :</h4>
                                    <h1 id="text_grand_total">Rp. <?= number_format(($penjualan['total_harga_produk'] + $penjualan['ongkir']) - $penjualan['diskon'], 0, ',', '.') ?></h1>
                                </div>

                                <div class="mb-4">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Catatan penjualan ..." id="catatan" name="catatan" style="height: 100px"><?= $penjualan['catatan'] ?></textarea>
                                        <label for="catatan">Catatan Penjualan</label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-success" id="simpan_penjualan">Simpan Penjualan <i class="fa-solid fa-floppy-disk"></i></button>
                                </div>
                                <br>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-danger" id="buat_penjualan">Buat Penjualan <i class="fa-solid fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>


</main>


<!-- Modal -->
<div class="modal fade" id="my-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal">Edit Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiModal">
                <input type="hidden" id="id_list_produk">

                <div class="mb-3">
                    <label for="new_qty" class="form-label">Qty</label>
                    <input id="new_qty" type="number" min="1" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="new_biaya_tambahan" class="form-label">Tambahan Biaya</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp. </span>
                        <input id="new_biaya_tambahan" type="text" class="form-control biaya_tambahan input-edit-produk">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="new_diskon" class="form-label">Diskon</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp. </span>
                        <input id="new_diskon" type="text" class="form-control diskon input-edit-produk">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="new_catatan" class="form-label">Catatan</label>
                    <input id="new_catatan" type="text" class="form-control">
                </div>


                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-primary" id="btn-update_list_produk">Simpan <i class="fa-solid fa-check"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<?= $this->include('MyLayout/js') ?>

<script>
    var alert_stok_kurang = false;


    $(document).ready(function() {
        $("#id_produk").select2({
            theme: "bootstrap-5",
            placeholder: 'Cari Produk',
            initSelection: function(element, callback) {}
        });

        $("#customer").select2({
            theme: "bootstrap-5",
        });

        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });

        $('#ongkir').mask('000.000.000.000', {
            reverse: true
        });

        $('#diskon').mask('000.000.000.000', {
            reverse: true
        });

        // Alert
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }

        load_list();
        change_alamat_customer();
    })


    function change_customer() {
        let customer = $('#customer').val();
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-get_list_alamat_customer",
            data: 'customer=' + customer,
            dataType: "json",
            success: function(response) {
                if (response.result == 'ada') {
                    $('#alamat_customer').html(response.list_alamat_customer);

                    $('#text-nama_alamat').html(response.first_alamat_customer.nama)
                    $('#text-alamat').html(response.first_alamat_customer.detail_alamat + ', ' + response.first_alamat_customer.kelurahan + ', ' + response.first_alamat_customer.kecamatan + ', ' + response.first_alamat_customer.kota + ', ' + response.first_alamat_customer.provinsi)
                    $('#text-penerima').html('Penerima : ' + response.first_alamat_customer.penerima)
                    $('#text-telp').html('Telp : ' + response.first_alamat_customer.no_telp)

                    $('#nama_alamat').val(response.first_alamat_customer.nama)
                    $('#id_provinsi').val(response.first_alamat_customer.id_provinsi)
                    $('#id_kota').val(response.first_alamat_customer.id_kota)
                    $('#id_kecamatan').val(response.first_alamat_customer.id_kecamatan)
                    $('#id_kelurahan').val(response.first_alamat_customer.id_kelurahan)
                    $('#detail_alamat').val(response.first_alamat_customer.detail_alamat)
                    $('#penerima').val(response.first_alamat_customer.penerima)
                    $('#no_telp').val(response.first_alamat_customer.no_telp)
                } else {
                    $('#alamat_customer').html('<option value="">Customer Belum memiliki alamat.</option>');

                    $('#text-nama_alamat').html('')
                    $('#text-alamat').html('')
                    $('#text-penerima').html('')
                    $('#text-telp').html('')

                    $('#nama_alamat').val('')
                    $('#id_provinsi').val('')
                    $('#id_kota').val('')
                    $('#id_kecamatan').val('')
                    $('#id_kelurahan').val('')
                    $('#detail_alamat').val('')
                    $('#penerima').val('')
                    $('#no_telp').val('')
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }

    function change_alamat_customer() {
        var id_alamat_customer = $('#alamat_customer').val();
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-get_alamat_customer",
            data: 'id_alamat_customer=' + id_alamat_customer,
            dataType: "json",
            success: function(response) {
                $('#text-nama_alamat').html(response.alamat_joined.nama)
                $('#text-alamat').html(response.alamat_joined.detail_alamat + ', ' + response.alamat_joined.kelurahan + ', ' + response.alamat_joined.kecamatan + ', ' + response.alamat_joined.kota + ', ' + response.alamat_joined.provinsi)
                $('#text-penerima').html('Penerima : ' + response.alamat_joined.penerima)
                $('#text-telp').html('Telp : ' + response.alamat_joined.no_telp)

                $('#nama_alamat').val(response.alamat_customer.nama)
                $('#id_provinsi').val(response.alamat_customer.id_provinsi)
                $('#id_kota').val(response.alamat_customer.id_kota)
                $('#id_kecamatan').val(response.alamat_customer.id_kecamatan)
                $('#id_kelurahan').val(response.alamat_customer.id_kelurahan)
                $('#detail_alamat').val(response.alamat_customer.detail_alamat)
                $('#penerima').val(response.alamat_customer.penerima)
                $('#no_telp').val(response.alamat_customer.no_telp)
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }


    function ganti_no_penjualan() {
        let tanggal = $('#tanggal').val()
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-ganti_no_penjualan",
            data: 'tanggal=' + tanggal,
            dataType: "json",
            success: function(response) {
                if (response.no_penjualan) {
                    $('#text_no_penjualan').html('Nomor Penjualan : <b>' + response.no_penjualan + '</b>');
                    $('#no_penjualan').val(response.no_penjualan)
                } else {
                    Swal.fire(
                        'Opss.',
                        'Terjadi kesalahan, hubungi IT Support',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }


    function load_list() {
        let id_penjualan = '<?= $penjualan['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-produks_penjualan",
            data: 'id_penjualan=' + id_penjualan,
            dataType: "json",
            success: function(response) {
                $('#tabel_list_produk').html(response.list)
                alert_stok_kurang = response.ada_stok_kurang
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }


    $('#tambah_produk').click(function() {
        let id_produk = $('#id_produk').val();
        let qty = $('#qty').val();
        let id_penjualan = '<?= $penjualan['id'] ?>'

        if (id_produk != '' && qty != '') {
            $.ajax({
                type: "post",
                url: "<?= site_url() ?>sales-fixing_produk_create",
                data: 'id_penjualan=' + id_penjualan +
                    '&id_produk=' + id_produk +
                    '&qty=' + qty,
                dataType: "json",
                success: function(response) {
                    if (response.notif) {
                        Toast.fire({
                            icon: 'success',
                            title: response.notif
                        })
                        load_list();
                        $('#qty').val('');
                        $('#id_produk').val('').trigger('change');
                        update_grand_total(response.total_harga_produk);
                    } else {
                        alert('terjadi error tambah list produk')
                    }
                },
                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });
        } else {
            Swal.fire(
                'Ops.',
                'Pilih Produk dan Qty dulu.',
                'error'
            )
        }
    })


    $('.input-edit-produk').on('change', function() {
        if ($(this).val() == '') {
            $(this).val('0');
        }
    })

    function update_produk(id) {
        $.ajax({
            url: "<?= site_url() ?>sales-fixing_produk_update/" + id,
            type: 'PUT',
            data: JSON.stringify({
                id_penjualan: '<?= $penjualan['id'] ?>',
                new_qty: $('#new_qty').val(),
                new_biaya_tambahan: $('#new_biaya_tambahan').val(),
                new_diskon: $('#new_diskon').val(),
                new_catatan: $('#new_catatan').val()
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil update list produk penjualan'
                    })
                    load_list();
                    update_grand_total(response.total_harga_produk);
                    $('#my-modal').modal('hide');
                } else {
                    alert('terjadi error update list produk')
                    console.log(response)
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                alert('Error: ' + errorThrown);
            }
        });
    }


    function update_grand_total(total_harga_produk) {
        let formated_total_harga_produk = format_rupiah(total_harga_produk);
        let new_total_harga_produk = formated_total_harga_produk.trim().replace('Rp', '');
        $('#total_harga_produk').val(new_total_harga_produk.trim());
        hitung_grand_total()
    }

    $('#diskon').on('input', function() {
        if (parseInt($(this).val().replaceAll('.', ''), 10) >= $('#grand_total').val()) {
            Swal.fire(
                'Opss.',
                'Kalau diskon lebih besar dari total penjualan, ya rugi dong.',
                'error'
            )
            $(this).val(0);
        }
    })

    $('.triger-hitung-total').on('input', function() {
        hitung_grand_total()
    })

    $('.triger-hitung-total').on('change', function() {
        if ($(this).val() == '') {
            $(this).val('0');
        }
        hitung_grand_total()
    })

    function hitung_grand_total() {
        let total_harga_produk = $('#total_harga_produk').val()
        let ongkir = $('#ongkir').val()
        let diskon = $('#diskon').val()

        let grand_total = (parseInt(total_harga_produk.replace(/\./g, '')) + parseInt(ongkir.replace(/\./g, ''))) - parseInt(diskon.replace(/\./g, ''));

        $('#grand_total').val(grand_total)
        $('#text_grand_total').html(format_rupiah(grand_total))
    }


    $('#simpan_penjualan').click(function() {
        if ($('#tanggal').val() == '') {
            $('#tanggal').removeClass('is-valid');
            $('#tanggal').addClass('is-invalid');
        } else {
            $('#tanggal').addClass('is-valid');
            $('#tanggal').removeClass('is-invalid');
        }
        if ($('#jasa_kirim').val() == '') {
            $('#jasa_kirim').removeClass('is-valid');
            $('#jasa_kirim').addClass('is-invalid');
        } else {
            $('#jasa_kirim').addClass('is-valid');
            $('#jasa_kirim').removeClass('is-invalid');
        }

        if (alert_stok_kurang) {
            Swal.fire(
                'Opss.',
                'Ada stok produk yang jumlahnya kurang, coba dicek.',
                'error'
            )
        } else {
            if ($('#tanggal').val() != '' && $('#jasa_kirim').val() != '') {
                simpan_penjualan();
            }
        }
    })


    function simpan_penjualan() {
        let id_penjualan = '<?= $penjualan['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-simpan_penjualan",
            data: 'id_penjualan=' + id_penjualan +
                '&no_penjualan=' + $('#no_penjualan').val() +
                '&tanggal=' + $('#tanggal').val() +
                '&id_customer=' + $('#customer').val() +
                '&total_harga_produk=' + $('#total_harga_produk').val() +
                '&ongkir=' + $('#ongkir').val() +
                '&jasa_kirim=' + $('#jasa_kirim').val() +
                '&diskon=' + $('#diskon').val() +
                '&kode_promo=' + $('#kode_promo').val() +
                '&grand_total=' + $('#grand_total').val() +
                '&nama_alamat=' + $('#nama_alamat').val() +
                '&id_provinsi=' + $('#id_provinsi').val() +
                '&id_kota=' + $('#id_kota').val() +
                '&id_kecamatan=' + $('#id_kecamatan').val() +
                '&id_kelurahan=' + $('#id_kelurahan').val() +
                '&detail_alamat=' + $('#detail_alamat').val() +
                '&penerima=' + $('#penerima').val() +
                '&no_telp=' + $('#no_telp').val() +
                '&catatan=' + $('#catatan').val(),
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    <?php session()->setFlashdata('pesan', 'Berhasil menyimpan fixing penjualan.'); ?>
                    location.href = '<?= site_url("sales-fixing_penawaran?pesan=" . urlencode(session('pesan'))) ?>';
                } else {
                    Swal.fire(
                        'Opss.',
                        'Terjadi kesalahan, hubungi IT Support',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }


    $('#buat_penjualan').click(function() {
        if ($('#tanggal').val() == '') {
            $('#tanggal').removeClass('is-valid');
            $('#tanggal').addClass('is-invalid');
        } else {
            $('#tanggal').addClass('is-valid');
            $('#tanggal').removeClass('is-invalid');
        }
        if ($('#jasa_kirim').val() == '') {
            $('#jasa_kirim').removeClass('is-valid');
            $('#jasa_kirim').addClass('is-invalid');
        } else {
            $('#jasa_kirim').addClass('is-valid');
            $('#jasa_kirim').removeClass('is-invalid');
        }

        if (alert_stok_kurang) {
            Swal.fire(
                'Opss.',
                'Ada stok produk yang jumlahnya kurang, coba dicek.',
                'error'
            )
        } else {
            if ($('#tanggal').val() != '' && $('#jasa_kirim').val() != '') {
                buat_penjualan();
            }
        }
    })


    function buat_penjualan() {
        let id_penjualan = '<?= $penjualan['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-check_produk_penjualan",
            data: 'id_penjualan=' + id_penjualan,
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    Swal.fire({
                        title: 'Konfirmasi?',
                        text: "Apakah yakin buat penjualan?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lanjut!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form_penjualan').submit();
                        }
                    })
                } else {
                    Swal.fire(
                        'Opss.',
                        'Tidak ada produk dalam penjualan. pilih minimal satu produk dulu!',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }
</script>

<?= $this->endSection() ?>