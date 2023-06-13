<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Data Produk <?= $perusahaan['nama'] ?></h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>resource-perusahaan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="15%">SKU</th>
                    <th class="text-center" width="40%">Nama Produk</th>
                    <th class="text-center" width="15%">Jenis</th>
                    <th class="text-center" width="15%">Harga</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($produk as $pr) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $pr['sku'] ?></td>
                        <td><?= $pr['produk'] ?></td>
                        <td><?= $pr['jenis'] ?></td>
                        <td>Rp. <?= number_format($pr['harga_jual'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <a title="Copy Produk" class="px-2 py-0 btn btn-sm btn-outline-danger" onclick="cekExistProduk('<?= $pr['sku'] ?>')">
                                <i class="fa-fw fa-solid fa-circle-chevron-down"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>


<!-- Modal -->
<div class="modal fade" id="my-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal">Tambah Produk</h1>
                <button type="button" class="btn-close" id="closeBtn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiForm">

                <form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>resource-produk" method="POST" id="form">

                    <?= csrf_field() ?>

                    <div class="row mb-3">
                        <label for="form-nama" class="col-sm-3 col-form-label">Nama Produk</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="form-nama" name="nama" autofocus>
                            <div class="invalid-feedback error-nama"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="form-sku" class="col-sm-3 col-form-label">SKU</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="form-sku" name="sku" autofocus>
                            <div class="invalid-feedback error-sku"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="form-id_kategori" class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="id_kategori" id="form-id_kategori">
                                <?php foreach ($kategori as $kt) : ?>
                                    <option value="<?= $kt['id'] ?>-krisna-<?= $kt['nama'] ?>"><?= $kt['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback error-id_kategori"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="form-hs_code" class="col-sm-3 col-form-label">HS Code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="form-hs_code" name="hs_code" autofocus>
                            <div class="invalid-feedback error-hs_code"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="form-satuan" class="col-sm-3 col-form-label">Satuan</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="satuan" id="form-satuan">
                                <option value=""></option>
                                <option value="Unit">Unit</option>
                                <option value="Pcs">Pcs</option>
                            </select>
                            <div class="invalid-feedback error-satuan"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="form-tipe" class="col-sm-3 col-form-label">Tipe</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="tipe" id="form-tipe">
                                <option value=""></option>
                                <option value="SET">SET</option>
                                <option value="SINGLE">SINGLE</option>
                                <option value="ECER">ECER</option>
                            </select>
                            <div class="invalid-feedback error-tipe"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="form-jenis" class="col-sm-3 col-form-label">Jenis Produk</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="jenis" id="form-jenis">
                                <option value=""></option>
                                <option value="Produk Fisik">Produk Fisik</option>
                                <option value="Produk Digital">Produk Digital</option>
                            </select>
                            <div class="invalid-feedback error-jenis"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="form-harga_beli" class="col-sm-3 col-form-label">Harga Beli</label>
                        <div class="col-sm-9">
                            <!-- <div class="input-group"> -->
                            <!-- <span class="input-group-text">Rp.</span> -->
                            <input readonly type="text" class="form-control" id="form-harga_beli" name="harga_beli">
                            <div class="invalid-feedback error-harga_beli"></div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="form-harga_jual" class="col-sm-3 col-form-label">Harga Jual</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="text" class="form-control" id="form-harga_jual" name="harga_jual">
                                <div class="invalid-feedback error-harga_jual"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="form-stok" class="col-sm-3 col-form-label">Stok Awal</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" id="form-stok" name="stok" value="0">
                            <div class="invalid-feedback error-stok"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="form-berat" class="col-sm-3 col-form-label">Berat</label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" id="form-berat" name="berat">
                            <div class="invalid-feedback error-berat"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-sm-3 col-form-label">Ukuran</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-text">P</span>
                                <input type="number" min="0" class="form-control" id="form-panjang" name="panjang">
                                <div class="invalid-feedback error-panjang"></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-text">L</span>
                                <input type="number" min="0" class="form-control" id="form-lebar" name="lebar">
                                <div class="invalid-feedback error-lebar"></div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-text">T</span>
                                <input type="number" min="0" class="form-control" id="form-tinggi" name="tinggi">
                                <div class="invalid-feedback error-tinggi"></div>
                            </div>
                        </div>

                        <input type="hidden" name="minimal_penjualan" value="0">
                        <input type="hidden" name="kelipatan_penjualan" value="0">
                        <input type="hidden" name="status_marketing" value="Belum desain">
                    </div>

                    <div class="col-md-9 offset-3 mb-3">
                        <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->


<?= $this->include('MyLayout/js') ?>


<script>
    $(document).ready(function() {
        $('#tabel').dataTable();

        $("#form-id_kategori").select2({
            theme: "bootstrap-5",
            tags: true,
            dropdownParent: $('#my-modal')
        });

        $('#form-harga_beli').mask('000.000.000', {
            reverse: true
        });

        $('#form-harga_jual').mask('000.000.000', {
            reverse: true
        });
    })



    function copyProduk(sku) {
        var apiUrl = '<?= $perusahaan['url'] ?>/hbapi-get-produk/' + sku;

        $.ajax({
            url: apiUrl,
            method: 'GET',
            success: function(response) {
                if (response.message === 'success') {
                    var product = response.product;
                    $('#form-nama').val(product.nama);
                    $('#form-sku').val(product.sku);
                    $('#form-kategori').val(product.kategori);
                    $('#form-hs_code').val(product.hs_code);
                    $('#form-satuan').val(product.satuan);
                    $('#form-tipe').val(product.tipe);
                    $('#form-jenis').val(product.jenis);
                    $('#form-harga_beli').val(format_rupiah(product.harga_jual));
                    $('#form-berat').val(product.berat);
                    $('#form-panjang').val(product.panjang);
                    $('#form-lebar').val(product.lebar);
                    $('#form-tinggi').val(product.tinggi);
                    $('#my-modal').modal('toggle')
                } else {
                    console.log('Gagal mengambil data produk.');
                }
            },
            error: function() {
                console.log('Terjadi kesalahan saat mengambil data produk.');
            }
        });
    }



    function cekExistProduk(sku) {
        $.ajax({
            url: '<?= site_url() ?>resource-cek-exist-produk/' + sku,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.produk) {
                    Swal.fire(
                        'Opss.',
                        'Produk dengan SKU ' + sku + ' sudah ada di data produk.',
                        'error'
                    )
                } else {
                    copyProduk(sku)
                }
            },
            error: function() {
                console.log('Terjadi kesalahan saat ajax cek produk.');
            }
        });
    }



    $('#form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html('Tunggu <i class="fa-solid fa-spin fa-spinner"></i>');
                $('#tombolSimpan').prop('disabled', true);
            },
            complete: function() {
                $('#tombolSimpan').html('Simpan <i class="fa-fw fa-solid fa-check"></i>');
                $('#tombolSimpan').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.error_id_kategori) {
                        $('.error-id_kategori').html(err.error_id_kategori);
                        $('#form-id_kategori').addClass('is-invalid');
                    } else {
                        $('.error-id_kategori').html('');
                        $('#form-id_kategori').removeClass('is-invalid');
                        $('#form-id_kategori').addClass('is-valid');
                    }
                    if (err.error_sku) {
                        $('.error-sku').html(err.error_sku);
                        $('#form-sku').addClass('is-invalid');
                    } else {
                        $('.error-sku').html('');
                        $('#form-sku').removeClass('is-invalid');
                        $('#form-sku').addClass('is-valid');
                    }
                    if (err.error_hs_code) {
                        $('.error-hs_code').html(err.error_hs_code);
                        $('#form-hs_code').addClass('is-invalid');
                    } else {
                        $('.error-hs_code').html('');
                        $('#form-hs_code').removeClass('is-invalid');
                        $('#form-hs_code').addClass('is-valid');
                    }
                    if (err.error_nama) {
                        $('.error-nama').html(err.error_nama);
                        $('#form-nama').addClass('is-invalid');
                    } else {
                        $('.error-nama').html('');
                        $('#form-nama').removeClass('is-invalid');
                        $('#form-nama').addClass('is-valid');
                    }
                    if (err.error_satuan) {
                        $('.error-satuan').html(err.error_satuan);
                        $('#form-satuan').addClass('is-invalid');
                    } else {
                        $('.error-satuan').html('');
                        $('#form-satuan').removeClass('is-invalid');
                        $('#form-satuan').addClass('is-valid');
                    }
                    if (err.error_tipe) {
                        $('.error-tipe').html(err.error_tipe);
                        $('#form-tipe').addClass('is-invalid');
                    } else {
                        $('.error-tipe').html('');
                        $('#form-tipe').removeClass('is-invalid');
                        $('#form-tipe').addClass('is-valid');
                    }
                    if (err.error_jenis) {
                        $('.error-jenis').html(err.error_jenis);
                        $('#form-jenis').addClass('is-invalid');
                    } else {
                        $('.error-jenis').html('');
                        $('#form-jenis').removeClass('is-invalid');
                        $('#form-jenis').addClass('is-valid');
                    }
                    if (err.error_harga_beli) {
                        $('.error-harga_beli').html(err.error_harga_beli);
                        $('#form-harga_beli').addClass('is-invalid');
                    } else {
                        $('.error-harga_beli').html('');
                        $('#form-harga_beli').removeClass('is-invalid');
                        $('#form-harga_beli').addClass('is-valid');
                    }
                    if (err.error_harga_jual) {
                        $('.error-harga_jual').html(err.error_harga_jual);
                        $('#form-harga_jual').addClass('is-invalid');
                    } else {
                        $('.error-harga_jual').html('');
                        $('#form-harga_jual').removeClass('is-invalid');
                        $('#form-harga_jual').addClass('is-valid');
                    }
                    if (err.error_stok) {
                        $('.error-stok').html(err.error_stok);
                        $('#form-stok').addClass('is-invalid');
                    } else {
                        $('.error-stok').html('');
                        $('#form-stok').removeClass('is-invalid');
                        $('#form-stok').addClass('is-valid');
                    }
                    if (err.error_berat) {
                        $('.error-berat').html(err.error_berat);
                        $('#form-berat').addClass('is-invalid');
                    } else {
                        $('.error-berat').html('');
                        $('#form-berat').removeClass('is-invalid');
                        $('#form-berat').addClass('is-valid');
                    }
                    if (err.error_panjang) {
                        $('.error-panjang').html(err.error_panjang);
                        $('#form-panjang').addClass('is-invalid');
                    } else {
                        $('.error-panjang').html('');
                        $('#form-panjang').removeClass('is-invalid');
                        $('#form-panjang').addClass('is-valid');
                    }
                    if (err.error_lebar) {
                        $('.error-lebar').html(err.error_lebar);
                        $('#form-lebar').addClass('is-invalid');
                    } else {
                        $('.error-lebar').html('');
                        $('#form-lebar').removeClass('is-invalid');
                        $('#form-lebar').addClass('is-valid');
                    }
                    if (err.error_tinggi) {
                        $('.error-tinggi').html(err.error_tinggi);
                        $('#form-tinggi').addClass('is-invalid');
                    } else {
                        $('.error-tinggi').html('');
                        $('#form-tinggi').removeClass('is-invalid');
                        $('#form-tinggi').addClass('is-valid');
                    }
                }
                if (response.success) {
                    $('#my-modal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                    })
                    var form = $('#form');
                    form[0].reset();
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false
    })


    $('#closeBtn').click(function() {
        var form = $('#form');

        form[0].reset();

        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.is-valid').removeClass('is-valid');
        form.find('.invalid-feedback').hide();
    });
</script>


<?= $this->endSection() ?>