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
            <h3 style="color: #566573;">Fix List Produk Pemesanan</h3>
        </div>
        <div class="me-2">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>purchase-fixing_pemesanan">
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
                                    <th class="text-center" width="5%">#</th>
                                    <th class="text-center" width="10%">SKU</th>
                                    <th class="text-center" width="30%">Produk</th>
                                    <th class="text-center" width="20%">Satuan</th>
                                    <th class="text-center" width="10%">Qty</th>
                                    <th class="text-center" width="15%">Total</th>
                                    <th class="text-center" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel_list_produk">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>


        <div class="container">
            <form id="form_pembelian" autocomplete="off" action="<?= site_url() ?>purchase-buat_pembelian" method="post">
                <div class="row mt-4">

                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header text-light" style="background-color: #3A98B9;">
                                Detail Pemesanan
                            </div>
                            <div class="card-body" style="background-color: #E6ECF0;">

                                <div class="mb-2" id="text_no_pemesanan">Nomor Pemesanan : <b><?= $pemesananFixing['no_pemesanan'] ?></b></div>
                                <div class="mb-2">Admin : <b><?= user()->name ?></b></div>

                                <hr>

                                <?= csrf_field() ?>

                                <input type="hidden" name="id_pemesanan_fixing" value="<?= $pemesananFixing['id'] ?>">
                                <input type="hidden" id="no_pemesanan" name="no_pemesanan" value="<?= $pemesananFixing['no_pemesanan'] ?>">
                                <input type="hidden" id="id_user" name="id_user" value="<?= user()->id ?>">
                                <input type="hidden" id="grand_total" name="grand_total" value="<?= $pemesananFixing['exw'] + $pemesananFixing['hf'] + $pemesananFixing['ppn_hf'] + $pemesananFixing['ongkir_port'] + $pemesananFixing['ongkir_laut_udara'] + $pemesananFixing['ongkir_transit'] + $pemesananFixing['ongkir_gudang'] + $pemesananFixing['bm'] + $pemesananFixing['ppn'] + $pemesananFixing['pph'] ?>">

                                <div class="mb-3">
                                    <label for="invoice" class="form-label">Invoice Supplier</label>
                                    <input type="text" class="form-control" id="invoice" name="invoice" value="<?= $pemesananFixing['invoice'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal Pemesanan</label>
                                    <input onchange="ganti_no_pemesanan()" type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $pemesananFixing['tanggal'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="gudang" class="form-label">Diterima Gudang</label>
                                    <select class="form-select" id="gudang" name="gudang">
                                        <option value=""></option>
                                        <?php foreach ($gudang as $gud) : ?>
                                            <option <?= ($gud['id'] == $pemesananFixing['id_gudang']) ? 'selected' : '' ?> value="<?= $gud['id'] ?>"><?= $gud['nama'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="row g-2">
                                        <div class="col-sm-4">
                                            <p class="mb-1">Panjang</p>
                                            <div class="input-group mb-3">
                                                <input type="number" min="1" value="<?= $pemesananFixing['panjang'] ?>" class="form-control" id="panjang" name="panjang">
                                                <span class="input-group-text px-2">m</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="mb-1">Lebar</p>
                                            <div class="input-group mb-3">
                                                <input type="number" min="1" value="<?= $pemesananFixing['lebar'] ?>" class="form-control" id="lebar" name="lebar">
                                                <span class="input-group-text px-2">m</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="mb-1">Tinggi</p>
                                            <div class="input-group mb-3">
                                                <input type="number" min="1" value="<?= $pemesananFixing['tinggi'] ?>" class="form-control" id="tinggi" name="tinggi">
                                                <span class="input-group-text px-2">m</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Berat</label>
                                    <div class="input-group mb-3">
                                        <input type="number" min="1" value="<?= $pemesananFixing['berat'] ?>" class="form-control" id="berat" name="berat">
                                        <span class="input-group-text px-2">kg</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Carton / Koli</label>
                                    <input type="number" min="1" value="<?= $pemesananFixing['carton_koli'] ?>" class="form-control" id="carton_koli" name="carton_koli">
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
                                    <label for="exw" class="form-label">EXW</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input readonly type="text" class="form-control triger-hitung-total" id="exw" name="exw" value="<?= number_format($pemesananFixing['exw'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="hf" class="form-label">HF</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input type="text" class="form-control triger-hitung-total" id="hf" name="hf" value="<?= number_format($pemesananFixing['hf'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="ppn_hf" class="form-label">PPN HF</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input type="text" class="form-control triger-hitung-total" id="ppn_hf" name="ppn_hf" value="<?= number_format($pemesananFixing['ppn_hf'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="ongkir_port" class="form-label">Ongkir Port</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input type="text" class="form-control triger-hitung-total" id="ongkir_port" name="ongkir_port" value="<?= number_format($pemesananFixing['ongkir_port'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="ongkir_laut_udara" class="form-label">Ongkir Laut / Udara</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input type="text" class="form-control triger-hitung-total" id="ongkir_laut_udara" name="ongkir_laut_udara" value="<?= number_format($pemesananFixing['ongkir_laut_udara'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="ongkir_transit" class="form-label">Ongkir Transit</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input type="text" class="form-control triger-hitung-total" id="ongkir_transit" name="ongkir_transit" value="<?= number_format($pemesananFixing['ongkir_transit'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="ongkir_gudang" class="form-label">Ongkir Gudang</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input type="text" class="form-control triger-hitung-total" id="ongkir_gudang" name="ongkir_gudang" value="<?= number_format($pemesananFixing['ongkir_gudang'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="bm" class="form-label">BM</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input type="text" class="form-control triger-hitung-total" id="bm" name="bm" value="<?= number_format($pemesananFixing['bm'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="ppn" class="form-label">PPN</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input type="text" class="form-control triger-hitung-total" id="ppn" name="ppn" value="<?= number_format($pemesananFixing['ppn'], 0, ',', '.') ?>">
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="pph" class="form-label">PPh</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text px-2">Rp</span>
                                        <input type="text" class="form-control triger-hitung-total" id="pph" name="pph" value="<?= number_format($pemesananFixing['pph'], 0, ',', '.') ?>">
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
                                    <h1 id="text_grand_total">Rp. <?= number_format($pemesananFixing['exw'] + $pemesananFixing['hf'] + $pemesananFixing['ppn_hf'] + $pemesananFixing['ongkir_port'] + $pemesananFixing['ongkir_laut_udara'] + $pemesananFixing['ongkir_transit'] + $pemesananFixing['ongkir_gudang'] + $pemesananFixing['bm'] + $pemesananFixing['ppn'] + $pemesananFixing['pph'], 0, ',', '.') ?></h1>
                                </div>

                                <div class="mb-4">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Catatan pembelian ..." id="catatan" name="catatan" style="height: 100px"><?= $pemesananFixing['catatan'] ?></textarea>
                                        <label for="catatan">Catatan Pembelian</label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-success" id="simpan_pemesanan_fixing">Simpan <i class="fa-solid fa-floppy-disk"></i></button>
                                </div>
                                <br>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-danger" id="buat_pembelian">Buat Pembelian <i class="fa-solid fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>


</main>


<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $("#id_produk").select2({
            theme: "bootstrap-5",
            placeholder: 'Cari Produk',
            initSelection: function(element, callback) {}
        });

        $("#supplier").select2({
            theme: "bootstrap-5",
        });
        $("#gudang").select2({
            theme: "bootstrap-5",
        });

        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });

        $('#exw').mask('000.000.000.000', {
            reverse: true
        });
        $('#hf').mask('000.000.000.000', {
            reverse: true
        });
        $('#ppn_hf').mask('000.000.000.000', {
            reverse: true
        });
        $('#ongkir_port').mask('000.000.000.000', {
            reverse: true
        });
        $('#ongkir_laut_udara').mask('000.000.000.000', {
            reverse: true
        });
        $('#ongkir_transit').mask('000.000.000.000', {
            reverse: true
        });
        $('#ongkir_gudang').mask('000.000.000.000', {
            reverse: true
        });
        $('#bm').mask('000.000.000.000', {
            reverse: true
        });
        $('#ppn').mask('000.000.000.000', {
            reverse: true
        });
        $('#pph').mask('000.000.000.000', {
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
    })


    function ganti_no_pemesanan() {
        let tanggal = $('#tanggal').val()
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>purchase-ganti_no_pemesanan",
            data: 'tanggal=' + tanggal,
            dataType: "json",
            success: function(response) {
                if (response.no_pemesanan) {
                    $('#text_no_pemesanan').html('Nomor Pemesanan : <b>' + response.no_pemesanan + '</b>');
                    $('#no_pemesanan').val(response.no_pemesanan)
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
        let id_pemesanan_fixing = '<?= $pemesananFixing['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>purchase-produks_pemesanan_fixing",
            data: 'id_pemesanan_fixing=' + id_pemesanan_fixing,
            dataType: "json",
            success: function(response) {
                $('#tabel_list_produk').html(response.list)
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }


    function update_exw(exw) {
        let formated_exw = format_rupiah(exw);
        let new_exw = formated_exw.trim().replace('Rp', '');
        $('#exw').val(new_exw.trim());
        hitung_grand_total()
    }


    $('#tambah_produk').click(function() {
        let id_produk = $('#id_produk').val();
        let qty = $('#qty').val();
        let id_pemesanan_fixing = '<?= $pemesananFixing['id'] ?>'

        if (id_produk != '' && qty != '') {
            $.ajax({
                type: "post",
                url: "<?= site_url() ?>purchase-fixing_produk_create",
                data: 'id_pemesanan_fixing=' + id_pemesanan_fixing +
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
                        update_exw(response.exw);
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
        let exw = $('#exw').val()
        let hf = $('#hf').val()
        let ppn_hf = $('#ppn_hf').val()
        let ongkir_port = $('#ongkir_port').val()
        let ongkir_laut_udara = $('#ongkir_laut_udara').val()
        let ongkir_transit = $('#ongkir_transit').val()
        let ongkir_gudang = $('#ongkir_gudang').val()
        let bm = $('#bm').val()
        let ppn = $('#ppn').val()
        let pph = $('#pph').val();

        let grand_total = parseInt(exw.replace(/\./g, '')) + parseInt(hf.replace(/\./g, '')) + parseInt(ppn_hf.replace(/\./g, '')) + parseInt(ongkir_port.replace(/\./g, '')) + parseInt(ongkir_laut_udara.replace(/\./g, '')) + parseInt(ongkir_transit.replace(/\./g, '')) + parseInt(ongkir_gudang.replace(/\./g, '')) + parseInt(bm.replace(/\./g, '')) + parseInt(ppn.replace(/\./g, '')) + parseInt(pph.replace(/\./g, ''));

        $('#grand_total').val(grand_total)
        $('#text_grand_total').html(format_rupiah(grand_total))
    }


    $('#simpan_pemesanan_fixing').click(function() {
        if ($('#gudang').val() == '') {
            $('#gudang').removeClass('is-valid');
            $('#gudang').addClass('is-invalid');
        } else {
            $('#gudang').addClass('is-valid');
            $('#gudang').removeClass('is-invalid');
        }
        if ($('#panjang').val() == '') {
            $('#panjang').removeClass('is-valid');
            $('#panjang').addClass('is-invalid');
        } else {
            $('#panjang').addClass('is-valid');
            $('#panjang').removeClass('is-invalid');
        }
        if ($('#lebar').val() == '') {
            $('#lebar').removeClass('is-valid');
            $('#lebar').addClass('is-invalid');
        } else {
            $('#lebar').addClass('is-valid');
            $('#lebar').removeClass('is-invalid');
        }
        if ($('#tinggi').val() == '') {
            $('#tinggi').removeClass('is-valid');
            $('#tinggi').addClass('is-invalid');
        } else {
            $('#tinggi').addClass('is-valid');
            $('#tinggi').removeClass('is-invalid');
        }
        if ($('#berat').val() == '') {
            $('#berat').removeClass('is-valid');
            $('#berat').addClass('is-invalid');
        } else {
            $('#berat').addClass('is-valid');
            $('#berat').removeClass('is-invalid');
        }
        if ($('#carton_koli').val() == '') {
            $('#carton_koli').removeClass('is-valid');
            $('#carton_koli').addClass('is-invalid');
        } else {
            $('#carton_koli').addClass('is-valid');
            $('#carton_koli').removeClass('is-invalid');
        }

        if ($('#gudang').val() != '' && $('#dimensi').val() != '' && $('#berat').val() != '' && $('#carton_koli').val() != '') {
            simpan_pemesanan_fixing();
        }
    })


    function simpan_pemesanan_fixing() {
        let id_pemesanan_fixing = '<?= $pemesananFixing['id'] ?>'
        let id_pemesanan = '<?= $pemesananFixing['id_pemesanan'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>purchase-simpan_pemesanan_fixing",
            data: 'id_pemesanan_fixing=' + id_pemesanan_fixing +
                '&id_pemesanan=' + id_pemesanan +
                '&id_user=' + $('#id_user').val() +
                '&id_gudang=' + $('#gudang').val() +
                '&invoice=' + $('#invoice').val() +
                '&no_pemesanan=' + $('#no_pemesanan').val() +
                '&tanggal=' + $('#tanggal').val() +
                '&panjang=' + $('#panjang').val() +
                '&lebar=' + $('#lebar').val() +
                '&tinggi=' + $('#tinggi').val() +
                '&berat=' + $('#berat').val() +
                '&carton_koli=' + $('#carton_koli').val() +
                '&exw=' + $('#exw').val() +
                '&hf=' + $('#hf').val() +
                '&ppn_hf=' + $('#ppn_hf').val() +
                '&ongkir_port=' + $('#ongkir_port').val() +
                '&ongkir_laut_udara=' + $('#ongkir_laut_udara').val() +
                '&ongkir_transit=' + $('#ongkir_transit').val() +
                '&ongkir_gudang=' + $('#ongkir_gudang').val() +
                '&bm=' + $('#bm').val() +
                '&ppn=' + $('#ppn').val() +
                '&pph=' + $('#pph').val() +
                '&grand_total=' + $('#grand_total').val() +
                '&catatan=' + $('#catatan').val(),
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    <?php session()->setFlashdata('pesan', 'Berhasil menyimpan fixing pemesanan.'); ?>
                    location.href = '<?= site_url("purchase-fixing_pemesanan?pesan=" . urlencode(session('pesan'))) ?>';
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


    $('#buat_pembelian').click(function() {
        if ($('#invoice').val() == '') {
            $('#invoice').removeClass('is-valid');
            $('#invoice').addClass('is-invalid');
        } else {
            $('#invoice').addClass('is-valid');
            $('#invoice').removeClass('is-invalid');
        }
        if ($('#gudang').val() == '') {
            $('#gudang').removeClass('is-valid');
            $('#gudang').addClass('is-invalid');
        } else {
            $('#gudang').addClass('is-valid');
            $('#gudang').removeClass('is-invalid');
        }
        if ($('#panjang').val() == '') {
            $('#panjang').removeClass('is-valid');
            $('#panjang').addClass('is-invalid');
        } else {
            $('#panjang').addClass('is-valid');
            $('#panjang').removeClass('is-invalid');
        }
        if ($('#lebar').val() == '') {
            $('#lebar').removeClass('is-valid');
            $('#lebar').addClass('is-invalid');
        } else {
            $('#lebar').addClass('is-valid');
            $('#lebar').removeClass('is-invalid');
        }
        if ($('#tinggi').val() == '') {
            $('#tinggi').removeClass('is-valid');
            $('#tinggi').addClass('is-invalid');
        } else {
            $('#tinggi').addClass('is-valid');
            $('#tinggi').removeClass('is-invalid');
        }
        if ($('#berat').val() == '') {
            $('#berat').removeClass('is-valid');
            $('#berat').addClass('is-invalid');
        } else {
            $('#berat').addClass('is-valid');
            $('#berat').removeClass('is-invalid');
        }
        if ($('#carton_koli').val() == '') {
            $('#carton_koli').removeClass('is-valid');
            $('#carton_koli').addClass('is-invalid');
        } else {
            $('#carton_koli').addClass('is-valid');
            $('#carton_koli').removeClass('is-invalid');
        }

        if ($('#invoice').val() != '' && $('#gudang').val() != '' && $('#dimensi').val() != '' && $('#berat').val() != '' && $('#carton_koli').val() != '') {
            buat_pembelian();
        }
    })


    function update_pemesanan_fixing() {
        let id_pemesanan_fixing = '<?= $pemesananFixing['id'] ?>'
        let id_pemesanan = '<?= $pemesananFixing['id_pemesanan'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>purchase-simpan_pemesanan_fixing",
            data: 'id_pemesanan_fixing=' + id_pemesanan_fixing +
                '&id_pemesanan=' + id_pemesanan +
                '&id_user=' + $('#id_user').val() +
                '&id_gudang=' + $('#gudang').val() +
                '&invoice=' + $('#invoice').val() +
                '&no_pemesanan=' + $('#no_pemesanan').val() +
                '&tanggal=' + $('#tanggal').val() +
                '&panjang=' + $('#panjang').val() +
                '&lebar=' + $('#lebar').val() +
                '&tinggi=' + $('#tinggi').val() +
                '&berat=' + $('#berat').val() +
                '&carton_koli=' + $('#carton_koli').val() +
                '&exw=' + $('#exw').val() +
                '&hf=' + $('#hf').val() +
                '&ppn_hf=' + $('#ppn_hf').val() +
                '&ongkir_port=' + $('#ongkir_port').val() +
                '&ongkir_laut_udara=' + $('#ongkir_laut_udara').val() +
                '&ongkir_transit=' + $('#ongkir_transit').val() +
                '&ongkir_gudang=' + $('#ongkir_gudang').val() +
                '&bm=' + $('#bm').val() +
                '&ppn=' + $('#ppn').val() +
                '&pph=' + $('#pph').val() +
                '&grand_total=' + $('#grand_total').val() +
                '&catatan=' + $('#catatan').val(),
            dataType: "json",
            success: function(response) {
                if (!response.ok) {
                    Swal.fire(
                        'Opss.',
                        'Terjadi kesalahan update fixing pemesanan.',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }

    function buat_pembelian() {
        let id_pemesanan_fixing = '<?= $pemesananFixing['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>purchase-check_produk_pembelian",
            data: 'id_pemesanan_fixing=' + id_pemesanan_fixing,
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    Swal.fire({
                        title: 'Konfirmasi?',
                        text: "Apakah yakin buat pembelian?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lanjut!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            update_pemesanan_fixing()
                            $('#form_pembelian').submit();
                        }
                    })
                } else {
                    Swal.fire(
                        'Opss.',
                        'Tidak ada produk dalam pembelian. pilih minimal satu produk dulu!',
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