<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>hrm-list/create" method="POST" id="form">

    <?= csrf_field() ?>

    <div class="row mb-3">
        <label for="karyawan" class="col-sm-3 col-form-label">Nama Karyawan</label>
        <div class="col-sm-9">
            <select class="form-control" name="karyawan" id="karyawan">
                <option value=""></option>
                <?php foreach ($karyawan as $karyawan) : ?>
                    <option value="<?= $karyawan['id'] ?>"><?= $karyawan['nama_lengkap'] ?></option>
                <?php endforeach ?>
            </select>
            <div class="invalid-feedback error-karyawan"></div>
        </div>
    </div>
    <input type="hidden" name="id_divisi" value="<?= $divisi['id'] ?>">

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

                    if (err.error_karyawan) {
                        $('.error-karyawan').html(err.error_karyawan);
                        $('#karyawan').addClass('is-invalid');
                    } else {
                        $('.error-karyawan').html('');
                        $('#karyawan').removeClass('is-invalid');
                        $('#karyawan').addClass('is-valid');
                    }
                    if (err.error_divisi) {
                        $('.error-divisi').html(err.error_divisi);
                        $('#divisi').addClass('is-invalid');
                    } else {
                        $('.error-divisi').html('');
                        $('#divisi').removeClass('is-invalid');
                        $('#divisi').addClass('is-valid');
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
        $("#karyawan").select2({
            theme: "bootstrap-5",
            tags: true,
            dropdownParent: $('#my-modal')
        });

        $("#divisi").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#my-modal')
        });
    })
</script>