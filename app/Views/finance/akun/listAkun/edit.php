<form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>finance-akun/<?= $akun['id'] ?>" method="POST" id="form">

    <?= csrf_field() ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Kode Akun</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="kode" name="kode" value="<?= $akun['kode'] ?>">
            <div class="invalid-feedback error_kode"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Nama Akun</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $akun['nama'] ?>">
            <div class="invalid-feedback error_nama"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="deskripsi" class="col-sm-3 col-form-label">Kategori Akun</label>
        <div class="col-sm-9">
            <select class="form-control" name="id_kategori" id="id_kategori">
                <?php foreach ($kategori as $kt) : ?>
                    <option <?= (old('id_kategori', $akun['id_kategori']) == $kt['id']) ? 'selected' : ''; ?> value="<?= $kt['id'] ?>-krisna-<?= $kt['nama'] ?>"><?= $kt['nama'] ?></option>
                <?php endforeach ?>
            </select>
            <div class="invalid-feedback error_debit"></div>
        </div>
    </div>

    <div class="text-center">
        <a class="btn px-5 btn-outline-danger" href="<?= site_url() ?>finance-/listakun">Batal
            <i class="fa-fw fa-solid fa-xmark"></i>
        </a>
        <button id="#tombolUpdate" class="btn px-5 btn-outline-primary" type="submit">Update<i class="fa-fw fa-solid fa-check"></i></button>
    </div>
</form>

<?= $this->include('MyLayout/js') ?>

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
                        $('.error_debit').html(err.error_debit);
                        $('#id_kategori').addClass('is-invalid');
                    } else {
                        $('.error_debit').html('');
                        $('#id_kategori').removeClass('is-invalid');
                        $('#id_kategori').addClass('is-valid');
                    }
                }
                if (response.success) {
                    $('#my-modal').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: response.success
                    })
                    location.href = "<?= base_url() ?>/finance-listakun";
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false
    })
</script>