<div class="mb-4 d-flex justify-content-between">
    <div>
        <h6><?= $penjualan['customer'] ?></h6>
        <h6>Telp : <?= $penjualan['telp_customer'] ?></h6>
    </div>
    <div>
        <?php if ($penjualan['status_outbound'] != 'Dikirim Semua') { ?>
            <?php if ($hasSavedStatus == false) { ?>
                <a href="<?= site_url() ?>warehouse-do_outbound_penjualan/ <?= $penjualan['id'] ?>">
                    <button class="btn btn-sm btn-outline-success">
                        Tambah Outbound <i class="fa-fw fa-solid fa-arrow-turn-down"></i>
                    </button>
                </a>
            <?php } else { ?>
                <button class="btn btn-sm btn-outline-success" onclick="error_tambah_outbound()">
                    Tambah Outbound <i class="fa-fw fa-solid fa-arrow-turn-down"></i>
                </button>
            <?php } ?>
        <?php } ?>
    </div>
</div>

<?php
if ($outbound_penjualan) {
    $no = 1;
    foreach ($outbound_penjualan as $t) : ?>

        <div class="card mb-3" style="border: #F8C471 1px solid;">
            <div class="card-header" style="background-color: #F8C471;">
                <div class="d-flex justify-content-between">
                    Outbound <?= $no++ ?>
                    <b> <?= $t['no_outbound'] ?> </b>
                </div>
            </div>
            <div class="card-body" style="border-top: #F8C471 1px solid; background-color: #F1F8FA;">

                <div class="row px-2 mb-0">
                    <div class="col-md-10">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="fw-bold">Tanggal</div>
                            </div>
                            <div class="col-md-8">
                                : <?= $t['tanggal'] ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="fw-bold">Gudang</div>
                            </div>
                            <div class="col-md-8">
                                : <?= $t['gudang'] ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="fw-bold">Penanggung Jawab</div>
                            </div>
                            <div class="col-md-8">
                                : <?= $t['pj'] ?>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <div class="fw-bold">Status</div>
                            </div>
                            <div class="col-md-8">
                                : <?= ($t['status_simpan'] != 'Saved') ? 'Belum disimpan' : 'Saved' ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($t['status_simpan'] != 'Saved' && $id_gudang == $t['id_gudang']) { ?>
                        <div class="col-md-2 text-end mb-0">
                            <a href="<?= site_url() ?>warehouse-detail_outbound_penjualan/<?= $t['no_outbound'] ?>">
                                <button class="btn btn-danger mb-1"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <div class="accordion mt-3" id="accordion_<?= $t['id'] ?>">
                    <div class="accordion-item">
                        <button style="background-color: #7F8C8D;" class="text-light accordion-button collapsed p-2" onclick="show_detail_outbound(<?= $t['id'] ?>)" type="button" data-bs-toggle="collapse" data-bs-target="#detail_outbound_<?= $t['id'] ?>" aria-expanded="false" aria-controls="detail_outbound_<?= $t['id'] ?>">
                            Detail Outbound
                        </button>
                        <div id="detail_outbound_<?= $t['id'] ?>" class="accordion-collapse collapse">
                            <div class="accordion-body" id="body-detail-<?= $t['id'] ?>"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <br>

    <?php
    endforeach;
} else { ?>
    <div class="text-center"> <b> Belum ada data Outbound. </b> </div>
<?php } ?>


<script>
    function show_detail_outbound(id_outbound_penjualan) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>warehouse-show_detail_outbound/' + id_outbound_penjualan,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#body-detail-' + id_outbound_penjualan).html(res.data);
                } else {
                    console.log(res)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }

    function error_tambah_outbound() {
        Swal.fire(
            'Oopss!',
            'masih ada Outbound yang belum disimpan, silahkan dilanjutkan dan disimpan dulu!',
            'error'
        )
    }
</script>