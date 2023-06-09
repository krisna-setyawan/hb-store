<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Edit Customer</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>resource-customer">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row">
        <div class="col-md-7 mb-5">

            <form autocomplete="off" class="row mt-0 mb-4" action="<?= site_url() ?>resource-customer/<?= $customer['id'] ?>" method="POST">

                <?= csrf_field() ?>

                <input type="hidden" name="_method" value="PUT">


                <div class="mb-3">
                    <label class="form-label text-secondary" for="id_customer">Perusahaan</label>
                    <select class="form-control" name="perusahaan" id="perusahaan">
                        <option value="Non Haebot">Non Haebot</option>
                        <?php foreach ($perusahaan as $prs) :
                            if ($prs['id_perusahaan'] != $id_perusahaan) { ?>
                                <option <?= ($prs['id_perusahaan'] == $customer['id_perusahaan']) ? 'selected' : '' ?> data-id="<?= $prs['id_perusahaan'] ?>" value="<?= $prs['nama'] ?>"><?= $prs['nama'] ?></option>
                            <?php } ?>
                        <?php endforeach ?>
                    </select>
                </div>

                <input type="hidden" id="id_perusahaan" name="id_perusahaan" value="<?= $customer['id_perusahaan'] ?>">

                <div class="mb-3">
                    <label class="form-label text-secondary" for="id_customer">ID Customer</label>
                    <input type="text" class="form-control <?= (validation_show_error('id_customer')) ? 'is-invalid' : ''; ?>" id="id_customer" name="id_customer" value="<?= old('id_customer', $customer['id_customer']); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('id_customer'); ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary" for="nama">Nama Customer</label>
                    <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama', $customer['nama']); ?>">
                    <div class="invalid-feedback"> <?= validation_show_error('nama'); ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary" for="no_telp">No Telp</label>
                    <input type="text" class="form-control <?= (validation_show_error('no_telp')) ? 'is-invalid' : ''; ?>" id="no_telp" name="no_telp" value="<?= old('no_telp', $customer['no_telp']); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('no_telp'); ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary" for="email">Email</label>
                    <input type="text" class="form-control <?= (validation_show_error('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= old('email', $customer['email']); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('email'); ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary" for="tgl_registrasi">Tgl Registrasi</label>
                    <input type="text" class="form-control <?= (validation_show_error('tgl_registrasi')) ? 'is-invalid' : ''; ?>" id="tgl_registrasi" name="tgl_registrasi" value="<?= old('tgl_registrasi', $customer['tgl_registrasi']); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('tgl_registrasi'); ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary" for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option <?= (old('status', $customer['status']) == 'Active') ? 'selected' : ''; ?> value="Active">Active</option>
                        <option <?= (old('status', $customer['status']) == 'Inactive') ? 'selected' : ''; ?> value="Inactive">Inactive</option>
                    </select>
                    <div class="invalid-feedback error-status"><?= validation_show_error('status'); ?></div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary" for="note">Note</label>
                    <input type="text" class="form-control <?= (validation_show_error('note')) ? 'is-invalid' : ''; ?>" id="note" name="note" value="<?= old('note', $customer['note']); ?>">
                    <div class="invalid-feedback"><?= validation_show_error('note'); ?></div>
                </div>

                <div class="text-center">
                    <a class="btn px-5 btn-outline-danger" href="<?= site_url() ?>resource-customer">
                        Batal <i class="fa-fw fa-solid fa-xmark"></i>
                    </a>
                    <button class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
                </div>
            </form>

        </div>

        <div class="col-md-5 mb-5">
            <!-- ADMIN PENANGGUNGJAWAB -->
            <div class="d-flex mb-0">
                <div class="me-auto">
                    <h5 class="mb-2">Admin</h5>
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
                            <th width="55%">Admin</th>
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
                                        <input type="hidden" name="id_customer" value="<?= $customer['id'] ?>">
                                    </form>
                                    <button onclick="confirm_delete_pj(<?= $pj['id'] ?>)" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- ALAMAT -->
            <div class="d-flex mb-0">
                <div class="me-auto">
                    <h5 class="mb-2">Alamat</h5>
                </div>
                <div>
                    <button class="btn btn-sm btn-secondary mb-2 py-0" data-bs-toggle="modal" data-bs-target="#modal-add-alamat">
                        <i class="fa-fw fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-striped table-secondary">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th width="25%">Nama</th>
                            <th width="60%">Alamat, Penerima, Telp</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($alamat as $al) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $al['nama'] ?></td>
                                <td>
                                    <?= $al['detail_alamat'] ?>, <?= $al['kelurahan'] ?>, <?= $al['kecamatan'] ?>, <?= $al['kota'] ?>, <?= $al['provinsi'] ?>
                                    <br>
                                    Penerima : <?= $al['penerima'] ?>
                                    <br>
                                    TELP : <?= $al['no_telp'] ?>
                                </td>
                                <td class="text-center">
                                    <form id="form_delete_alamat" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="id_customer" value="<?= $customer['id'] ?>">
                                    </form>
                                    <button onclick="confirm_delete_alamat(<?= $al['id'] ?>)" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- NOMOR REKENING -->
            <div class="d-flex mb-0">
                <div class="me-auto">
                    <h5 class="mb-3 mt-0">Nomor Rekening</h5>
                </div>
                <div>
                    <button class="btn btn-sm btn-secondary py-0 mt-0" data-bs-toggle="modal" data-bs-target="#modal-add-rekening">
                        <i class="fa-fw fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-secondary">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">No</th>
                            <th width="25%">Bank</th>
                            <th width="35%">A/n</th>
                            <th width="25%">No Rekening</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($rekening as $rek) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $rek['bank'] ?></td>
                                <td><?= $rek['atas_nama'] ?></td>
                                <td><?= $rek['no_rekening'] ?></td>
                                <td class="text-center">
                                    <form id="form_delete_rekening" method="POST" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="id_customer" value="<?= $customer['id'] ?>">
                                    </form>
                                    <button onclick="confirm_delete_rekening(<?= $rek['id'] ?>)" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-trash"></i></button>
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form novalidate class="needs-validation" id="form-add-pj" autocomplete="off" action="<?= site_url() ?>resource-customerpj" method="POST">

                    <?= csrf_field() ?>

                    <input type="hidden" name="id_customer" value="<?= $customer['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Admin</label>
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
                    <input type="hidden" name="id_customer" value="<?= $customer['id'] ?>">

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

