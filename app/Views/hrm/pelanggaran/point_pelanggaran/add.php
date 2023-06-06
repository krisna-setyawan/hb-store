<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>hrm-point-pelanggaran/create" method="POST" id="form">
    <?= csrf_field() ?>

    <div class="row mb-3">
        <label for="tanggal" class="col-sm-3 col-form-label">Tanggal Pelanggaran</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="tanggal" name="tanggal" autofocus>
            <div class="invalid-feedback error-tanggal"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="pelanggaran" class="col-sm-3 col-form-label">Nama Pelanggaran</label>
        <div class="col-sm-9">
            <select class="form-control" name="pelanggaran" id="pelanggaran">
                <option value=""></option>
                <?php foreach ($pelanggaran as $pelanggaran) : ?>
                    <option value="<?= $pelanggaran['id'] ?>"><?= '(', $pelanggaran['range_point'], ' point), ', $pelanggaran['nama_pelanggaran'] ?></option>
                <?php endforeach ?>
            </select>
            <div class="invalid-feedback error_pelanggaran"></div>
        </div>
    </div>
    <div class="row mb-3">
        <label for="point" class="col-sm-3 col-form-label">Point Pelanggaran</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="point" name="point" autofocus placeholder="Diisi Point Pasti. Contoh : 10">
            <div class="invalid-feedback error-point"></div>
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
                    if (err.error_pelanggaran) {
                        $('.error-pelanggaran').html(err.error_pelanggaran);
                        $('#pelanggaran').addClass('is-invalid');
                    } else {
                        $('.error-pelanggaran').html('');
                        $('#pelanggaran').removeClass('is-invalid');
                        $('#pelanggaran').addClass('is-valid');
                    }
                    if (err.error_point) {
                        $('.error-point').html(err.error_point);
                        $('#point').addClass('is-invalid');
                    } else {
                        $('.error-point').html('');
                        $('#point').removeClass('is-invalid');
                        $('#point').addClass('is-valid');
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
    });
    $(document).ready(function() {
        $("#pelanggaran").select2({
            theme: "bootstrap-5",
            tags: true,
            dropdownParent: $('#my-modal')
        });
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });
    })
</script>