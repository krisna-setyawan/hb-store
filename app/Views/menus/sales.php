<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">
    <h3 class="ms-3" style="color: #566573;">Sales</h3>

    <hr>

    <div class="row mt-4">
        <div class="col-md-4 mb-3 px-4">
            <a class="text-decoration-none" href="<?= base_url() ?>/sales-penawaran">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Plan Penawaran</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-list"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3 px-4">
            <a class="text-decoration-none" href="<?= base_url() ?>/sales-fixing_penawaran">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Fixing Penawaran</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-list"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3 px-4">
            <a class="text-decoration-none" href="<?= base_url() ?>/sales-penjualan">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Data Penjualan</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-list"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3 px-4">
            <a class="text-decoration-none" href="<?= base_url() ?>/sales-produk">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Produk</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-list"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3 px-4">
            <a class="text-decoration-none" href="<?= base_url() ?>/sales-customer">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Customer</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-list"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>

<?= $this->include('MyLayout/js') ?>

<?= $this->endSection() ?>