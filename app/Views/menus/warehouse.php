<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">
    <h3 class="ms-3" style="color: #566573;">Warehouse</h3>

    <hr>

    <?php foreach ($list_gudang_user as $list_gudang) : ?>
        <div class="mb-4">
            <h5 class="ms-3"><?= $list_gudang['nama_gudang'] ?></h5>

            <div class="row mt-4">
                <div class="col-md-4 mb-3 px-4">
                    <a class="text-decoration-none" href="<?= base_url() ?>/warehouse-produk/<?= $list_gudang['id_gudang'] ?>">
                        <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                            <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Produk</h5>
                            <div class="card-body text-secondary">
                                <i class="fa-3x fa-solid fa-list"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3 px-4">
                    <a class="text-decoration-none" href="<?= base_url() ?>/warehouse-ruangan-rak/<?= $list_gudang['id_gudang'] ?>">
                        <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                            <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Ruangan & Rak</h5>
                            <div class="card-body text-secondary">
                                <i class="fa-3x fa-solid fa-list"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3 px-4">
                    <a class="text-decoration-none" href="<?= base_url() ?>/warehouse-stockopname/<?= $list_gudang['id_gudang'] ?>">
                        <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                            <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Stock Opname</h5>
                            <div class="card-body text-secondary">
                                <i class="fa-3x fa-solid fa-list"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3 px-4">
                    <a class="text-decoration-none" href="<?= base_url() ?>/warehouse-inbound/<?= $list_gudang['id_gudang'] ?>">
                        <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                            <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Inbound</h5>
                            <div class="card-body text-secondary">
                                <i class="fa-3x fa-solid fa-list"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3 px-4">
                    <a class="text-decoration-none" href="<?= base_url() ?>/warehouse-outbound/<?= $list_gudang['id_gudang'] ?>">
                        <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                            <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Outbound</h5>
                            <div class="card-body text-secondary">
                                <i class="fa-3x fa-solid fa-list"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</main>

<?= $this->include('MyLayout/js') ?>

<?= $this->endSection() ?>