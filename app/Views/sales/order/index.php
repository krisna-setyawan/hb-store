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
                    <th class="text-center" width="18%">Total</th>
                    <th class="text-center" width="12%">Aksi</th>
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
                        <td>Rp. <?= number_format($ord['grand_total'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <button title="Detail" class="px-2 py-0 btn btn-sm btn-outline-dark" onclick="detailOrder(<?= $ord['kode_trx_api'] ?>, '<?= $ord['id_perusahaan'] ?>')">
                                <i class="fa-fw fa-solid fa-magnifying-glass"></i>
                            </button>
                            <button title="Proses" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="detailOrder(<?= $ord['kode_trx_api'] ?>, '<?= $ord['id_perusahaan'] ?>')">
                                <i class="fa-fw fa-solid fa-arrow-right"></i>
                            </button>
                            <button title="Tolak" class="px-2 py-0 btn btn-sm btn-outline-danger" onclick="detailOrder(<?= $ord['kode_trx_api'] ?>, '<?= $ord['id_perusahaan'] ?>')">
                                <i class="fa-fw fa-solid fa-xmark"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
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
            <div class="modal-body" id="isiModal">

            </div>
        </div>
    </div>
</div>
<!-- Modal -->



<script>
    $(document).ready(function() {
        $('#tabel').dataTable();
    })

    function detailOrder(kode_trx_api, id_perusahaan) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>sales-order/' + kode_trx_api + '/' + id_perusahaan,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#judulModal').html('Detail Order')
                    $('#isiModal').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('.modal-dialog').addClass('modal-xl')
                    $('.modal-dialog').removeClass('modal-lg')
                } else {
                    console.log(res)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }
</script>
<?= $this->endSection() ?>