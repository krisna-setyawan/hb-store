<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Data Perusahaan Haebot</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>data-master">
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
                    <th class="text-center" width="10%">ID</th>
                    <th class="text-center" width="26%">Nama</th>
                    <th class="text-center" width="36%">Alamat</th>
                    <th class="text-center" width="15%">No Telp</th>
                    <th class="text-center" width="8%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php foreach ($perusahaan as $sp) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $sp['id_perusahaan'] ?></td>
                        <td><?= $sp['nama'] ?></td>
                        <td><?= $sp['alamat'] ?></td>
                        <td><?= $sp['no_telp'] ?></td>
                        <td class="text-center">
                            <?php if ($_ENV['ID_PERUSAHAAN'] != $sp['id_perusahaan']) { ?>
                                <a href="<?= site_url() ?>resource-perusahaan-produk/<?= $sp['id_perusahaan'] ?>" class="btn btn-sm btn-outline-primary"> Produk &nbsp;<i class="fa-fw fa-solid fa-list-ul"></i></a>
                            <?php } ?>
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

        // Alert
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }
    });
</script>

<?= $this->endSection() ?>