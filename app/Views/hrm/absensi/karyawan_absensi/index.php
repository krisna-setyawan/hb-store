<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Absen Karyawan <?= ucwords(strtolower($karyawan_name)) ?></h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>hrm-absensi">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="mb-1">
            <a class="btn btn-sm btn-outline-secondary mb-3" id="tombolTambah">
                <i class="fa-fw fa-solid fa-plus"></i> Tambah Absensi
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="55%">Tanggal</th>
                    <th class="text-center" width="15%">Status</th>
                    <th class="text-center" width="15%">Total Menit</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php ?>
                <?php foreach ($absen as $absen) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <?php
                        $day = date('l', strtotime($absen['tanggal_absen']));
                        $days = array(
                            'Sunday'    => 'Minggu',
                            'Monday'    => 'Senin',
                            'Tuesday'   => 'Selasa',
                            'Wednesday' => 'Rabu',
                            'Thursday'  => 'Kamis',
                            'Friday'    => 'Jumat',
                            'Saturday'  => 'Sabtu'
                        );
                        ?>

                        <td><?= $days[$day], ', ', $absen['tanggal_absen'] ?></td>
                        <td><?= $absen['status'] ?></td>
                        <td><?= $absen['total_menit'], ' ', 'Menit' ?></td>
                        <td class="text-center">
                            <form id="form_delete" method="POST" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                            <button onclick="confirm_delete()" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger">
                                <i class="fa-fw fa-solid fa-trash"></i>
                            </button>
                            <?php if ($absen['status'] == 'MASUK') : ?>
                                <a title="Log" class="px-2 py-0 btn btn-sm btn-outline-dark" href="<?= site_url() ?>hrm-log-absensi/<?= $karyawan_id['id'] ?>/<?= $absen['ka_id'] ?>">
                                    <i class="fa-fw fa-regular fa-clipboard"></i>
                                </a>
                            <?php else : ?>
                                <a title="Log" class="px-2 py-0 btn btn-sm btn-outline-dark">
                                    <i class="fa-fw fa-regular fa-clipboard" onclick="showAlert()"></i>
                                <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>

</main>

<?= $this->include('MyLayout/js') ?>


<!-- Modal -->
<div class="modal fade" id="my-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal">Tambah user</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiForm">

            </div>
        </div>
    </div>
</div>
<!-- Modal -->


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


    $('#tombolTambah').click(function(e) {
        e.preventDefault();
        showModalTambah(<?= $id_karyawan ?>);
    })


    function showModalTambah(id) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url() ?>hrm-karyawan-absen-new',
            data: 'id=' + id,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiForm').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('#judulModal').html('Tambah Absensi')
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }

    function showAlert() {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Yang bisa mengkakses halaman log absensi hanya karyawan dengan status masuk saja!',
        });
    }
</script>

<?= $this->endSection() ?>