<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu div-menu">
            <div class="nav">
                <br>


                <?php if (has_permission('Dashboard')) : ?>
                    <a class="nav-link" href="<?= base_url() ?>/dashboard">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-solid fa-gauge"></i>
                        </div>
                        Dashboard
                    </a>
                <?php endif; ?>

                <?php if (has_permission('Data Master')) : ?>
                    <a class="nav-link" href="<?= base_url() ?>/data-master">
                        <div class="sb-nav-link-icon">
                            <!-- <i class="fa-fw fa-solid fa-fax"></i> -->
                            <i class="fa-fw fa-regular fa-folder-open"></i>
                        </div>
                        Data Master
                    </a>
                <?php endif; ?>

                <?php if (has_permission('SDM')) : ?>
                    <a class="nav-link" href="<?= base_url() ?>/hrm">
                        <div class="sb-nav-link-icon">
                            <!-- <i class="fa-fw fa-solid fa-screwdriver-wrench"></i> -->
                            <i class="fa-fw fa-solid fa-users-gear"></i>
                        </div>
                        HRM
                    </a>
                <?php endif; ?>

                <?php if (has_permission('Keuangan')) : ?>
                    <a class="nav-link" href="<?= base_url() ?>/finance">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-solid fa-money-bill-trend-up"></i>
                        </div>
                        Finance
                    </a>
                <?php endif; ?>

                <?php if (has_permission('Pembelian')) : ?>
                    <a class="nav-link" href="<?= base_url() ?>/purchase">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-solid fa-arrow-turn-down"></i>
                        </div>
                        Purchase
                    </a>
                <?php endif; ?>

                <?php if (has_permission('Penjualan')) : ?>
                    <a class="nav-link" href="<?= base_url() ?>/sales">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-solid fa-arrow-turn-up"></i>
                        </div>
                        Sales
                    </a>
                <?php endif; ?>

                <?php if (has_permission('Gudang')) : ?>
                    <a class="nav-link" href="<?= base_url() ?>/warehouse">
                        <div class="sb-nav-link-icon">
                            <i class="fa-fw fa-solid fa-warehouse"></i>
                        </div>
                        Warehouse
                    </a>
                <?php endif; ?>

            </div>
        </div>
        <div class="sb-sidenav-footer py-1">
            <div class="small">Masuk sebagai :</div>
            <?= user()->name ?>
        </div>
    </nav>
</div>