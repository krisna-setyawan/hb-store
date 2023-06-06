<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>hrm-rekrutmen" method="POST" id="form">

    <?= csrf_field() ?>

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name="nama" autofocus>
            <div class="invalid-feedback error-nama"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="no_telp" class="col-sm-3 col-form-label">No Telepon</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="no_telp" name="no_telp" autofocus>
            <div class="invalid-feedback error-no_telp"></div>
        </div>
    </div>

    <div class="col-md-9 offset-3 mb-3">
        <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
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
                    if (err.error_nama) {
                        $('.error-nama').html(err.error_nama);
                        $('#nama').addClass('is-invalid');
                    } else {
                        $('.error-nama').html('');
                        $('#nama').removeClass('is-invalid');
                        $('#nama').addClass('is-valid');
                    }
                    if (err.error_no_telp) {
                        $('.error-no_telp').html(err.error_no_telp);
                        $('#no_telp').addClass('is-invalid');
                    } else {
                        $('.error-no_telp').html('');
                        $('#no_telp').removeClass('is-invalid');
                        $('#no_telp').addClass('is-valid');
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