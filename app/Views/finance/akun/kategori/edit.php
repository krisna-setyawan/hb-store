<form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>finance-KategoriAkun/<?= $kategori['id'] ?>" method="POST" id="form">

    <?= csrf_field() ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Nama Kategori Akun</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $kategori['nama']; ?>">
            <div class="invalid-feedback error_nama"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= $kategori['deskripsi']; ?>">
            <div class="invalid-feedback error_deskripsi"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="satuan" class="col-sm-3 col-form-label">Debit</label>
        <div class="col-sm-9">
            <select class="form-control" name="debit" id="debit">
                <option value=""></option>
                <option <?= $kategori['debit'] == "1" ? 'selected' : ''; ?> value="1">Plus</option>
                <option <?= $kategori['debit'] == "-1" ? 'selected' : ''; ?> value="-1">Minus</option>
            </select>
            <div class="invalid-feedback error_debit"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="satuan" class="col-sm-3 col-form-label">Kredit</label>
        <div class="col-sm-9">
            <select class="form-control" name="kredit" id="kredit">
                <option value=""></option>
                <option <?= $kategori['kredit'] == "1" ? 'selected' : ''; ?> value="1">Plus</option>
                <option <?= $kategori['kredit'] == "-1" ? 'selected' : ''; ?> value="-1">Minus</option>
            </select>
            <div class="invalid-feedback error_kredit"></div>
        </div>
    </div>

    <div class="text-center">
        <a class="btn px-5 btn-outline-danger" data-bs-dismiss="modal">Batal
            <i class="fa-fw fa-solid fa-xmark"></i>
        </a>
        <button id="#tombolUpdate" class="btn px-5 btn-outline-primary" type="submit">Update<i class="fa-fw fa-solid fa-check"></i></button>
    </div>
</form>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $('#debit').change(function() {
            let debit = $(this).val();

            if (debit == '1') {
                $('#kredit').html('<option value="1">Plus</option><option selected value="-1">Minus</option>');
            } else {
                $('#kredit').html('<option selected value="1">Plus</option><option value="-1">Minus</option>');
            }
        })

        $('#kredit').change(function() {
            let kredit = $(this).val();

            if (kredit == '1') {
                $('#debit').html('<option value="1">Plus</option><option selected value="-1">Minus</option>');
            } else {
                $('#debit').html('<option selected value="1">Plus</option><option value="-1">Minus</option>');
            }
        })
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

                    if (err.error_nama) {
                        $('.error_nama').html(err.error_nama);
                        $('#nama').addClass('is-invalid');
                    } else {
                        $('.error_nama').html('');
                        $('#nama').removeClass('is-invalid');
                        $('#nama').addClass('is-valid');
                    }
                    if (err.error_deskripsi) {
                        $('.error_deskripsi').html(err.error_deskripsi);
                        $('#deskripsi').addClass('is-invalid');
                    } else {
                        $('.error_deskripsi').html('');
                        $('#deskripsi').removeClass('is-invalid');
                        $('#deskripsi').addClass('is-valid');
                    }
                    if (err.error_debit) {
                        $('.error_debit').html(err.error_debit);
                        $('#debit').addClass('is-invalid');
                    } else {
                        $('.error_debit').html('');
                        $('#debit').removeClass('is-invalid');
                        $('#debit').addClass('is-valid');
                    }
                    if (err.error_debit) {
                        $('.error_kredit').html(err.error_kredit);
                        $('#kredit').addClass('is-invalid');
                    } else {
                        $('.error_kredit').html('');
                        $('#kredit').removeClass('is-invalid');
                        $('#kredit').addClass('is-valid');
                    }

                }
                if (response.success) {
                    $('#my-modal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.success
                    });
                    location.href = "<?= base_url() ?>/finance-kategori";
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false
    })
</script>