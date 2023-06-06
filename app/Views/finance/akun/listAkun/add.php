<form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>finance-akun" method="POST" id="form">

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Kode</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="kode" name="kode">
            <div class="invalid-feedback error_kode"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Nama Akun</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name="nama" autofocus>
            <div class="invalid-feedback error_nama"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="satuan" class="col-sm-3 col-form-label">Kategori</label>
        <div class="col-sm-9">
            <select class="form-control" name="id_kategori" id="id_kategori">
                <?php foreach ($kategori as $kt) : ?>
                    <option value="<?= $kt['id'] ?>-krisna-<?= $kt['nama'] ?>"><?= $kt['nama'] ?></option>
                <?php endforeach ?>
            </select>
            <div class="invalid-feedback error_debit"></div>
        </div>
    </div>

    <div class="col-md-9 offset-3 mb-3">
        <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit">Simpan<i class="fa-fw fa-solid fa-check"></i></button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#id_kategori").select2({
            theme: "bootstrap-5",
            tags: true,
            dropdownParent: $('#my-modal')
        });
    })


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

                    if (err.error_kode) {
                        $('.error_kode').html(err.error_kode);
                        $('#kode').addClass('is-invalid');
                    } else {
                        $('.error_kode').html('');
                        $('#kode').removeClass('is-invalid');
                        $('#kode').addClass('is-valid');
                    }
                    if (err.error_nama) {
                        $('.error_nama').html(err.error_nama);
                        $('#nama').addClass('is-invalid');
                    } else {
                        $('.error_nama').html('');
                        $('#nama').removeClass('is-invalid');
                        $('#nama').addClass('is-valid');
                    }
                    if (err.error_debit) {
                        $('.error_debit').html(err.error_nama);
                        $('#id_kategori').addClass('is-invalid');
                    } else {
                        $('.error_debit').html('');
                        $('#id_kategori').removeClass('is-invalid');
                        $('#id_kategori').addClass('is-valid');
                    }
                }
                if (response.success) {
                    $('#my-modal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                    }).then((value) => {
                        location.href = "<?= base_url() ?>/finance-listakun";
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