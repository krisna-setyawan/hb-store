<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto">
            <h3 style="color: #566573;">Pelanggaran</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>hrm">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row mt-4">
        <div class="col-md-4">
            <a class="text-decoration-none" href="<?= site_url() ?>hrm-pelanggaran">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">List Pelanggaran</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-book"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="text-decoration-none" href="<?= site_url() ?>hrm-pelanggaran-karyawan">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Pelanggaran Karyawan</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-book-open"></i>
                    </div>
                </div>
            </a>
        </div>
</main>


<?= $this->endSection() ?>