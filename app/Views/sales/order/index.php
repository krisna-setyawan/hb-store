<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Data Order dari Haebot Party</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>sales">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="13%">No Pemesanan</th>
                    <th class="text-center" width="12%">Tanggal</th>
                    <th class="text-center" width="40%">Perusahaan</th>
                    <th class="text-center" width="20%">Total</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($order as $ord) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $ord['no_pemesanan'] ?></td>
                        <td><?= $ord['tanggal'] ?></td>
                        <td><?= $ord['nama_perusahaan'] ?></td>
                        <td><?= $ord['grand_total'] ?></td>
                        <td>
                            <button class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="detailOrder(<?= $ord['grand_total'] ?>)">
                                <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $('#tabel').dataTable();
    })
</script>
<?= $this->endSection() ?>