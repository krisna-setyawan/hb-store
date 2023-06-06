<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">
    <h3 style="color: #566573;">Outbound <?= $nama_gudang ?></h3>

    <hr>

    <div class="row mt-4">
        <div class="col-md-4">
            <a class="text-decoration-none" href="<?= base_url() ?>/warehouse-outboundPenjualan">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Penjualan</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-list"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="text-decoration-none" href="<?= base_url() ?>/warehouse-outboundStockOpname">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Stock Opname</h5>
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