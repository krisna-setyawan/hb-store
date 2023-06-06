<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>resource-produk" method="POST" id="form">

    <?= csrf_field() ?>

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Nama Produk</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name="nama" autofocus>
            <div class="invalid-feedback error-nama"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="sku" class="col-sm-3 col-form-label">SKU</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="sku" name="sku" autofocus>
            <div class="invalid-feedback error-sku"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="id_kategori" class="col-sm-3 col-form-label">Kategori</label>
        <div class="col-sm-9">
            <select class="form-control" name="id_kategori" id="id_kategori">
                <?php foreach ($kategori as $kt) : ?>
                    <option value="<?= $kt['id'] ?>-krisna-<?= $kt['nama'] ?>"><?= $kt['nama'] ?></option>
                <?php endforeach ?>
            </select>
            <div class="invalid-feedback error-id_kategori"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="hs_code" class="col-sm-3 col-form-label">HS Code</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="hs_code" name="hs_code" autofocus>
            <div class="invalid-feedback error-hs_code"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>
        <div class="col-sm-9">
            <select class="form-control" name="satuan" id="satuan">
                <option value=""></option>
                <option value="Unit">Unit</option>
                <option value="Pcs">Pcs</option>
            </select>
            <div class="invalid-feedback error-satuan"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
        <div class="col-sm-9">
            <select class="form-control" name="tipe" id="tipe">
                <option value=""></option>
                <option value="SET">SET</option>
                <option value="SINGLE">SINGLE</option>
                <option value="ECER">ECER</option>
            </select>
            <div class="invalid-feedback error-tipe"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="jenis" class="col-sm-3 col-form-label">Jenis Produk</label>
        <div class="col-sm-9">
            <select class="form-control" name="jenis" id="jenis">
                <option value=""></option>
                <option value="Produk Fisik">Produk Fisik</option>
                <option value="Produk Digital">Produk Digital</option>
            </select>
            <div class="invalid-feedback error-jenis"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="harga_beli" class="col-sm-3 col-form-label">Harga Beli</label>
        <div class="col-sm-9">
            <div class="input-group">
                <span class="input-group-text">Rp.</span>
                <input type="text" class="form-control" id="harga_beli" name="harga_beli">
                <div class="invalid-feedback error-harga_beli"></div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="harga_jual" class="col-sm-3 col-form-label">Harga Jual</label>
        <div class="col-sm-9">
            <div class="input-group">
                <span class="input-group-text">Rp.</span>
                <input type="text" class="form-control" id="harga_jual" name="harga_jual">
                <div class="invalid-feedback error-harga_jual"></div>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <label for="stok" class="col-sm-3 col-form-label">Stok Awal</label>
        <div class="col-sm-9">
            <input type="number" min="0" class="form-control" id="stok" name="stok">
            <div class="invalid-feedback error-stok"></div>
        </div>
    </div>
    <div class="row mb-2">
        <label for="berat" class="col-sm-3 col-form-label">Berat</label>
        <div class="col-sm-9">
            <input type="number" min="0" class="form-control" id="berat" name="berat">
            <div class="invalid-feedback error-berat"></div>
        </div>
    </div>
    <div class="row mb-2">
        <label class="col-sm-3 col-form-label">Ukuran</label>
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-text">P</span>
                <input type="number" min="0" class="form-control" id="panjang" name="panjang">
                <div class="invalid-feedback error-panjang"></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-text">L</span>
                <input type="number" min="0" class="form-control" id="lebar" name="lebar">
                <div class="invalid-feedback error-lebar"></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-text">T</span>
                <input type="number" min="0" class="form-control" id="tinggi" name="tinggi">
                <div class="invalid-feedback error-tinggi"></div>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <label for="minimal_penjualan" class="col-sm-3 col-form-label">Minimal Penjualan</label>
        <div class="col-sm-9">
            <input type="number" min="0" class="form-control" id="minimal_penjualan" name="minimal_penjualan">
            <div class="invalid-feedback error-minimal_penjualan"></div>
        </div>
    </div>
    <div class="row mb-2">
        <label for="kelipatan_penjualan" class="col-sm-3 col-form-label">Kelipatan Penjualan</label>
        <div class="col-sm-9">
            <input type="number" min="0" class="form-control" id="kelipatan_penjualan" name="kelipatan_penjualan">
            <div class="invalid-feedback error-kelipatan_penjualan"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="status_marketing" class="col-sm-3 col-form-label">Marketing</label>
        <div class="col-sm-9">
            <select class="form-control" name="status_marketing" id="status_marketing">
                <option value=""></option>
                <option value="Belum desain">Belum desain</option>
                <option value="Sudah desain">Sudah desain</option>
                <option value="Sudah dipost">Sudah dipost</option>
            </select>
            <div class="invalid-feedback error-status_marketing"></div>
        </div>
    </div>
    <div class="row mb-2">
        <label for="note" class="col-sm-3 col-form-label">Note</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="note" name="note">
            <div class="invalid-feedback error-note"></div>
        </div>
    </div>

    <div class="col-md-9 offset-3 mb-3">
        <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
    </div>
</form>