<!-- Modal add alamat -->
<div class="modal fade" id="modal-add-alamat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Alamat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form novalidate class="needs-validation" id="form-add-alamat" autocomplete="off" action="<?= site_url() ?>resource-customeralamat" method="POST">

                    <?= csrf_field() ?>

                    <input type="hidden" name="id_customer" value="<?= $customer['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Nama Alamat</label>
                        <input required type="text" class="form-control" name="nama">
                    </div>

                    <!-- PROVINSI -->
                    <div class="mb-3">
                        <label class="form-label">Provinsi</label>
                        <select required class="form-select" id="id_provinsi" name="id_provinsi">
                            <option selected value=""></option>
                            <?php foreach ($provinsi as $prov) { ?>
                                <option value="<?= $prov['id'] ?>"><?= $prov['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- KOTA -->
                    <div class="mb-3">
                        <label class="form-label">Kota</label>
                        <select required class="form-select" id="id_kota" name="id_kota">
                            <option selected value=""></option>
                        </select>
                    </div>

                    <!-- KECAMATAN -->
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <select required class="form-select" id="id_kecamatan" name="id_kecamatan">
                            <option selected value=""></option>
                        </select>
                    </div>

                    <!-- KELURAHAN -->
                    <div class="mb-3">
                        <label class="form-label">Kelurahan</label>
                        <select required class="form-select" id="id_kelurahan" name="id_kelurahan">
                            <option selected value=""></option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Detail Alamat</label>
                        <input required type="text" class="form-control" name="detail_alamat">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penerima</label>
                        <input required type="text" class="form-control" name="penerima">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input required type="text" class="form-control" name="no_telp">
                    </div>

                    <hr class="my-4">

                    <button class="btn btn-outline-secondary mb-2 btn-sm" type="submit">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal add rekening -->
<div class="modal fade" id="modal-add-rekening" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Rekening</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form novalidate class="needs-validation" id="form-add-rekening" autocomplete="off" action="<?= site_url() ?>resource-customerrekening" method="POST">

                    <?= csrf_field() ?>

                    <input type="hidden" name="id_customer" value="<?= $customer['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label text-secondary">Bank</label>
                        <input required type="text" class="form-control" id="bank" name="bank">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">A/n</label>
                        <input required type="text" class="form-control" id="atas_nama" name="atas_nama">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">No Rekening</label>
                        <input required type="text" class="form-control" id="no_rekening" name="no_rekening">
                    </div>

                    <hr class="my-4">

                    <button class="btn btn-outline-secondary mb-2 btn-sm" type="submit">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->include('MyLayout/js') ?>
<?= $this->include('MyLayout/validation') ?>

<script>
    $(document).ready(function() {
        $("#id_provinsi").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#modal-add-alamat')
        });
        $("#id_kota").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#modal-add-alamat')
        });
        $("#id_kecamatan").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#modal-add-alamat')
        });
        $("#id_kelurahan").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#modal-add-alamat')
        });

        $('#tgl_registrasi').datepicker({
            format: "yyyy-mm-dd"
        });

        // Alert
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }


        $('#perusahaan').on('change', function() {
            var id = $(this).find('option:selected').data('id');
            if (id) {
                $.ajax({
                    type: 'GET',
                    url: '<?= site_url() ?>resource-perusahaan/' + id,
                    dataType: 'json',
                    success: function(res) {
                        if (res.perusahaan) {
                            $('#nama').val(res.perusahaan.nama)
                            $('#no_telp').val(res.perusahaan.no_telp)
                            $('#id_perusahaan').val(res.perusahaan.id_perusahaan)
                        }
                    },
                    error: function(e) {
                        alert('Error \n' + e.responseText);
                    }
                })
            } else {
                $('#nama').val('')
                $('#no_telp').val('')
                $('#id_perusahaan').val('')
            }
        });
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
            url: "<?= site_url() ?>resource-customerpj/" + id + "/edit",
            dataType: "json",
            success: function(response) {
                $('#form-edit-pj').attr('action', '<?= site_url() ?>resource-customerpj/' + id);
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
                $('#form_delete_pj').attr('action', '<?= site_url() ?>resource-customerpj/' + id);
                $('#form_delete_pj').submit();
            }
        })
    }


    // ALAMAT
    function confirm_delete_alamat(id) {
        Swal.fire({
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus alamat?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_delete_alamat').attr('action', '<?= site_url() ?>resource-customeralamat/' + id);
                $('#form_delete_alamat').submit();
            }
        })
    }


    // REKENING
    function confirm_delete_rekening(id) {
        Swal.fire({
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus rekening?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_delete_rekening').attr('action', '<?= site_url() ?>resource-customerrekening/' + id);
                $('#form_delete_rekening').submit();
            }
        })
    }
</script>

<?= $this->endSection() ?>