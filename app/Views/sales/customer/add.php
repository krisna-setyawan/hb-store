<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Tambah Customer</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>sales-customer">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="col-md-10 mt-4 mb-5">

        <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>sales-customer" method="POST">

            <?= csrf_field() ?>

            <div class="row mb-3">
                <label for="id_customer" class="col-sm-3 col-form-label">ID Customer</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('id_customer')) ? 'is-invalid' : ''; ?>" id="id_customer" name="id_customer" value="<?= old('id_customer'); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('id_customer'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Nama Customer</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama'); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('nama'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="no_telp" class="col-sm-3 col-form-label">No Telp</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('no_telp')) ? 'is-invalid' : ''; ?>" id="no_telp" name="no_telp" value="<?= old('no_telp'); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('no_telp'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= old('email'); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('email'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="saldo_utama" class="col-sm-3 col-form-label">Awal Saldo Utama</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('saldo_utama')) ? 'is-invalid' : ''; ?>" id="saldo_utama" name="saldo_utama" value="<?= old('saldo_utama'); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('saldo_utama'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="saldo_belanja" class="col-sm-3 col-form-label">Awal Saldo Belanja</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('saldo_belanja')) ? 'is-invalid' : ''; ?>" id="saldo_belanja" name="saldo_belanja" value="<?= old('saldo_belanja'); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('saldo_belanja'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="saldo_lain" class="col-sm-3 col-form-label">Awal Saldo Lain</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('saldo_lain')) ? 'is-invalid' : ''; ?>" id="saldo_lain" name="saldo_lain" value="<?= old('saldo_lain'); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('saldo_lain'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="tgl_registrasi" class="col-sm-3 col-form-label">Tgl Registrasi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('tgl_registrasi')) ? 'is-invalid' : ''; ?>" id="tgl_registrasi" name="tgl_registrasi" value="<?= old('tgl_registrasi', date('Y-m-d')); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('tgl_registrasi'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="note" class="col-sm-3 col-form-label">Note</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('note')) ? 'is-invalid' : ''; ?>" id="note" name="note" value="<?= old('note'); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('note'); ?></div>
                </div>
            </div>

            <div class="text-center">
                <a class="btn px-5 btn-outline-danger" href="<?= site_url() ?>sales-customer">
                    Batal <i class="fa-fw fa-solid fa-xmark"></i>
                </a>
                <button class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
            </div>
        </form>

    </div>
</main>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $('#saldo_utama').mask('000.000.000', {
            reverse: true
        });
        $('#saldo_belanja').mask('000.000.000', {
            reverse: true
        });
        $('#saldo_lain').mask('000.000.000', {
            reverse: true
        });
        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd"
        });
    })
</script>

<?= $this->endSection() ?>