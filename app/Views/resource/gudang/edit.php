<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Edit Gudang</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>resource-gudang">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row">

        <!-- EDIT MASTER GUDANG -->
        <div class="col-md-7 mb-5">

            <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>resource-gudang/<?= $gudang['id'] ?>" method="POST">

                <?= csrf_field() ?>

                <input type="hidden" name="_method" value="PUT">

                <div class="row mb-3">
                    <label for="nama" class="col-sm-3 col-form-label">Nama Gudang</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama', $gudang['nama']); ?>">
                        <div class="invalid-feedback"> <?= validation_show_error('nama'); ?></div>
                    </div>
                </div>


                <!-- PROVINSI -->
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Provinsi</label>
                    <div class="col-sm-9">
                        <select required class="form-select" id="id_provinsi" name="id_provinsi">
                            <?php foreach ($provinsi as $prov) { ?>
                                <option <?= ($prov['id'] == $gudang['id_provinsi'] ? 'selected' : '') ?> value="<?= $prov['id'] ?>"><?= $prov['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- KOTA -->
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Kota</label>
                    <div class="col-sm-9">
                        <select required class="form-select" id="id_kota" name="id_kota">
                            <?php foreach ($kota as $kot) { ?>
                                <option <?= ($kot['id'] == $gudang['id_kota'] ? 'selected' : '') ?> value="<?= $kot['id'] ?>"><?= $kot['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- KECAMATAN -->
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Kecamatan</label>
                    <div class="col-sm-9">
                        <select required class="form-select" id="id_kecamatan" name="id_kecamatan">
                            <?php foreach ($kecamatan as $kec) { ?>
                                <option <?= ($kec['id'] == $gudang['id_kecamatan'] ? 'selected' : '') ?> value="<?= $kec['id'] ?>"><?= $kec['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- KELURAHAN -->
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Kelurahan</label>
                    <div class="col-sm-9">
                        <select required class="form-select" id="id_kelurahan" name="id_kelurahan">
                            <?php foreach ($kelurahan as $kel) { ?>
                                <option <?= ($kel['id'] == $gudang['id_kelurahan'] ? 'selected' : '') ?> value="<?= $kel['id'] ?>"><?= $kel['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Detail Alamat</label>
                    <div class="col-sm-9">
                        <input required type="text" class="form-control <?= (validation_show_error('keterangan')) ? 'is-invalid' : ''; ?>" name="detail_alamat" value="<?= old('detail_alamat', $gudang['detail_alamat']); ?>">
                        <div class="invalid-feedback"><?= validation_show_error('detail_alamat'); ?></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">No Telp</label>
                    <div class="col-sm-9">
                        <input required type="text" class="form-control <?= (validation_show_error('no_telp')) ? 'is-invalid' : ''; ?>" id="no_telp" name="no_telp" value="<?= old('no_telp', $gudang['no_telp']); ?>">
                        <div class="invalid-feedback"><?= validation_show_error('no_telp'); ?></div>
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="keterangan" class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= (validation_show_error('keterangan')) ? 'is-invalid' : ''; ?>" id="keterangan" name="keterangan" value="<?= old('keterangan', $gudang['keterangan']); ?>">
                        <div class="invalid-feedback"><?= validation_show_error('keterangan'); ?></div>
                    </div>
                </div>

                <div class="text-center">
                    <a class="btn px-5 btn-outline-danger" href="<?= site_url() ?>resource-gudang">
                        Batal <i class="fa-fw fa-solid fa-xmark"></i>
                    </a>
                    <button class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
                </div>
            </form>

        </div>

        <!-- ADMIN PENANGGUNGJAWAB -->
        <div class="col-md-5 mb-5">
            <div class="d-flex mb-0">
                <div class="me-auto">
                    <h5 class="mb-2">Penanggung Jawab</h5>
                </div>
                <div>
                    <button class="btn btn-sm btn-secondary mb-2 py-0" data-bs-toggle="modal" data-bs-target="#modal-add-pj">
                        <i class="fa-fw fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped table-secondary">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th width="55%">Nama</th>
                            <th width="20%">Urutan</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($pj as $pj) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $pj['nama_pj'] ?></td>
                                <td class="text-center"><?= $pj['urutan'] ?></td>
                                <td class="text-center">
                                    <a title="Edit" class="px-2 py-0 btn btn-sm btn-outline-primary" onclick="edit_pj(<?= $pj['id'] ?>)">
                                        <i class="fa-fw fa-solid fa-pen"></i>
                                    </a>
                                    <form id="form_delete_pj" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="id_gudang" value="<?= $gudang['id'] ?>">
                                    </form>
                                    <button onclick="confirm_delete_pj(<?= $pj['id'] ?>)" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>


<!-- Modal add penanggung jawab -->
<div class="modal fade" id="modal-add-pj" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Penanggung Jawab</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form novalidate class="needs-validation" id="form-add-pj" autocomplete="off" action="<?= site_url() ?>resource-gudangpj" method="POST">

                    <?= csrf_field() ?>

                    <input type="hidden" name="id_gudang" value="<?= $gudang['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Penanggung Jawab</label>
                        <select required class="form-control" name="id_user" id="id_user">
                            <option value=""></option>
                            <?php foreach ($users as $us) : ?>
                                <option value="<?= $us['id'] ?>"><?= $us['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <hr class="my-4">

                    <button class="btn btn-outline-secondary mb-2 btn-sm" type="submit">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit penanggung jawab -->
<div class="modal fade" id="modal-edit-pj" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form novalidate class="needs-validation" id="form-edit-pj" autocomplete="off" method="POST">

                    <?= csrf_field() ?>

                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id_gudang" value="<?= $gudang['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input required type="number" class="form-control" id="edit-urutan" name="edit-urutan">
                    </div>

                    <hr class="my-4">

                    <button class="btn btn-outline-secondary mb-2 btn-sm" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $("#id_provinsi").select2({
            theme: "bootstrap-5",
        });
        $("#id_kota").select2({
            theme: "bootstrap-5",
        });
        $("#id_kecamatan").select2({
            theme: "bootstrap-5",
        });
        $("#id_kelurahan").select2({
            theme: "bootstrap-5",
        });

        // Alert
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }
    })


    // Bahan Alert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        background: '#EC7063',
        color: '#fff',
        iconColor: '#fff',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })


    // RANTAI WILAYAH
    $(document).ready(function() {
        $('#id_provinsi').change(function() {
            let id_provinsi = $(this).val();
            if (id_provinsi != '') {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('wilayah/kota_by_provinsi') ?>',
                    data: '&id_provinsi=' + id_provinsi,
                    success: function(html) {
                        $('#id_kota').html(html);
                        $('#id_kecamatan').html('<option selected value=""></option>');
                        $('#id_kelurahan').html('<option selected value=""></option>');
                    }
                })
            } else {
                $('#id_kota').html('<option selected value=""></option>');
                $('#id_kecamatan').html('<option selected value=""></option>');
                $('#id_kelurahan').html('<option selected value=""></option>');
            }
        })

        $('#id_kota').change(function() {
            let id_kota = $(this).val();
            if (id_kota != '') {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('wilayah/kecamatan_by_kota') ?>',
                    data: '&id_kota=' + id_kota,
                    success: function(html) {
                        $('#id_kecamatan').html(html);
                        $('#id_kelurahan').html('<option selected value=""></option>');
                    }
                })
            } else {
                $('#id_kecamatan').html('<option selected value=""></option>');
                $('#id_kelurahan').html('<option selected value=""></option>');
            }
        })

        $('#id_kecamatan').change(function() {
            let id_kecamatan = $(this).val();
            if (id_kecamatan != '') {
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('wilayah/kelurahan_by_kecamatan') ?>',
                    data: '&id_kecamatan=' + id_kecamatan,
                    success: function(html) {
                        $('#id_kelurahan').html(html);
                    }
                })
            } else {
                $('#id_kelurahan').html('<option selected value=""></option>');
            }
        })
    })


    // PENANGGUNG JAWAB
    function edit_pj(id) {
        $.ajax({
            type: "get",
            url: "<?= site_url() ?>resource-gudangpj/" + id + "/edit",
            dataType: "json",
            success: function(response) {
                $('#form-edit-pj').attr('action', '<?= site_url() ?>resource-gudangpj/' + id);
                $('#edit-urutan').val(response.urutan);
                $('#modal-edit-pj').modal('toggle')
            }
        });
    }

    function confirm_delete_pj(id) {
        Swal.fire({
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus Admin?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_delete_pj').attr('action', '<?= site_url() ?>resource-gudangpj/' + id);
                $('#form_delete_pj').submit();
            }
        })
    }
</script>

<?= $this->endSection() ?>