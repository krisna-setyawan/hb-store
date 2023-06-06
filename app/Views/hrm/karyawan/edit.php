<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>/hrm-karyawan/<?= $karyawan['id'] ?>" method="POST" id="form-edit">

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
        <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?= $karyawan['jabatan']; ?>">
            <div class="invalid-feedback error-nik"></div>
        </div>
    </div>

    <div class="row mb-3">
        <label for="nama_lengkap" class="col-sm-3 col-form-label">Nama Lengkap</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $karyawan['nama_lengkap']; ?>">
            <div class="invalid-feedback error-nama_lengkap"></div>
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
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $karyawan['tanggal_lahir']; ?>">
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
                <option value="SMA / SMK">SMA/SMK</option>
                <option value="D I">D I</option>
                <option value="D II">D II</option>
                <option value="D II">D III</option>
                <option value="D IV / S I">D IV/S1</option>
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

                    if (err.error_nik) {
                        $('.error-nik').html(err.error_nik);
                        $('#nik').addClass('is-invalid');
                    } else {
                        $('.error-nik').html('');
                        $('#nik').removeClass('is-invalid');
                        $('#nik').addClass('is-valid');
                    }
                    if (err.error_nama_lengkap) {
                        $('.error-nama_lengkap').html(err.error_nama_lengkap);
                        $('#nama_lengkap').addClass('is-invalid');
                    } else {
                        $('.error-nama_lengkap').html('');
                        $('#nama_lengkap').removeClass('is-invalid');
                        $('#nama_lengkap').addClass('is-valid');
                    }
                    if (err.error_alamat) {
                        $('.error-alamat').html(err.error_alamat);
                        $('#alamat').addClass('is-invalid');
                    } else {
                        $('.error-alamat').html('');
                        $('#alamat').removeClass('is-invalid');
                        $('#alamat').addClass('is-valid');
                    }
                    if (err.error_jenis_kelamin) {
                        $('.error-jenis_kelamin').html(err.error_jenis_kelamin);
                        $('#jenis_kelamin').addClass('is-invalid');
                    } else {
                        $('.error-jenis_kelamin').html('');
                        $('#jenis_kelamin').removeClass('is-invalid');
                        $('#jenis_kelamin').addClass('is-valid');
                    }
                    if (err.error_tempat_lahir) {
                        $('.error-tempat_lahir').html(err.error_tempat_lahir);
                        $('#tempat_lahir').addClass('is-invalid');
                    } else {
                        $('.error-tempat_lahir').html('');
                        $('#tempat_lahir').removeClass('is-invalid');
                        $('#tempat_lahir').addClass('is-valid');
                    }
                    if (err.error_tanggal_lahir) {
                        $('.error-tanggal_lahir').html(err.error_tanggal_lahir);
                        $('#tanggal_lahir').addClass('is-invalid');
                    } else {
                        $('.error-tanggal_lahir').html('');
                        $('#tanggal_lahir').removeClass('is-invalid');
                        $('#tanggal_lahir').addClass('is-valid');
                    }
                    if (err.error_agama) {
                        $('.error-agama').html(err.error_agama);
                        $('#agama').addClass('is-invalid');
                    } else {
                        $('.error-agama').html('');
                        $('#agama').removeClass('is-invalid');
                        $('#agama').addClass('is-valid');
                    }
                    if (err.error_pendidikan) {
                        $('.error-pendidikan').html(err.error_pendidikan);
                        $('#pendidikan').addClass('is-invalid');
                    } else {
                        $('.error-pendidikan').html('');
                        $('#pendidikan').removeClass('is-invalid');
                        $('#pendidikan').addClass('is-valid');
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
                    if (err.error_username) {
                        $('.error-username').html(err.error_username);
                        $('#username').addClass('is-invalid');
                    } else {
                        $('.error-username').html('');
                        $('#username').removeClass('is-invalid');
                        $('#username').addClass('is-valid');
                    }
                    if (err.error_password) {
                        $('.error-password').html(err.error_password);
                        $('#password').addClass('is-invalid');
                    } else {
                        $('.error-password').html('');
                        $('#password').removeClass('is-invalid');
                        $('#password').addClass('is-valid');
                    }
                }
                if (response.success) {
                    $('#my-modal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.success,
                    }).then((value) => {
                        location.href = "<?= base_url() ?>/hrm-karyawan/redirect/edit"
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
        $('#tanggal_lahir').datepicker({
            format: "yyyy-mm-dd"
        });
    })
</script>