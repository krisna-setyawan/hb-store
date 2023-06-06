<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>hrm-karyawan-absen/create" method="POST" id="form">
    <?= csrf_field() ?>
    <?php
    $today = date('Y-m-d');
    ?>
    <div class="row mb-3">
        <label for="tanggal_absen" class="col-sm-3 col-form-label">Tanggal</label>
        <div class="col-sm-9">
            <input value="<?php echo $today; ?>" type="text" class="form-control" id="tanggal_absen" name="tanggal_absen" autofocus>
            <div class="invalid-feedback error-tanggal_absen"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="status" class="col-sm-3 col-form-label">Status</label>
        <div class="col-sm-9">
            <select class="form-control" name="status" id="status">
                <option value=""></option>
                <option value="MASUK">Masuk</option>
                <option value="ALFA">Alfa</option>
                <option value="IZIN">Izin</option>
                <option value="LIBUR">Libur</option>
                <option value="WFA">WFA</option>
                <option value="SAKIT">Sakit</option>
            </select>
            <div class="invalid-feedback error-status"></div>
        </div>
    </div>
    </div>
    <input type="hidden" name="karyawan_id" value=<?= $id_karyawan ?>>

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
                    if (err.error_tanggal_absen) {
                        $('.error-tanggal_absen').html(err.error_tanggal_absen);
                        $('#tanggal_absen').addClass('is-invalid');
                    } else {
                        $('.error-tanggal_absen').html('');
                        $('#tanggal_absen').removeClass('is-invalid');
                        $('#tanggal_absen').addClass('is-valid');
                    }
                    if (err.error_status) {
                        $('.error-status').html(err.error_status);
                        $('#status').addClass('is-invalid');
                    } else {
                        $('.error-status').html('');
                        $('#status').removeClass('is-invalid');
                        $('#status').addClass('is-valid');
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


    $(document).ready(function() {

        $('#tanggal_absen').datepicker({
            format: "yyyy-mm-dd"
        })
    })
</script>