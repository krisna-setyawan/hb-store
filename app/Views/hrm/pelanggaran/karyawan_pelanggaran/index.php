<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">


    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Nama Karyawan</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>hrm-menu-pelanggaran">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="87%">Nama Karyawan</th>
                    <th class="text-center" width="8%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php foreach ($karyawan as $kar) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $kar['nama_lengkap'] ?></td>
                        <td class="text-center">
                            <a title="List" class="px-2 py-0 btn btn-sm btn-outline-dark" href="<?= site_url() ?>hrm-point-pelanggaran/<?= $kar['id'] ?>">
                                <i class="fa-fw fa-solid fa-list"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tr>

            </tbody>
        </table>
    </div>

</main>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {

        $('#tabel').DataTable();
    });
</script>

<?= $this->endSection() ?>