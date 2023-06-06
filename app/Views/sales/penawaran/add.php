<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>sales-penawaran" method="POST" id="form">

    <?= csrf_field() ?>

    <div class="row mb-3">
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
    <div class="row mb-3">
        <label for="id_customer" class="col-sm-3 col-form-label">Customer</label>
        <div class="col-sm-9">
            <select class="form-control" name="id_customer" id="id_customer">
                <option value="">Pilih Customer</option>
                <?php foreach ($customer as $up) : ?>
                    <option value="<?= $up['id'] ?>"><?= $up['nama'] ?></option>
                <?php endforeach ?>
            </select>
            <div class="invalid-feedback error-id_customer"></div>
        </div>
    </div>

    <div class="text-center mb-3">
        <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit">Lanjutkan <i class="fa-fw fa-solid fa-arrow-right"></i></button>
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
                    if (err.error_id_customer) {
                        $('.error-id_customer').html(err.error_id_customer);
                        $('#id_customer').addClass('is-invalid');
                    } else {
                        $('.error-id_customer').html('');
                        $('#id_customer').removeClass('is-invalid');
                        $('#id_customer').addClass('is-valid');
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
        $("#id_customer").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#my-modal')
        });

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