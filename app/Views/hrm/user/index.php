<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">
    <h3 style="color: #566573;">Pengaturan User dan Group</h3>

    <hr>

    <div class="row mt-4">
        <div class="col-md-4">
            <a class="text-decoration-none" href="<?= site_url() ?>hrm-user-group-view">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">User Group</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-user-group"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="text-decoration-none" href="<?= site_url() ?>hrm-user-permission-view">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">User Permission</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-regular fa-circle-check"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="text-decoration-none" href="<?= site_url() ?>hrm-group-permission-view">
                <div class="card mb-3 shadow" style="border: 1px solid #1762A5;">
                    <h5 class="card-header" style="background-color: #1762A5; color: #fff;">Group Permission</h5>
                    <div class="card-body text-secondary">
                        <i class="fa-3x fa-solid fa-users-rectangle"></i>
                    </div>
                </div>
            </a>
        </div>
</main>


<?= $this->endSection() ?>