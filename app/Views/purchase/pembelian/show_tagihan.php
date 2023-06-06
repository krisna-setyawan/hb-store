<div class="mb-4 d-flex justify-content-between">
    <div>
        <h6><?= $pembelian['supplier'] ?></h6>
        <h6>Telp : <?= $pembelian['telp_supplier'] ?></h6>
    </div>
    <div>
        <button class="btn btn-sm btn-outline-success" onclick="showModalTambahTagihan(<?= $pembelian['id'] ?>, '<?= $pembelian['no_pembelian'] ?>')">Tambah Tagihan <i class="fa-solid fa-plus"></i></button>
    </div>
</div>

<?php
$no = 1;
foreach ($tagihan as $t) : ?>

    <div class="card mb-3" style="border: #336475 1px solid;">
        <div class="card-header" style="background-color: #C0FDFF;">
            <div class="d-flex justify-content-between">
                Tagihan <?= $no++ ?>
                <b> <?= $t['no_tagihan'] ?> </b>
            </div>
        </div>
        <div class="card-body" style="border-top: #336475 1px solid; background-color: #F1F8FA;">

            <div class="row mb-2">
                <div class="col-md-2">
                    <div class="fw-bold">Tanggal dibuat</div>
                </div>
                <div class="col-md-8">
                    : <?= $t['tanggal'] ?>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-2">
                    <div class="fw-bold">Jumlah Tagihan</div>
                </div>
                <div class="col-md-8">
                    : Rp. <?= number_format($t['jumlah'], 0, ',', '.') ?>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-2">
                    <div class="fw-bold">Status</div>
                </div>
                <div class="col-md-8">
                    : <?= $t['status'] ?>
                </div>
            </div>

            <div class="accordion mt-4" id="accordion_<?= $t['id'] ?>">
                <div class="accordion-item">
                    <button style="background-color: #34A6CD;" class="text-light accordion-button collapsed p-2" onclick="show_rincian(<?= $t['id'] ?>)" type="button" data-bs-toggle="collapse" data-bs-target="#rincian_tagihan_<?= $t['id'] ?>" aria-expanded="false" aria-controls="rincian_tagihan_<?= $t['id'] ?>">
                        Rincian Tagihan
                    </button>
                    <div id="rincian_tagihan_<?= $t['id'] ?>" class="accordion-collapse collapse">
                        <div class="accordion-body" id="body-rincian-<?= $t['id'] ?>"></div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button style="background-color: #34A6CD;" class="text-light accordion-button collapsed p-2" onclick="show_pembayaran(<?= $t['id'] ?>)" type="button" data-bs-toggle="collapse" data-bs-target="#lihat_pembayaran_<?= $t['id'] ?>" aria-expanded="false" aria-controls="lihat_pembayaran_<?= $t['id'] ?>">
                        Lihat Pembayaran
                    </button>
                    <div id="lihat_pembayaran_<?= $t['id'] ?>" class="accordion-collapse collapse">
                        <div class="accordion-body" id="body-pembayaran-<?= $t['id'] ?>"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <br>

<?php endforeach; ?>


<script>
    function show_rincian(id_tagihan) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>purchase-show_rincian_tagihan/' + id_tagihan,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#body-rincian-' + id_tagihan).html(res.data);
                } else {
                    console.log(res)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }

    function show_pembayaran(id_tagihan) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>purchase-show_pembayaran_tagihan/' + id_tagihan,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#body-pembayaran-' + id_tagihan).html(res.data);
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