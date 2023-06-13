<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Absensi Karyawan</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>hrm">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <form action="<?= site_url('hrm-view-absensi-filter') ?>" method="POST" class="mb-1">
            <div class="input-group input-group-sm" style="width: 320px;">
                <select name="bulan" id="bulan" class="form-select form-select-sm">
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <?php if ($bulan) { ?>
                            <option <?= ($i == $bulan ? 'selected' : '') ?> value="<?= $i ?>"><?= date("F", strtotime("2001-$i-01")) ?></option>
                        <?php } else { ?>
                            <option <?= ($i == date('m') ? 'selected' : '') ?> value="<?= $i ?>"><?= date("F", strtotime("2001-$i-01")) ?></option>
                        <?php } ?>
                    <?php endfor; ?>
                </select>
                <select id="tahun" name="tahun" class="form-select form-select-sm">
                    <?php for ($i = date('Y'); $i >= 2020; $i--) : ?>
                        <?php if ($tahun) { ?>
                            <option <?= ($i == $tahun ? 'selected' : '') ?> value="<?= $i ?>"><?= $i ?></option>
                        <?php } else { ?>
                            <option <?= ($i == date('Y') ? 'selected' : '') ?> value="<?= $i ?>"><?= $i ?></option>
                        <?php } ?>
                    <?php endfor; ?>
                </select>
                <button type="submit" class="btn btn-primary"> <i class="fa-fw fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="70%">Nama Karyawan</th>
                    <th class="text-center" width="15%">Total Menit</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php foreach ($karyawan as $sp) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $sp['nama_lengkap'] ?></td>
                        <td class="text-center"><?= $sp['total_menit'], ' ', 'Menit' ?></td>
                        <td class="text-center">
                            <a title="List" class="px-2 py-0 btn btn-sm btn-outline-danger" href="<?= site_url() ?>hrm-karyawan-absensi/<?= $sp['id'] ?>">
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
    // Bahan Alert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        background: '#EC7063',
        color: '#fff',
        iconColor: '#fff',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })


    $(document).ready(function() {

        $('#tabel').DataTable();
    });
</script>

<?= $this->endSection() ?>