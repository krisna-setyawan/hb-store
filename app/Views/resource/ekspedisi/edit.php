<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Edit Ekspedisi</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>ekspedisi">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="col-md-10 mt-4">

        <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>ekspedisi/<?= $ekspedisi['id'] ?>" method="POST">

            <?= csrf_field() ?>

            <input type="hidden" name="_method" value="PUT">

            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Nama Ekspedisi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama', $ekspedisi['nama']); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('nama'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('deskripsi')) ? 'is-invalid' : ''; ?>" id="deskripsi" name="deskripsi" value="<?= old('deskripsi', $ekspedisi['deskripsi']); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('deskripsi'); ?></div>
                </div>
            </div>

            <div class="text-center">
                <a class="btn px-5 btn-outline-danger" href="<?= site_url() ?>ekspedisi">
                    Batal <i class="fa-fw fa-solid fa-xmark"></i>
                </a>
                <button class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
            </div>
        </form>

    </div>
</main>

<?= $this->include('MyLayout/js') ?>

<?= $this->endSection() ?>