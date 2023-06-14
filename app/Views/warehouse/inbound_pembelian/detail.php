<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">List Produk Inbound Pembelian</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>warehouse-inboundPembelian">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row mt-3 mb-4">
        <div class="col-md-2">
            <label for="tanggal" class="form-label mb-0">Tanggal</label>
            <input type="text" class="form-control" name="tanggal" id="tanggal" readonly value="<?= $inbound_pembelian['tanggal'] ?>">
        </div>
        <div class="col-md-2">
            <label for="no_inbound" class="form-label mb-0">No Inbound</label>
            <input type="text" class="form-control" name="no_inbound" id="no_inbound" readonly value="<?= $inbound_pembelian['no_inbound'] ?>">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead style="background-color: #52BE80;" class="text-center border-secondary">
                <tr>
                    <th class="text-center" width="4%">#</th>
                    <th class="text-center" width="36%">Produk</th>
                    <th class="text-center" width="15%">Qty Beli</th>
                    <th class="text-center" width="15%">Sudah Diterima</th>
                    <th class="text-center" width="15%">Diterima Sekarang</th>
                    <th class="text-center" width="15%">Kurang</th>
                </tr>
            </thead>
            <tbody id="tabel_list_produk">
                <?php
                $no = 1;
                foreach ($inbound_pembelian_detail as $produk) :
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $produk['produk'] ?></td>
                        <td class="text-center"><?= $produk['qty_beli'] ?></td>
                        <td class="text-center"><?= $produk['qty_diterima_sebelumnya'] ?></td>
                        <td class="text-center" style="cursor: pointer; color: #C0392B;" onclick="produk_diterima(<?= $produk['id'] ?>, '<?= $produk['produk'] ?>', <?= $produk['qty_beli'] ?>, <?= $produk['qty_diterima_sebelumnya'] ?>)">
                            <b>
                                <?= $produk['qty_diterima_sekarang'] ?>
                            </b>
                        </td>
                        <td class="text-center"><?= $produk['qty_kurang'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-start d-flex mt-2">
        <a class="btn px-5 btn btn-outline-dark me-2" href="<?= site_url() ?>warehouse-inboundPembelian">
            <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
        </a>
        <form autocomplete="off" action="<?= site_url() ?>warehouse-simpan_inbound/<?= $inbound_pembelian['id'] ?>" method="POST" id="formSelesai">
            <input type="hidden" class="form-control" name="id_inbound_pembelian" id="id_inbound_pembelian" value="<?= $inbound_pembelian['id'] ?>">
            <button id="tombolSimpan" type="button" class="btn px-5 btn-outline-primary">Simpan<i class="fa-fw fa-solid fa-check"></i></button>
        </form>
    </div>

</main>


<!-- Modal -->
<div class="modal fade" id="my-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiModal">
                <form method="POST" id="form-update" autocomplete="off">

                    <?= csrf_field() ?>

                    <p class="mb-1">Produk : </p>
                    <p class="mb-4" id="nama_produk"></p>
                    <input type="hidden" id="no_inbound" name="no_inbound" value="<?= $inbound_pembelian['no_inbound'] ?>">

                    <div class="mb-3">
                        <label for="qty_beli" class="form-label mb-2">Qty Beli</label>
                        <input readonly type="text" class="form-control" id="qty_beli" name="qty_beli">
                    </div>

                    <div class="mb-3">
                        <label for="qty_diterima_sebelumnya" class="form-label mb-2">Sudah Diterima</label>
                        <input readonly type="text" class="form-control" id="qty_diterima_sebelumnya" name="qty_diterima_sebelumnya">
                    </div>

                    <div class="mb-3">
                        <label for="qty_diterima_sekarang" class="form-label mb-2">Diterima</label>
                        <input type="number" class="form-control" name="qty_diterima_sekarang" id="qty_diterima_sekarang" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" onclick="validasi_form_update()" type="button">OK <i class="fa-solid fa-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->



<?= $this->include('MyLayout/js') ?>

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

    function produk_diterima(id, produk, qty_beli, qty_diterima_sebelumnya) {
        $('#form-update').attr('action', '<?= site_url() ?>warehouse-update_detail_inbpembelian/' + id);
        $('#qty_beli').val(qty_beli);
        $('#qty_diterima_sebelumnya').val(qty_diterima_sebelumnya);
        $('#nama_produk').html(produk);
        $('#judulModal').html('Jumlah Produk diterima');
        $('#my-modal').modal('toggle');
        $('#qty_diterima_sekarang').focus();
    }


    function validasi_form_update() {
        if ($('#qty_diterima_sekarang').val() == '') {
            Swal.fire(
                'Opss.',
                'Jumlah produk yang diterima belum diisi.',
                'error'
            )
        } else if ((parseInt($('#qty_diterima_sekarang').val()) + parseInt($('#qty_diterima_sebelumnya').val())) > parseInt($('#qty_beli').val())) {
            Swal.fire(
                'Opss.',
                'Jumlah produk yang diterima lebih dari jumlah yang dibeli. gak bahaya ta?',
                'error'
            )
        } else {
            $('#form-update').submit();
        }
    }




    $('#tombolSimpan').click(function() {
        let id_inbound_pembelian = '<?= $inbound_pembelian['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>warehouse-validasi_simpan_inbound_pembelian",
            data: 'id_inbound_pembelian=' + id_inbound_pembelian,
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    Swal.fire({
                        title: 'Konfirmasi?',
                        text: "Apakah yakin menyimpan data inbound dan update stock produk?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lanjut!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#formSelesai').submit();
                        }
                    })
                } else {
                    Swal.fire(
                        'Opss.',
                        'Belum ada produk yang di inputkan jumlah diterima sekarang!',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    })
</script>

<?= $this->endSection() ?>