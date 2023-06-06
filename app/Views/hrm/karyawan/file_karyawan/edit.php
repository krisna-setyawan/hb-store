<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">

    <form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>hrm-file-karyawan/update/<?= $file['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="d-flex my-0">
            <div class="me-auto mb-1">
                <h3 style="color: #566573;">Tambah File Karyawan <?= ucwords(strtolower($karyawan_name)) ?></h3>
            </div>
            <div class="me-2 mb-1">
                <a class="btn btn-sm btn-outline-dark mb-3" href="<?= site_url() ?>hrm-file-karyawan/<?= $id_karyawan ?>">
                    <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <hr class="mt-0 mb-4">
        <?= csrf_field() ?>

        <input type="hidden" name="_method" value="PUT">
        <div class="row mb-3">
            <label for="nama" class="col-sm-3 col-form-label">Nama</label>
            <div class="col-sm-9">
                <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= $file['nama']; ?>" autofocus>
                <div class="invalid-feedback"> <?= validation_show_error('nama'); ?></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="tgl_upload" class="col-sm-3 col-form-label">Tanggal Upload</label>
            <div class="col-sm-9">
                <input type="text" class="form-control <?= (validation_show_error('tgl_upload')) ? 'is-invalid' : ''; ?>" id="tgl_upload" name="tgl_upload" value="<?= $file['tgl_upload']; ?>" autofocus>
                <div class="invalid-feedback"> <?= validation_show_error('tgl_upload'); ?></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama_file" class="col-sm-3 col-form-label">Masukan File</label>
            <div class="col-sm-9">
                <input type="file" class="form-control <?= (validation_show_error('nama_file')) ? 'is-invalid' : ''; ?>" id="nama_file" name="nama_file" value="<?= $file['nama_file']; ?>" autofocus>
                <div class="invalid-feedback"> <?= validation_show_error('nama_file'); ?></div>
            </div>
        </div>

        <input type="hidden" name="id_karyawan" value="<?= $id_karyawan ?>">

        <div class="col-md-9 offset-3 mb-3">
            <button class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
        </div>
    </form>

</main>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {

        $('#tgl_upload').datepicker({
            format: "yyyy-mm-dd"
        });

    })
</script>

<?= $this->endSection() ?>