<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">User Permission <?= ucwords(strtolower($nama_user)) ?></h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>hrm-user-permission-view">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="mb-1">
            <a class="btn btn-sm btn-outline-secondary mb-3" id="tombolTambah">
                <i class="fa-fw fa-solid fa-plus"></i> Tambah Permission
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="container">
        <div class="row align-items-start">
            <div class="col">
                <div class="">
                    <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="30%">Nama Permission</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            <?php foreach ($user_permission as $us) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $us['name'] ?></td>
                                    <td class="text-center">
                                        <form id="form_delete" method="POST" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                        </form>
                                        <button onclick="confirm_delete(<?= $us['id'] ?>,<?= $id_user ?>)" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger">
                                            <i class="fa-fw fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col">
                <div class="">
                    <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="30%">Nama Permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            <?php foreach ($group_permission as $gp) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $gp['name'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?= $this->include('MyLayout/js') ?>


<!-- Modal -->
<div class="modal fade" id="my-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal">Tambah Permission</h1>
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
        showModalTambah(<?= $id_user ?>);
    })


    function showModalTambah(id) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url() ?>hrm-permission-new',
            data: 'id=' + id,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiForm').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('#judulModal').html('Tambah permission')
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }


    function confirm_delete(permission_id, user_id) {
        Swal.fire({
            backdrop: false,
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_delete').attr('action', '<?= site_url() ?>hrm-user-permission/' + permission_id + '/' + user_id);
                $('#form_delete').submit();
            }
        })
    }
</script>

<?= $this->endSection() ?>