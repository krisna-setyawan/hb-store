<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">List Pelanggaran</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>hrm-menu-pelanggaran">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="mb-1">
            <a class="btn btn-sm btn-outline-secondary mb-3" id="tombolTambah">
                <i class="fa-fw fa-solid fa-plus"></i> Tambah Pelanggaran
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="4%">No</th>
                    <th class="text-center" width="78%">Nama Pelanggaran</th>
                    <th class="text-center" width="10%">Range Point</th>
                    <th class="text-center" width="8%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php foreach ($pelanggaran as $plg) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $plg['nama_pelanggaran'] ?></td>
                        <td><?= $plg['range_point'] ?></td>
                        <td class="text-center">

                            <a title="Edit" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="showModalEdit(<?= $plg['id'] ?>)">
                                <i class="fa-fw fa-solid fa-pen"></i>
                            </a>

                            <form id="form_delete" method="POST" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                            <button onclick="confirm_delete(<?= $plg['id'] ?>)" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
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
                <h1 class="modal-title fs-5" id="judulModal"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiForm">

            </div>
        </div>
    </div>
</div>
<!-- Modal -->

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
        showModalTambah();
    })

    function showModalTambah() {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>hrm-pelanggaran/new',
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiForm').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('#judulModal').html('Tambah Pelanggaran')
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }

    function showModalEdit(id) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>hrm-pelanggaran/' + id + '/edit',
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiForm').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('#judulModal').html('Edit Pelanggaran')
                    console.log(res.data)
                } else {
                    console.log("error")
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }


    function confirm_delete(id) {
        Swal.fire({
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_delete').attr('action', '<?= site_url() ?>hrm-pelanggaran/' + id);
                $('#form_delete').submit();
            }
        })
    }
</script>

<?= $this->endSection() ?>