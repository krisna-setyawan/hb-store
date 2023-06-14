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
            <h3 style="color: #566573;">List Produk Outbound Penjualan</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>warehouse-outboundPenjualan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row mt-3 mb-4">
        <div class="col-md-2">
            <label for="tanggal" class="form-label mb-0">Tanggal</label>
            <input type="text" class="form-control" name="tanggal" id="tanggal" readonly value="<?= $outbound_penjualan['tanggal'] ?>">
        </div>
        <div class="col-md-2">
            <label for="no_outbound" class="form-label mb-0">No Outbound</label>
            <input type="text" class="form-control" name="no_outbound" id="no_outbound" readonly value="<?= $outbound_penjualan['no_outbound'] ?>">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead style="background-color: #52BE80;" class="text-center border-secondary">
                <tr>
                    <th class="text-center" width="4%">#</th>
                    <th class="text-center" width="31%">Produk</th>
                    <th class="text-center" width="13%">Stok Gudang</th>
                    <th class="text-center" width="13%">Qty Beli</th>
                    <th class="text-center" width="13%">Sudah Dikirim</th>
                    <th class="text-center" width="13%">Dikirim Sekarang</th>
                    <th class="text-center" width="13%">Kurang</th>
                </tr>
            </thead>
            <tbody id="tabel_list_produk">
                <?php
                $no = 1;
                foreach ($outbound_penjualan_detail as $produk) :
                ?>

                    <?php
                    if ($produk['stok'] < $produk['qty_beli']) {
                        $this_stok_kurang = true;
                    } else {
                        $this_stok_kurang = false;
                    }
                    ?>

                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $produk['produk'] ?></td>
                        <td class="text-center <?= ($this_stok_kurang == true) ? 'fw-bold text-danger' : '' ?>"><?= $produk['stok'] ?></td>
                        <td class="text-center"><?= $produk['qty_beli'] ?></td>
                        <td class="text-center"><?= $produk['qty_dikirim_sebelumnya'] ?></td>
                        <td class="text-center" style="cursor: pointer; color: #C0392B;" onclick="produk_dikirim(<?= $produk['id'] ?>, '<?= $produk['produk'] ?>', <?= $produk['qty_beli'] ?>, <?= $produk['qty_dikirim_sebelumnya'] ?>, <?= $produk['stok'] ?>)">
                            <b>
                                <?= $produk['qty_dikirim_sekarang'] ?>
                            </b>
                        </td>
                        <td class="text-center"><?= $produk['qty_kurang'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <hr>

    <form autocomplete="off" action="<?= site_url() ?>warehouse-simpan_outbound/<?= $outbound_penjualan['id'] ?>" method="POST" id="formSelesai">

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="jasa_kirim" class="form-label">Jasa Kirim</label>
                    <input type="text" class="form-control" id="jasa_kirim" name="jasa_kirim" value="<?= $penjualan['jasa_kirim'] ?>">
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="ongkir" class="form-label">Ongkir</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text px-2">Rp. </span>
                        <input type="text" class="form-control triger-hitung-total" id="ongkir" name="ongkir" value="<?= number_format($penjualan['ongkir'], 0, ',', '.') ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="text-start d-flex mt-2">
            <a class="btn px-5 btn btn-outline-dark me-2" href="<?= site_url() ?>warehouse-outboundPenjualan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
            <input type="hidden" class="form-control" name="id_outbound_penjualan" id="id_outbound_penjualan" value="<?= $outbound_penjualan['id'] ?>">
            <button id="tombolSimpan" type="button" class="btn px-5 btn-outline-primary">Simpan<i class="fa-fw fa-solid fa-check"></i></button>
        </div>
    </form>

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
                    <input type="hidden" id="no_outbound" name="no_outbound" value="<?= $outbound_penjualan['no_outbound'] ?>">

                    <div class="mb-3">
                        <label for="qty_beli" class="form-label mb-2">Qty Beli</label>
                        <input readonly type="text" class="form-control" id="qty_beli" name="qty_beli">
                    </div>

                    <div class="mb-3">
                        <label for="qty_dikirim_sebelumnya" class="form-label mb-2">Sudah Dikirim</label>
                        <input readonly type="text" class="form-control" id="qty_dikirim_sebelumnya" name="qty_dikirim_sebelumnya">
                    </div>

                    <div class="mb-3">
                        <label for="qty_stok" class="form-label mb-2">Stok di Gudang</label>
                        <input readonly type="text" class="form-control" id="qty_stok" name="qty_stok">
                    </div>

                    <div class="mb-3">
                        <label for="qty_dikirim_sekarang" class="form-label mb-2">Dikirim</label>
                        <input type="number" class="form-control" name="qty_dikirim_sekarang" id="qty_dikirim_sekarang" required>
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
        $('#ongkir').mask('000.000.000.000', {
            reverse: true
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

    function produk_dikirim(id, produk, qty_beli, qty_dikirim_sebelumnya, qty_stok) {
        $('#form-update').attr('action', '<?= site_url() ?>warehouse-update_detail_outpenjualan/' + id);
        $('#qty_beli').val(qty_beli);
        $('#qty_dikirim_sebelumnya').val(qty_dikirim_sebelumnya);
        $('#qty_stok').val(qty_stok);
        $('#nama_produk').html(produk);
        $('#judulModal').html('Jumlah Produk dikirim');
        $('#my-modal').modal('toggle');
        $('#qty_dikirim_sekarang').focus();
    }


    function validasi_form_update() {
        if ($('#qty_dikirim_sekarang').val() == '') {
            Swal.fire(
                'Opss.',
                'Jumlah produk yang dikirim belum diisi.',
                'error'
            )
        } else if ((parseInt($('#qty_dikirim_sekarang').val()) + parseInt($('#qty_dikirim_sebelumnya').val())) > parseInt($('#qty_beli').val())) {
            Swal.fire(
                'Opss.',
                'Jumlah produk yang dikirim lebih dari jumlah yang dibeli. gak bahaya ta?',
                'error'
            )
        } else if (parseInt($('#qty_dikirim_sekarang').val()) > parseInt($('#qty_stok').val())) {
            Swal.fire(
                'Opss.',
                'Jumlah produk yang dikirim lebih dari jumlah yang ada digudang. gak bahaya ta?',
                'error'
            )
        } else {
            $('#form-update').submit();
        }
    }




    $('#tombolSimpan').click(function() {
        let id_outbound_penjualan = '<?= $outbound_penjualan['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>warehouse-validasi_simpan_outbound_penjualan",
            data: 'id_outbound_penjualan=' + id_outbound_penjualan,
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    Swal.fire({
                        title: 'Konfirmasi?',
                        text: "Apakah yakin menyimpan data Outbound dan update stock produk?",
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
                        'Belum ada produk yang di inputkan jumlah dikirim sekarang!',
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