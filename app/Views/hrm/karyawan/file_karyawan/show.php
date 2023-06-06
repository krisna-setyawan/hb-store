<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">Nama</div>
        </div>
        <div class="col-md-9">
            <?= $file['nama'] ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">Tanggal Upload</div>
        </div>
        <div class="col-md-9">
            <?= $file['tgl_upload'] ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">Berkas</div>
        </div>
        <div class="col-md-9">

        </div>
    </div>
    <?php
    if (strpos($file['nama_file'], ".pdf") !== false) { ?>
        <embed type="application/pdf" src="<?= base_url() ?>/file_karyawan/<?= $file['nama_file'] ?>" width="100%" height="500px"></embed>
    <?php } else { ?>
        <img src="<?= base_url() ?>/file_karyawan/<?= $file['nama_file'] ?>" width="100%">
    <?php }
    ?>


</div>