<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<main class="p-md-3 p-2">
    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Edit Jurnal</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>finance-jurnalumum">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>finance-jurnal/<?= $transaksi['id'] ?>" method="POST" id="form">

        <input type="hidden" name="_method" value="PUT">

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nomor Transaksi</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nomor_transaksi" name="nomor_transaksi" value="<?= $transaksi['nomor_transaksi'] ?>" readonly="">
                <div class="invalid-feedback error_nomor"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= $transaksi['tanggal'] ?>">
                <div class="invalid-feedback error_tanggal"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="satuan" class="col-sm-2 col-form-label">Referensi</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="referensi" name="referensi" value="<?= $transaksi['referensi'] ?>">
                <div class="invalid-feedback error_referensi"></div>
            </div>
        </div>

        <div class="container pe-2">

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                    <thead style="background-color: #F6DCA9; border:#566573">
                        <tr>
                            <th class="text-center" width="25%">Akun</th>
                            <th class="text-center" width="40%">Deskripsi</th>
                            <th class="text-center" width="16%">Debit</th>
                            <th class="text-center" width="16%">Kredit</th>
                            <th class="text-center" width="3%"></th>
                        </tr>
                    </thead>

                    <tbody id="tabel_list_transaksi">
                        <?php $no = 1 ?>
                        <?php foreach ($detail as $dt) : ?>
                            <input type="hidden" id="id_detail" name="id_detail[]" value="<?= $dt['id'] ?>">
                            <tr>
                                <td>
                                    <select class="form-control" name="id_akun[]">
                                        <?php foreach ($akun as $ak) : ?>
                                            <option <?= (old($dt['id_akun'], $dt['id_akun']) == $ak['id']) ? 'selected' : ''; ?> value="<?= $ak['id'] ?>-krisna-<?= $ak['nama'] ?>"><?= $ak['kode'] ?>-<?= $ak['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" id="deskripsi" name="deskripsi[]" value="<?= $dt['deskripsi'] ?>"></td>
                                <td><input type="number" class="form-control debit" id="debit" name="debit[]" value="<?= $dt['debit'] ?>"></td>
                                <td><input type="number" class="form-control kredit" id="kredit" name="kredit[]" value="<?= $dt['kredit'] ?>"></td>
                                <td>
                                    <a type="button" href="<?= site_url() ?>finance-hapusBaris/<?= $dt['id'] ?>/<?= $transaksi['id'] ?>" class='btn px-2 mt-2 py-0 btn btn-sm btn-outline-danger' id='HapusBaris'><i class='fa-fw fa-solid fa-xmark'></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <button class="btn btn-sm btn-outline-danger px-5 mb-3" type="button" id="baris">Tambah <i class="fa-fw fa-solid fa-plus"></i></button>

                <table class="table table-striped" width="100%" style="border: #fff;">
                    <tr>
                        <td width="65%" colspan="2" class="ps-3 fw-bold fs-5">Total</td>
                        <td width="16%" class="ps-3 fw-bold fs-5">
                            <span class="title-total" name="totalDebit" id="totalDebit">0</span>
                            <input type="hidden" name="total_transaksi" id="total_transaksi">
                        </td>
                        <td width="19%" class="ps-3 fw-bold fs-5" colspan="2">
                            <span class="title-total" name="totalKredit" id="totalKredit">0</span>
                            <input type="hidden" name="total_kredit" id="total_kredit">
                        </td>
                    </tr>
                    <tr style="border: #fff;">
                        <td colspan="2"></td>
                        <td colspan="2">
                            <input type="hidden" id="triger_error_total">
                            <div class="invalid-feedback error_total"></div>
                        </td>
                    </tr>
                </table>

            </div>

            <button id="tombolSimpan" class="btn px-5 btn-primary mt-4" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>

        </div>

    </form>
</main>

<?= $this->include('MyLayout/js') ?>
<?= $this->include('MyLayout/validation') ?>

<script>
    function Barisbaru() {
        var Nomor = $('#tabel tbody tr').length + 1;
        var Baris = "<tr>";
        Baris += "<td>";
        Baris += "<select class='form-control' name='id_akun[]' id='id_akun" + Nomor + "' required></select>";
        Baris += "</td>";
        Baris += "<td>";
        Baris += "<input type='text' name='deskripsi[]' class='form-control' placeholder='Deskripsi'>";
        Baris += "</td>";
        Baris += "<td>";
        Baris += "<input type='text' name='debit[]' class='form-control debit' placeholder='Debit' required>";
        Baris += "</td>";
        Baris += "<td>";
        Baris += "<input type='text' name='kredit[]' class='form-control kredit' placeholder='Kredit' required>";
        Baris += "</td>";
        Baris += "<td><a class='btn px-2 mt-2 py-0 btn btn-sm btn-outline-danger' id='HapusBaris'><i class='fa-fw fa-solid fa-xmark'></i></a>";
        Baris += "</td>";
        Baris += "</tr>";

        $('#tabel tbody').append(Baris);

        FormSelectAkun(Nomor);
    }


    $(document).ready(function() {
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }

        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });

        hitungDebit();
        hitungKredit();

        $('#tabel').on('input', '.debit', function() {
            hitungDebit();
        });

        $('#tabel').on('input', '.kredit', function() {
            hitungKredit();
        });
    })


    $('#baris').click(function(e) {
        e.preventDefault();

        var A;
        for (A = 1; A <= 1; A++) {
            Barisbaru();
        };
    });


    function hitungDebit() {
        var totalDebit = 0;
        $('#tabel .debit').each(function() {
            var getValueDebit = parseFloat($(this).val());
            if ($.isNumeric(getValueDebit)) {
                totalDebit += getValueDebit;
            }
        });

        $("#totalDebit").html(formatRupiah(totalDebit));
        $("#total_transaksi").val(totalDebit);
    }


    function hitungKredit() {
        var totalKredit = 0;
        $('#tabel .kredit').each(function() {
            var getValueKredit = parseFloat($(this).val());
            if ($.isNumeric(getValueKredit)) {
                totalKredit += getValueKredit;
            }
        });
        $("#totalKredit").html(formatRupiah(totalKredit));
        $("#total_kredit").val(totalKredit);
    }


    function FormSelectAkun(Nomor) {
        var output = [];
        output.push('<option value ="">Pilih Akun</option>');
        $.getJSON('<?= site_url() ?>finance-getlistakun', function(data) {
            $.each(data, function(key, value) {
                output.push('<option value="' + value.id + '">' + value.kode + '-' + value.nama + '</option>');
            });
            $('#id_akun' + Nomor).html(output.join(''));
        });
    }


    $('#form').submit(function(e) {
        e.preventDefault();
        var valueDebit = $('#total_transaksi').val();
        var valueKredit = $('#total_kredit').val();
        if (valueDebit != valueKredit) {
            $('.error_total').html('<h4> Jumlah nilai debit dan kredit harus sama. </h4>');
            $('#triger_error_total').addClass('is-invalid');
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
                    $('#tombolSimpan').html('Update <i class="fa-fw fa-solid fa-check"></i>');
                    $('#tombolSimpan').prop('disabled', false);
                },
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.error_nomor) {
                            $('.error_nomor').html(err.error_nomor);
                            $('#nomor_transaksi').addClass('is-invalid');
                        } else {
                            $('.error_nomor').html('');
                            $('#nomor_transaksi').removeClass('is-invalid');
                            $('#nomor_transaksi').addClass('is-valid');
                        }
                        if (err.error_tanggal) {
                            $('.error_tanggal').html(err.error_tanggal);
                            $('#tanggal').addClass('is-invalid');
                        } else {
                            $('.error_tanggal').html('');
                            $('#tanggal').removeClass('is-invalid');
                            $('#tanggal').addClass('is-valid');
                        }
                    }
                    if (response.success) {
                        location.href = "<?= base_url() ?>/finance-jurnal";
                    }
                },
                error: function(e) {
                    alert('Errorssssss \n' + e.responseText);
                }
            });
            return false
        }
    })
</script>
<?= $this->endSection() ?>