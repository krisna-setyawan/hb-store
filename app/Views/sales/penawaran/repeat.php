<div class="row mb-2">
    <div class="col-md-3">
        <div class="fw-bold">Tanggal</div>
    </div>
    <div class="col-md-9">
        <?= $penawaran['tanggal'] ?>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-3">
        <div class="fw-bold">Customer</div>
    </div>
    <div class="col-md-9">
        <?= $penawaran['customer'] ?>
    </div>
</div>

<br>


<div class="table-responsive">
    <table class="table table-sm table-bordered" width="100%" id="tabel">
        <thead>
            <tr>
                <th class="text-center" width="5%">#</th>
                <th class="text-center" width="15%">SKU</th>
                <th class="text-center" width="35%">Produk</th>
                <th class="text-center" width="20%">Satuan</th>
                <th class="text-center" width="5%">Qty</th>
                <th class="text-center" width="20%">Total</th>
            </tr>
        </thead>
        <tbody id="tabel_list_produk">
            <?php
            $no = 1;
            foreach ($penawaran_detail as $pr) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $pr['sku'] ?></td>
                    <td><?= $pr['produk'] ?></td>
                    <td>Rp. <?= number_format($pr['harga_satuan'], 0, ',', '.') ?></td>
                    <td><?= $pr['qty'] ?></td>
                    <td>Rp. <?= number_format($pr['total_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fs-5">
                <td colspan="5" class="text-end fw-bold pe-4 py-2">Perkiraan Biaya</td>
                <td class="py-2">Rp. <?= number_format($penawaran['total_harga_produk'], 0, ',', '.')  ?></td>
            </tr>
        </tbody>
    </table>
</div>

<hr>

<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>sales-save_repeat_penawaran" method="POST" id="form">

    <?= csrf_field() ?>
    <div class="row mb-3 mt-4">
        <label for="no_penawaran" class="col-sm-3 col-form-label">Nomor Penawaran</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="no_penawaran" name="no_penawaran" value="<?= $nomor_penawaran_auto ?>">
            <div class="invalid-feedback error-no_penawaran"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
        <div class="col-sm-9">
            <input onchange="ganti_no_penawaran()" type="text" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
            <div class="invalid-feedback error-tanggal"></div>
        </div>
    </div>
    <input type="hidden" name="id_penawaran" value="<?= $penawaran['id'] ?>">

    <div class="text-center mb-3">
        <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit">Buat Penawaran <i class="fa-fw fa-solid fa-arrow-right"></i></button>
    </div>

</form>


<script>
    $('#form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#tombolSimpan').html('Tunggu <i class="fa-solid fa-spin fa-spinner"></i>');
                $('#tombolSimpan').prop('disabled', true);
            },
            complete: function() {
                $('#tombolSimpan').html('Simpan <i class="fa-fw fa-solid fa-check"></i>');
                $('#tombolSimpan').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.error_no_penawaran) {
                        $('.error-no_penawaran').html(err.error_no_penawaran);
                        $('#no_penawaran').addClass('is-invalid');
                    } else {
                        $('.error-no_penawaran').html('');
                        $('#no_penawaran').removeClass('is-invalid');
                        $('#no_penawaran').addClass('is-valid');
                    }
                    if (err.error_tanggal) {
                        $('.error-tanggal').html(err.error_tanggal);
                        $('#tanggal').addClass('is-invalid');
                    } else {
                        $('.error-tanggal').html('');
                        $('#tanggal').removeClass('is-invalid');
                        $('#tanggal').addClass('is-valid');
                    }
                }
                if (response.success) {
                    window.location.replace('<?= site_url() ?>sales-list_penawaran/' + response.no_penawaran);
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false
    })


    $(document).ready(function() {
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });
    })


    function ganti_no_penawaran() {
        let tanggal = $('#tanggal').val()
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-ganti_no_penawaran",
            data: 'tanggal=' + tanggal,
            dataType: "json",
            success: function(response) {
                if (response.no_penawaran) {
                    $('#no_penawaran').val(response.no_penawaran)
                } else {
                    Swal.fire(
                        'Opss.',
                        'Terjadi kesalahan, hubungi IT Support',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }
</script>