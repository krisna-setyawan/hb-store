<div class="mb-4 d-flex justify-content-between">
    <div>
        <h6><?= $pembelian['supplier'] ?></h6>
        <h6>Telp : <?= $pembelian['telp_supplier'] ?></h6>
    </div>
</div>

<?php
if ($inbound_pembelian) {
    $no = 1;
    foreach ($inbound_pembelian as $t) : ?>

        <div class="card mb-3" style="border: #F8C471 1px solid;">
            <div class="card-header" style="background-color: #F8C471;">
                <div class="d-flex justify-content-between">
                    Inbound <?= $no++ ?>
                    <b> <?= $t['no_inbound'] ?> </b>
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
                    <?php if ($t['status_simpan'] != 'Saved') { ?>
                        <div class="col-md-2 text-end mb-0">
                            <a href="<?= site_url() ?>purchase-detail_inbound_pembelian/<?= $t['no_inbound'] ?>">
                                <button class="btn btn-danger mb-1"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <div class="accordion mt-3" id="accordion_<?= $t['id'] ?>">
                    <div class="accordion-item">
                        <button style="background-color: #7F8C8D;" class="text-light accordion-button collapsed p-2" onclick="show_detail_inbound(<?= $t['id'] ?>)" type="button" data-bs-toggle="collapse" data-bs-target="#detail_inbound_<?= $t['id'] ?>" aria-expanded="false" aria-controls="detail_inbound_<?= $t['id'] ?>">
                            Detail Inbound
                        </button>
                        <div id="detail_inbound_<?= $t['id'] ?>" class="accordion-collapse collapse">
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
    <div class="text-center"> <b> Belum ada data inbound. </b> </div>
<?php } ?>


<script>
    function show_detail_inbound(id_inbound_pembelian) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>purchase-show_detail_inbound/' + id_inbound_pembelian,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#body-detail-' + id_inbound_pembelian).html(res.data);
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