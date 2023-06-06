<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>hrm-pelanggaran" method="POST" id="form">
    <?= csrf_field() ?>

    <div class="row mb-3">
        <label for="nama_pelanggaran" class="col-sm-4 col-form-label">Nama Pelanggaran</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="nama_pelanggaran" name="nama_pelanggaran" autofocus>
            <div class="invalid-feedback error-nama_pelanggaran"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="range_point" class="col-sm-4 col-form-label">Range Point Pelanggaran</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="range_point" name="range_point" autofocus placeholder="contoh : (10-100)">
            <div class="invalid-feedback error-range_point"></div>
        </div>
    </div>

    <div class="col-md-9 offset-3 mb-3">
        <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit">Simpan<i class="fa-fw fa-solid fa-check"></i></button>
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
                    if (err.error_nama_pelanggaran) {
                        $('.error-nama_pelanggaran').html(err.error_nama_pelanggaran);
                        $('#nama_pelanggaran').addClass('is-invalid');
                    } else {
                        $('.error-nama_pelanggaran').html('');
                        $('#nama_pelanggaran').removeClass('is-invalid');
                        $('#nama_pelanggaran').addClass('is-valid');
                    }
                    if (err.error_range_point) {
                        $('.error-range_point').html(err.error_range_point);
                        $('#range_point').addClass('is-invalid');
                    } else {
                        $('.error-range_point').html('');
                        $('#range_point').removeClass('is-invalid');
                        $('#range_point').addClass('is-valid');
                    }
                }
                if (response.success) {
                    $('#my-modal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                    }).then((value) => {
                        location.reload()
                    })
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false
    })
</script>