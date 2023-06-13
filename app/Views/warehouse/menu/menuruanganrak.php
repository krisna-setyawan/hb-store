<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto">
            <h3 style="color: #566573;">Ruangan dan Rak <?= $nama_gudang ?></h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>warehouse">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row mt-4">
        <div class="col-md-4">
            <a class="text-decoration-none" href="<?= base_url() ?>/warehouse-produkruangan/<?= $id_gudang ?>">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Ruangan</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-list"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="text-decoration-none" href="<?= base_url() ?>/warehouse-produkrak/<?= $id_gudang ?>">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Rak</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-table-cells-large"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>

<?= $this->include('MyLayout/js') ?>

<?= $this->endSection() ?>