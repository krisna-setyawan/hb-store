<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Tambah Gudang</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>resource-gudang">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="col-md-10 mt-4">

        <form novalidate class="needs-validation" autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>resource-gudang" method="POST">

            <?= csrf_field() ?>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama Gudang</label>
                <div class="col-sm-9">
                    <input required type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama'); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('nama'); ?></div>
                </div>
            </div>

            <!-- PROVINSI -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Provinsi</label>
                <div class="col-sm-9">
                    <select required class="form-select" id="id_provinsi" name="id_provinsi">
                        <option selected value=""></option>
                        <?php foreach ($provinsi as $prov) { ?>
                            <option value="<?= $prov['id'] ?>"><?= $prov['nama'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- KOTA -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Kota</label>
                <div class="col-sm-9">
                    <select required class="form-select" id="id_kota" name="id_kota">
                        <option selected value=""></option>
                    </select>
                </div>
            </div>

            <!-- KECAMATAN -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Kecamatan</label>
                <div class="col-sm-9">
                    <select required class="form-select" id="id_kecamatan" name="id_kecamatan">
                        <option selected value=""></option>
                    </select>
                </div>
            </div>

            <!-- KELURAHAN -->
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Kelurahan</label>
                <div class="col-sm-9">
                    <select required class="form-select" id="id_kelurahan" name="id_kelurahan">
                        <option selected value=""></option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Detail Alamat</label>
                <div class="col-sm-9">
                    <input required type="text" class="form-control <?= (validation_show_error('keterangan')) ? 'is-invalid' : ''; ?>" name="detail_alamat" value="<?= old('no_telp'); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('detail_alamat'); ?></div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">No Telp</label>
                <div class="col-sm-9">
                    <input required type="text" class="form-control <?= (validation_show_error('no_telp')) ? 'is-invalid' : ''; ?>" id="no_telp" name="no_telp" value="<?= old('no_telp'); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('no_telp'); ?></div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Keterangan</label>
                <div class="col-sm-9">
                    <input required type="text" class="form-control <?= (validation_show_error('keterangan')) ? 'is-invalid' : ''; ?>" id="keterangan" name="keterangan" value="<?= old('keterangan'); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('keterangan'); ?></div>
                </div>
            </div>

            <div class="text-center">
                <a class="btn px-5 btn-outline-danger" href="<?= site_url() ?>resource-gudang">
                    Batal <i class="fa-fw fa-solid fa-xmark"></i>
                </a>
                <button class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
            </div>
        </form>

    </div>
</main>

<?= $this->include('MyLayout/js') ?>
<?= $this->include('MyLayout/validation') ?>

<script>
    $(document).ready(function() {
        $("#id_provinsi").select2({
            theme: "bootstrap-5",
        });
        $("#id_kota").select2({
            theme: "bootstrap-5",
        });
        $("#id_kecamatan").select2({
            theme: "bootstrap-5",
        });
        $("#id_kelurahan").select2({
            theme: "bootstrap-5",
        });
    })


    // RANTAI WILAYAH
    $(document).ready(function() {
        $('#id_provinsi').change(function() {
            let id_provinsi = $(this).val();
            if (id_provinsi != '') {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('wilayah/kota_by_provinsi') ?>',
                    data: '&id_provinsi=' + id_provinsi,
                    success: function(html) {
                        $('#id_kota').html(html);
                        $('#id_kecamatan').html('<option selected value=""></option>');
                        $('#id_kelurahan').html('<option selected value=""></option>');
                    }
                })
            } else {
                $('#id_kota').html('<option selected value=""></option>');
                $('#id_kecamatan').html('<option selected value=""></option>');
                $('#id_kelurahan').html('<option selected value=""></option>');
            }
        })

        $('#id_kota').change(function() {
            let id_kota = $(this).val();
            if (id_kota != '') {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('wilayah/kecamatan_by_kota') ?>',
                    data: '&id_kota=' + id_kota,
                    success: function(html) {
                        $('#id_kecamatan').html(html);
                        $('#id_kelurahan').html('<option selected value=""></option>');
                    }
                })
            } else {
                $('#id_kecamatan').html('<option selected value=""></option>');
                $('#id_kelurahan').html('<option selected value=""></option>');
            }
        })

        $('#id_kecamatan').change(function() {
            let id_kecamatan = $(this).val();
            if (id_kecamatan != '') {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('wilayah/kelurahan_by_kecamatan') ?>',
                    data: '&id_kecamatan=' + id_kecamatan,
                    success: function(html) {
                        $('#id_kelurahan').html(html);
                    }
                })
            } else {
                $('#id_kelurahan').html('<option selected value=""></option>');
            }
        })
    })
</script>

<?= $this->endSection() ?>