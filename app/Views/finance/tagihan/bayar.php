<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<main class="p-md-3 p-2" style="margin-bottom: 100px;">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Bayar Tagihan</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>finance-tagihan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>finance-tagihan/doPay" method="POST" id="form">

        <input type="hidden" id="id_user" name="id_user" value="<?= user()->id ?>">
        <input type="hidden" id="id_tagihan" name="id_tagihan" value="<?= $tagihan['id'] ?>">
        <input type="hidden" id="no_tagihan" name="no_tagihan" value="<?= $tagihan['no_tagihan'] ?>">

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nomor Tagihan </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" readonly value="<?= $nomor_tagihan_auto ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label for="satuan" class="col-sm-2 col-form-label">Penerima</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" readonly value="<?= $tagihan['penerima'] ?>">
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="tanggal_bayar" name="tanggal_bayar" value="<?= date('Y-m-d') ?>">
                <div class="invalid-feedback error_tanggal_bayar"></div>
            </div>
        </div>

        <div class="container pe-2">

            <div class="table-responsive">
                <h5 class="mt-0">Rincian Tagihan</h5>
                <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                    <thead style="background-color: #F5B7B1; border: #566573;">
                        <tr>
                            <th class="text-center" width="50%">Nama Rincian</th>
                            <th class="text-center" width="30%">Deskripsi</th>
                            <th class="text-center" width="20%">Biaya</th>
                        </tr>
                    </thead>
                    <tbody id="list_rincian_tagihan">
                        <?php foreach ($rincian as $ls) { ?>
                            <tr>
                                <td class="ps-3"><?= $ls['nama_rincian'] ?></td>
                                <td class="ps-3"><?= $ls['deskripsi'] ?></td>
                                <td class="text-end pe-4">Rp. <?= number_format($ls['jumlah'], 0, ',', '.') ?></td>
                            </tr>
                        <?php } ?>
                        <tr class="fs-5">
                            <td class="text-end pe-4" colspan="2">Total Tagihan</td>
                            <td class="text-end pe-4">Rp. <?= number_format($tagihan['jumlah'], 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>

                <?php if ($pembayaran) : ?>
                    <h5 class="mt-4">Pembayaran</h5>
                    <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                        <thead style="background-color: #83CBCD; border: #566573;">
                            <tr>
                                <th class="text-center" width="20%">Pembayaran</th>
                                <th class="text-center" width="15%">Tanggal</th>
                                <th class="text-center" width="27%">Akun Pembayaran</th>
                                <th class="text-center" width="18%">Admin</th>
                                <th class="text-center" width="20%">Jumlah Bayar</th>
                            </tr>
                        </thead>
                        <tbody id="list_rincian_tagihan">
                            <?php
                            $no = 1;
                            $total_pembayaran = 0;
                            foreach ($pembayaran as $pb) {
                                $total_pembayaran += $pb['jumlah_bayar'];
                            ?>
                                <tr>
                                    <td class="ps-3">Pembayaran ke - <?= $no++ ?></td>
                                    <td class="ps-3"><?= $pb['tanggal_bayar'] ?></td>
                                    <td class="ps-3"><?= $pb['akun'] ?></td>
                                    <td class="ps-3"><?= $pb['admin'] ?></td>
                                    <td class="text-end pe-4">Rp. <?= number_format($pb['jumlah_bayar'], 0, ',', '.') ?></td>
                                </tr>
                            <?php } ?>
                            <tr class="fs-5">
                                <td class="text-end pe-4" colspan="4">Total Pembayaran</td>
                                <td class="text-end pe-4 ">Rp. <?= number_format($total_pembayaran, 0, ',', '.') ?></td>
                            </tr>
                            <tr class=" fs-5">
                                <td class="text-end pe-4" colspan="4">Sisa Tagihan</td>
                                <td class="text-end pe-4">Rp. <?= number_format($tagihan['sisa_tagihan'], 0, ',', '.') ?></td>
                            </tr>
                            <tr class="fs-5">
                                <td class="text-end pe-4" colspan="4">Status Tagihan</td>
                                <td class="text-end pe-4 <?= ($tagihan['status'] == 'Lunas') ? 'text-success' : 'text-danger' ?>"><?= $tagihan['status'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <label for="satuan" class="col-form-label">Total Bayar Sekarang</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text px-3" id="basic-addon1">Rp. </span>
                        <input type="text" class="form-control form-control-lg fs-5 text-end pe-4" id="jumlah_bayar" name="jumlah_bayar">
                        <div class="invalid-feedback error_jumlah_bayar"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <label for="satuan" class="col-form-label">Dibayar dari</label>
                    <select class="form-select form-select-lg" id="id_akun_pembayaran" name="id_akun_pembayaran">
                        <?php foreach ($dariAkun as $da) : ?>
                            <option value="<?= $da['id'] ?>"><?= $da['nama'] ?></option>
                        <?php endforeach ?>
                    </select>

                    <hr class="mb-0 mt-4">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div class="d-grid gap-2">
                        <button id="tombolSimpan" class="btn px-5 btn-outline-success mt-4" type="submit">Tambah Pembayaran <i class="fa-fw fa-solid fa-check"></i></button>
                    </div>
                </div>
            </div>

        </div>


    </form>
</main>

<?= $this->include('MyLayout/js') ?>
<?= $this->include('MyLayout/validation') ?>

<script>
    $(document).ready(function() {
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });

        $('#jumlah_bayar').mask('000.000.000.000', {
            reverse: true
        });

        $('#jumlah_bayar').on('input', function() {
            $(this).removeClass('is-invalid');
        });
    })


    $('#form').submit(function(e) {
        e.preventDefault();
        var jumlah_bayar = parseInt($('#jumlah_bayar').val().replace(/\./g, ''));
        if (jumlah_bayar > <?= $tagihan['sisa_tagihan'] ?>) {
            Swal.fire({
                icon: 'error',
                title: 'ehh..',
                text: 'Nominal pembayaran kebanyakan kak, yang perlu dibayarkan kan cuma Rp. <?= number_format($tagihan['sisa_tagihan'], 0, ',', '.') ?> doang.',
            });
        } else {
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

                        if (err.error_tanggal_bayar) {
                            $('.error_tanggal_bayar').html(err.error_tanggal_bayar);
                            $('#tanggal_bayar').addClass('is-invalid');
                        } else {
                            $('.error_tanggal_bayar').html('');
                            $('#tanggal_bayar').removeClass('is-invalid');
                            $('#tanggal_bayar').addClass('is-valid');
                        }
                        if (err.error_jumlah_bayar) {
                            $('.error_jumlah_bayar').html(err.error_jumlah_bayar);
                            $('#jumlah_bayar').addClass('is-invalid');
                        } else {
                            $('.error_jumlah_bayar').html('');
                            $('#jumlah_bayar').removeClass('is-invalid');
                            $('#jumlah_bayar').addClass('is-valid');
                        }
                    }
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        });
                        location.href = "<?= base_url() ?>/finance-tagihan";
                    }
                },
                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });
        }
    })
</script>

<?= $this->endSection() ?>