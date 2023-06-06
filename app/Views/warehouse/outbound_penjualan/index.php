<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Outbound Penjualan <?= $nama_gudang ?></h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>warehouse-outbound/<?= $id_gudang ?>">
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
                    <th class="text-center" width="13%">No Penjualan</th>
                    <th class="text-center" width="10%">Tanggal</th>
                    <th class="text-center" width="47%">Customer</th>
                    <th class="text-center" width="15%">Status Outbound</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</main>

<?= $this->include('MyLayout/js') ?>



<!-- Modal -->
<div class="modal fade" id="my-modal-show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalShow"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiShow">

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
        $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= site_url() ?>warehouse-getDataPenjualan',
            order: [],
            columns: [{
                    data: 'no',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'no_penjualan',
                },
                {
                    data: 'tanggal',
                },
                {
                    data: 'customer',
                },
                {
                    data: 'status_outbound',
                },
                {
                    data: 'aksi',
                    orderable: false,
                    className: 'text-center'
                }
            ]
        });

        // Alert
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }
    });

    function showModalOutbound(id_penjualan) {
        $.ajax({
            type: "get",
            url: "<?= site_url() ?>warehouse-get_list_outbound_penjualan/" + id_penjualan,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#isiShow').html(response.data)
                    $('#judulModalShow').html('List Outbound')
                    $('#my-modal-show').modal('toggle')
                } else {
                    console.log(response)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }
</script>

<?= $this->endSection() ?>