<script>
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
                        $('#id_kategori').addClass('is-invalid');
                    } else {
                        $('.error-id_kategori').html('');
                        $('#id_kategori').removeClass('is-invalid');
                        $('#id_kategori').addClass('is-valid');
                    }
                    if (err.error_id_gudang) {
                        $('.error-id_gudang').html(err.error_id_gudang);
                        $('#id_gudang').addClass('is-invalid');
                    } else {
                        $('.error-id_gudang').html('');
                        $('#id_gudang').removeClass('is-invalid');
                        $('#id_gudang').addClass('is-valid');
                    }
                    if (err.error_sku) {
                        $('.error-sku').html(err.error_sku);
                        $('#sku').addClass('is-invalid');
                    } else {
                        $('.error-sku').html('');
                        $('#sku').removeClass('is-invalid');
                        $('#sku').addClass('is-valid');
                    }
                    if (err.error_hs_code) {
                        $('.error-hs_code').html(err.error_hs_code);
                        $('#hs_code').addClass('is-invalid');
                    } else {
                        $('.error-hs_code').html('');
                        $('#hs_code').removeClass('is-invalid');
                        $('#hs_code').addClass('is-valid');
                    }
                    if (err.error_nama) {
                        $('.error-nama').html(err.error_nama);
                        $('#nama').addClass('is-invalid');
                    } else {
                        $('.error-nama').html('');
                        $('#nama').removeClass('is-invalid');
                        $('#nama').addClass('is-valid');
                    }
                    if (err.error_satuan) {
                        $('.error-satuan').html(err.error_satuan);
                        $('#satuan').addClass('is-invalid');
                    } else {
                        $('.error-satuan').html('');
                        $('#satuan').removeClass('is-invalid');
                        $('#satuan').addClass('is-valid');
                    }
                    if (err.error_tipe) {
                        $('.error-tipe').html(err.error_tipe);
                        $('#tipe').addClass('is-invalid');
                    } else {
                        $('.error-tipe').html('');
                        $('#tipe').removeClass('is-invalid');
                        $('#tipe').addClass('is-valid');
                    }
                    if (err.error_jenis) {
                        $('.error-jenis').html(err.error_jenis);
                        $('#jenis').addClass('is-invalid');
                    } else {
                        $('.error-jenis').html('');
                        $('#jenis').removeClass('is-invalid');
                        $('#jenis').addClass('is-valid');
                    }
                    if (err.error_harga_beli) {
                        $('.error-harga_beli').html(err.error_harga_beli);
                        $('#harga_beli').addClass('is-invalid');
                    } else {
                        $('.error-harga_beli').html('');
                        $('#harga_beli').removeClass('is-invalid');
                        $('#harga_beli').addClass('is-valid');
                    }
                    if (err.error_harga_jual) {
                        $('.error-harga_jual').html(err.error_harga_jual);
                        $('#harga_jual').addClass('is-invalid');
                    } else {
                        $('.error-harga_jual').html('');
                        $('#harga_jual').removeClass('is-invalid');
                        $('#harga_jual').addClass('is-valid');
                    }
                    if (err.error_stok) {
                        $('.error-stok').html(err.error_stok);
                        $('#stok').addClass('is-invalid');
                    } else {
                        $('.error-stok').html('');
                        $('#stok').removeClass('is-invalid');
                        $('#stok').addClass('is-valid');
                    }
                    if (err.error_berat) {
                        $('.error-berat').html(err.error_berat);
                        $('#berat').addClass('is-invalid');
                    } else {
                        $('.error-berat').html('');
                        $('#berat').removeClass('is-invalid');
                        $('#berat').addClass('is-valid');
                    }
                    if (err.error_panjang) {
                        $('.error-panjang').html(err.error_panjang);
                        $('#panjang').addClass('is-invalid');
                    } else {
                        $('.error-panjang').html('');
                        $('#panjang').removeClass('is-invalid');
                        $('#panjang').addClass('is-valid');
                    }
                    if (err.error_lebar) {
                        $('.error-lebar').html(err.error_lebar);
                        $('#lebar').addClass('is-invalid');
                    } else {
                        $('.error-lebar').html('');
                        $('#lebar').removeClass('is-invalid');
                        $('#lebar').addClass('is-valid');
                    }
                    if (err.error_tinggi) {
                        $('.error-tinggi').html(err.error_tinggi);
                        $('#tinggi').addClass('is-invalid');
                    } else {
                        $('.error-tinggi').html('');
                        $('#tinggi').removeClass('is-invalid');
                        $('#tinggi').addClass('is-valid');
                    }
                    if (err.error_minimal_penjualan) {
                        $('.error-minimal_penjualan').html(err.error_minimal_penjualan);
                        $('#minimal_penjualan').addClass('is-invalid');
                    } else {
                        $('.error-minimal_penjualan').html('');
                        $('#minimal_penjualan').removeClass('is-invalid');
                        $('#minimal_penjualan').addClass('is-valid');
                    }
                    if (err.error_kelipatan_penjualan) {
                        $('.error-kelipatan_penjualan').html(err.error_kelipatan_penjualan);
                        $('#kelipatan_penjualan').addClass('is-invalid');
                    } else {
                        $('.error-kelipatan_penjualan').html('');
                        $('#kelipatan_penjualan').removeClass('is-invalid');
                        $('#kelipatan_penjualan').addClass('is-valid');
                    }
                    if (err.error_status_marketing) {
                        $('.error-status_marketing').html(err.error_status_marketing);
                        $('#status_marketing').addClass('is-invalid');
                    } else {
                        $('.error-status_marketing').html('');
                        $('#status_marketing').removeClass('is-invalid');
                        $('#status_marketing').addClass('is-valid');
                    }
                }
                if (response.success) {
                    $('#my-modal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                    }).then((value) => {
                        $('#tabel').DataTable().ajax.reload();
                        Toast.fire({
                            icon: 'success',
                            title: response.success
                        })
                    })
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false
    })

    $(document).ready(function() {
        $("#id_kategori").select2({
            theme: "bootstrap-5",
            tags: true,
            dropdownParent: $('#my-modal')
        });

        $("#id_gudang").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#my-modal')
        });

        $('#harga_beli').mask('000.000.000', {
            reverse: true
        });
        $('#harga_jual').mask('000.000.000', {
            reverse: true
        });
    })
</script>