<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>hrm-rekrutmen/<?= $karyawan['id'] ?>" method="POST" id="form-edit">

    <?= csrf_field() ?>

    <input type="hidden" name="_method" value="PUT">

    <div class="row mb-3">
        <label for="nik" class="col-sm-3 col-form-label">Nik</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="nik" name="nik" value="<?= $karyawan['nik']; ?>">
            <div class="invalid-feedback error-nik"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $karyawan['nama']; ?>">
            <div class="invalid-feedback error-nama"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $karyawan['alamat']; ?>">
            <div class="invalid-feedback error-alamat"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-9">
            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                <option value="<?= $karyawan['jenis_kelamin']; ?>"><?= $karyawan['jenis_kelamin']; ?></option>
                <option value="LAKI-LAKI">Laki-Laki</option>
                <option value="PEREMPUAN">Perempuan</option>
            </select>
            <div class="invalid-feedback error-jenis_kelamin"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $karyawan['tempat_lahir']; ?>">
            <div class="invalid-feedback error-tempat_lahir"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $karyawan['tanggal_lahir']; ?>">
            <div class="invalid-feedback error-tanggal_lahir"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="agama" class="col-sm-3 col-form-label">Agama</label>
        <div class="col-sm-9">
            <select class="form-control" name="agama" id="agama">
                <option value="<?= $karyawan['agama']; ?>"><?= $karyawan['agama']; ?></option>
                <option value="ISLAM">Islam</option>
                <option value="KATOLIK">Katolik</option>
                <option value="KRISTEN">Kristen</option>
                <option value="HINDU">Hindu</option>
                <option value="BUDHA">Budha</option>
                <option value="KHONGHUCU">Khonghucu</option>
            </select>
            <div class="invalid-feedback error-agama"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="pendidikan" class="col-sm-3 col-form-label">Pendidikan</label>
        <div class="col-sm-9">
            <select class="form-control" name="pendidikan" id="pendidikan">
                <option value="<?= $karyawan['pendidikan']; ?>"><?= $karyawan['pendidikan']; ?></option>
                <option value="SD">SD</option>
                <option value="SMP">SMP</option>
                <option value="SMA/SMK">SMA/SMK</option>
                <option value="D I">D I</option>
                <option value="D II">D II</option>
                <option value="D II">D III</option>
                <option value="D IV/S I">D IV/S1</option>
            </select>
            <div class="invalid-feedback error-pendidikan"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="no_telp" class="col-sm-3 col-form-label">No Telepon</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="no_telp" name="no_telp" value="<?= $karyawan['no_telp']; ?>">
            <div class="invalid-feedback error-no_telp"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="email" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="email" name="email" value="<?= $karyawan['email']; ?>">
            <div class="invalid-feedback error-email"></div>
        </div>
    </div>

    <div class="col-md-9 offset-3 mb-3">
        <button id="#tombolUpdate" class="btn px-5 btn-outline-primary" type="submit">Update<i class="fa-fw fa-solid fa-check"></i></button>
    </div>
</form>

<?= $this->include('MyLayout/js') ?>


<script>
    $('#form-edit').submit(function(e) {
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
                    if (err.error_email) {
                        $('.error-email').html(err.error_email);
                        $('#email').addClass('is-invalid');
                    } else {
                        $('.error-email').html('');
                        $('#email').removeClass('is-invalid');
                        $('#email').addClass('is-valid');
                    }
                }
                if (response.success) {
                    $('#my-modal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                    }).then((value) => {
                        location.reload();
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
        $("#pendidikan").select2({
            theme: "bootstrap-5",
            tags: true,
            dropdownParent: $('#my-modal')
        });
        $('#tanggal_lahir').datepicker({
            format: "yyyy-mm-dd"
        });
    })
</script>