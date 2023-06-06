<form autocomplete="off" class="row g-3 mt-2" action="<?= site_url() ?>hrm-group/create" method="POST" id="form">
    <?= csrf_field() ?>
    <div class="row mb-3">
        <label for="user" class="col-sm-3 col-form-label">User</label>
        <div class="col-sm-9">
            <select class="form-control" name="user" id="user">
                <option value=""></option>
                <?php foreach ($user as $user) : ?>
                    <option value="<?= $user->id ?>"><?= $user->name ?></option>
                <?php endforeach ?>
            </select>
            <div class="invalid-feedback error_user_id"></div>
        </div>
    </div>

    <input type="hidden" name="group_id" value=<?= $id_group ?>>
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
                    if (err.error_user) {
                        $('.error-user').html(err.error_user);
                        $('#user').addClass('is-invalid');
                    } else {
                        $('.error-user').html('');
                        $('#user').removeClass('is-invalid');
                        $('#user').addClass('is-valid');
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
        $("#user").select2({
            theme: "bootstrap-5",
            tags: true,
            dropdownParent: $('#my-modal')
        });
    })
</script>