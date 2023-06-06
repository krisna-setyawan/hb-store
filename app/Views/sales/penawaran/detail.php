<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Buat List Produk Penawaran</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>sales-penawaran">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row">
        <div class="col-md-9">

            <div class="card">
                <div class="card-header text-light" style="background-color: #3A98B9;">
                    List Produk
                </div>
                <div class="card-body" style="background-color: #E6ECF0;">

                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <input autocomplete="off" type="text" class="form-control" placeholder="Cari Produk" id="produk" style="cursor: pointer;">
                            <input type="hidden" id="id_produk" value="">
                            <input autocomplete="off" type="text" class="form-control" placeholder="Qty" id="qty">
                            <button class="btn btn-secondary px-2" type="button" id="tambah_produk"><i class="fa-fw fa-solid fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">#</th>
                                    <th class="text-center" width="15%">SKU</th>
                                    <th class="text-center" width="30%">Produk</th>
                                    <th class="text-center" width="20%">Satuan</th>
                                    <th class="text-center" width="5%">Qty</th>
                                    <th class="text-center" width="20%">Total</th>
                                    <th class="text-center" width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel_list_produk">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-3">

            <div class="card mb-3">
                <div class="card-header text-light" style="background-color: #3A98B9;">
                    Detail Penawaran
                </div>
                <div class="card-body" style="background-color: #E6ECF0;">
                    <form id="form_penawaran" autocomplete="off" action="<?= site_url() ?>sales-kirim_penawaran" method="post">
                        <input type="hidden" name="id_penawaran" value="<?= $penawaran['id'] ?>">
                        <div class="mb-3">
                            <label for="no_penawaran" class="form-label">Nomor Penawaran</label>
                            <input readonly type="text" class="form-control" id="no_penawaran" name="no_penawaran" value="<?= $penawaran['no_penawaran'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="customer" class="form-label">Customer</label>
                            <select class="form-select" id="customer" name="customer">
                                <option value=""></option>
                                <?php foreach ($customer as $sup) : ?>
                                    <option <?= ($sup['id'] == $penawaran['id_customer']) ? 'selected' : '' ?> value="<?= $sup['id'] ?>"><?= $sup['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <input type="hidden" name="id_customer" id="id_customer">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input onchange="ganti_no_penawaran()" type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $penawaran['tanggal'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="user" class="form-label">Admin</label>
                            <select disabled class="form-select" id="user" name="user">
                                <option value=""></option>
                                <?php foreach ($user as $usr) : ?>
                                    <option <?= ($usr['id'] == user()->id) ? 'selected' : '' ?> value="<?= $usr['id'] ?>"><?= $usr['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                            <input type="hidden" name="id_user" id="id_user">
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body" style="background-color: #E6ECF0;">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" id="simpan_penawaran">Simpan Penawaran <i class="fa-solid fa-floppy-disk"></i></button>
                    </div>
                    <br>
                    <div class="d-grid gap-2">
                        <button class="btn btn-danger" id="kirim_penawaran">Kirim Penawaran <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>


</main>


<?= $this->include('MyLayout/js') ?>



<!-- Modal -->
<div class="modal fade" id="my-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" style="max-width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiModal">

            </div>
        </div>
    </div>
</div>
<!-- Modal -->



<script>
    $(document).ready(function() {
        $("#customer").select2({
            theme: "bootstrap-5",
        });
        $("#user").select2({
            theme: "bootstrap-5",
        });

        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });

        load_list();
        set_value_select2();
    })


    function load_list() {
        let id_penawaran = '<?= $penawaran['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-produks_penawaran",
            data: 'id_penawaran=' + id_penawaran,
            dataType: "json",
            success: function(response) {
                $('#tabel_list_produk').html(response.list)
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }


    function ganti_no_penawaran() {
        let tanggal = $('#tanggal').val()
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-ganti_no_penawaran",
            data: 'tanggal=' + tanggal,
            dataType: "json",
            success: function(response) {
                if (response.no_penawaran) {
                    $('#no_penawaran').val(response.no_penawaran)
                } else {
                    Swal.fire(
                        'Opss.',
                        'Terjadi kesalahan, hubungi IT Support',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }


    function set_value_select2() {
        $('#id_customer').val($('#customer').val());
        $('#id_user').val($('#user').val());
    }


    $('#produk').click(function() {
        let customer = $('#customer').val();
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>sales-get_produk_add_list/' + customer,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#judulModal').html('Pencarian Produk')
                    $('#isiModal').html(res.data)
                    $('#my-modal').modal('toggle')
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    })


    $('#tambah_produk').click(function() {
        let id_produk = $('#id_produk').val();
        let qty = $('#qty').val();
        let id_penawaran = '<?= $penawaran['id'] ?>'

        if (id_produk != '' && qty != '') {
            $.ajax({
                type: "post",
                url: "<?= site_url() ?>sales-penawaran_detail",
                data: 'id_penawaran=' + id_penawaran +
                    '&id_produk=' + id_produk +
                    '&qty=' + qty,
                dataType: "json",
                success: function(response) {
                    if (response.notif) {
                        Swal.fire(
                            'Berhasil',
                            'Berhasil menambah produk ke dalam List',
                            'success'
                        )
                        load_list();
                        $('#qty').val('');
                        $('#id_produk').val('');
                        $('#produk').val('');
                    } else {
                        alert('terjadi error tambah list produk')
                    }
                },
                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });
        } else {
            Swal.fire(
                'Ops.',
                'Pilih Produk dan Qty dulu.',
                'error'
            )
        }
    })


    $('#simpan_penawaran').click(function() {
        let id_penawaran = '<?= $penawaran['id'] ?>'
        let no_penawaran = $('#no_penawaran').val()
        let id_customer = $('#customer').val()
        let tanggal = $('#tanggal').val()
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-simpan_penawaran",
            data: 'id_penawaran=' + id_penawaran +
                '&no_penawaran=' + no_penawaran +
                '&id_customer=' + id_customer +
                '&tanggal=' + tanggal,
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    location.href = '<?= site_url() ?>sales-penawaran'
                } else {
                    Swal.fire(
                        'Opss.',
                        'Terjadi kesalahan, hubungi IT Support',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    })


    $('#kirim_penawaran').click(function() {
        let id_penawaran = '<?= $penawaran['id'] ?>'
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>sales-check_list_produk",
            data: 'id_penawaran=' + id_penawaran,
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    Swal.fire({
                        title: 'Konfirmasi?',
                        text: "Apakah yakin mengirim penawaran ini ke customer?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lanjut!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form_penawaran').submit();
                        }
                    })
                } else {
                    Swal.fire(
                        'Opss.',
                        'Tidak ada produk dalam penawaran. pilih minimal satu produk dulu!',
                        'error'
                    )
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    })
</script>

<?= $this->endSection() ?>