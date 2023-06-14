<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Inbound Pembelian <?= $nama_gudang ?></h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>warehouse-inbound/<?= $id_gudang ?>">
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
                    <th class="text-center" width="13%">No Pembelian</th>
                    <th class="text-center" width="10%">Tanggal</th>
                    <th class="text-center" width="47%">Supplier</th>
                    <th class="text-center" width="15%">Status Inbound</th>
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
    $(document).ready(function() {
        $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= site_url() ?>warehouse-getDataPembelian',
            order: [],
            columns: [{
                    data: 'no',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'no_pembelian',
                },
                {
                    data: 'tanggal',
                },
                {
                    data: 'supplier',
                },
                {
                    data: 'status_inbound',
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

    function showModalInbound(id_pembelian) {
        $.ajax({
            type: "get",
            url: "<?= site_url() ?>warehouse-get_list_inbound_pembelian/" + id_pembelian,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#isiShow').html(response.data)
                    $('#judulModalShow').html('List Inbound')
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