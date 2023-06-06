<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Edit Jasa</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>resource-jasa">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="col-md-10 mt-4">

        <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>resource-jasa/<?= $jasa['id'] ?>" method="POST">

            <?= csrf_field() ?>

            <input type="hidden" name="_method" value="PUT">

            <div class="row mb-3">
                <label for="nama" class="col-sm-3 col-form-label">Nama Jasa</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama', $jasa['nama']); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('nama'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="biaya" class="col-sm-3 col-form-label">Biaya</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="text" class="form-control <?= (validation_show_error('biaya')) ? 'is-invalid' : ''; ?>" id="biaya" name="biaya" value="<?= old('biaya', $jasa['biaya']); ?>">
                        <div class="invalid-feedback"><?= validation_show_error('biaya'); ?></div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?= (validation_show_error('deskripsi')) ? 'is-invalid' : ''; ?>" id="deskripsi" name="deskripsi" value="<?= old('deskripsi', $jasa['deskripsi']); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('deskripsi'); ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="kategori" class="col-sm-3 col-form-label">Kategori</label>
                <div class="col-sm-9">
                    <select class="form-control" name="kategori" id="kategori">
                        <?php foreach ($kategori as $kt) : ?>
                            <option <?= (old('kategori', $jasa['id_kategori']) == $kt['id']) ? 'selected' : ''; ?> value="<?= $kt['id'] ?>-krisna-<?= $kt['nama'] ?>"><?= $kt['nama'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback"><?= validation_show_error('kategori'); ?></div>
                </div>
            </div>

            <div class="text-center">
                <a class="btn px-5 btn-outline-danger" href="<?= site_url() ?>resource-jasa">
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
        $("#kategori").select2({
            theme: "bootstrap-5",
            tags: true
        });

        $('#biaya').mask('000.000.000', {
            reverse: true
        });
    })
</script>

<?= $this->endSection() ?>