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
            <h3 style="color: #566573;">Tambah Tagihan</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>finance-tagihan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <form autocomplete="off" class="row g-3 mt-3" action="<?= site_url() ?>finance-tagihan/create" method="POST" id="form">

        <input type="hidden" id="id_user" name="id_user" value="<?= user()->id ?>">

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nomor </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="no_tagihan" name="no_tagihan" value="<?= $nomor_tagihan_auto ?>">
                <div class="invalid-feedback error_nomor"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Tanggal</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
                <div class="invalid-feedback error_tanggal"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="satuan" class="col-sm-2 col-form-label">Penerima</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="penerima" name="penerima">
                <div class="invalid-feedback error_penerima"></div>
            </div>
        </div>

        <div class="row mb-3">
            <label for="satuan" class="col-sm-2 col-form-label">Referensi</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="referensi" name="referensi">
            </div>
        </div>

        <div class="row mb-3">
            <label for="satuan" class="col-sm-2 col-form-label">Dibayar dari</label>
            <div class="col-sm-4">
                <select class="form-select" id="id_dariakun" name="id_dariakun">
                    <?php foreach ($dariAkun as $da) : ?>
                        <option value="<?= $da['id'] ?>"><?= $da['nama'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="container pe-2">

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
                    <thead style="background-color: #F5B7B1; border: #566573;">
                        <tr>
                            <th class="text-center" width="30%">Akun</th>
                            <th class="text-center" width="40%">Deskripsi</th>
                            <th class="text-center" width="20%">Total</th>
                            <th class="text-center" width="5%"></th>
                        </tr>
                    </thead>
                    <tbody id="list_rincian_tagihan">

                    </tbody>
                </table>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-sm btn-outline-danger px-5 mb-3" type="button" id="TambahBaris">Tambah <i class="fa-fw fa-solid fa-plus"></i></button>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless" width="100%">
                        <tr class="fs-4">
                            <td width="47%" class="text-end pe-5 pt-0">Total</td>
                            <td width="53%" class="pt-0" id="text_total_tagihan">Rp. 0</td>
                            <input type="hidden" name="total_tagihan" id="total_tagihan">
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <div class="d-grid gap-2 ms-2">
                        <button id="tombolSimpan" class="btn px-5 btn-outline-primary mt-4" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
                    </div>
                </div>
            </div>

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
        Baris += "<select class='form-select' name='id_keakun[]' id='id_keakun" + Nomor + "' required></select>";
        Baris += "</td>";
        Baris += "<td>";
        Baris += "<input type='text' name='deskripsi[]' class='form-control' placeholder='Deskripsi'>";
        Baris += "</td>";
        Baris += "<td>";
        Baris += "<input type='number' name='jumlah_rincian_akun[]' class='form-control text-end jumlah_rincian_akun' id='jumlah_rincian_akun' value='0' required>";
        Baris += "</td>";
        Baris += "<td class='text-center'><a class='btn px-2 py-0 mt-2 btn btn-sm btn-outline-danger' id='HapusBaris' data-nomor='" + Nomor + "'><i class='fa-fw fa-solid fa-xmark'></i></a>";
        Baris += "</td>";
        Baris += "</tr>";

        $('#tabel tbody').append(Baris);

        FormSelectAkun(Nomor);
    }


    $(document).ready(function() {
        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });

        $(this).parent().parent().remove();
        var A;
        for (A = 1; A <= 1; A++) {
            Barisbaru();
        };

        $('#tabel').on('input', '#jumlah_rincian_akun', function() {
            hitungTotal();
        });
    })


    $('#TambahBaris').click(function(e) {
        e.preventDefault();
        Barisbaru();
    });


    $(document).on('click', '#HapusBaris', function(e) {
        e.preventDefault();
        $(this).parent().parent().hide();
        var nomor = $(this).attr('data-nomor');
        $('#id_keakun' + nomor).val('0');
        $('#id_keakun' + nomor).attr('required', false);
        hitungTotal();
    })


    function hitungTotal() {
        var text_total_tagihan = 0;
        $('#tabel .jumlah_rincian_akun').each(function() {
            var getValueJumlahRincian = parseInt($(this).val());
            if ($.isNumeric(getValueJumlahRincian)) {
                text_total_tagihan += getValueJumlahRincian;
            }
        });
        $("#text_total_tagihan").html(formatRupiah(text_total_tagihan));
        $("#total_tagihan").val(text_total_tagihan);
    }


    function FormSelectAkun(Nomor) {
        var output = [];
        output.push('<option value ="">Pilih Akun</option>');
        $.getJSON('<?= site_url('finance-tagihan/keakun') ?>', function(data) {
            $.each(data, function(key, value) {
                output.push('<option value="' + value.id + '">' + value.nama + ' (' + value.kode + ')' + '</option>');
            });
            $('#id_keakun' + Nomor).html(output.join(''));
        });
    }


    $('#form').submit(function(e) {
        e.preventDefault();
        var total_tagihan = $('#total_tagihan').val();
        if (total_tagihan == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Halah..',
                text: 'Total tagihan Rp. 0 lalu apa yamg mau ditagihkan?',
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

                        if (err.error_nomor) {
                            $('.error_nomor').html(err.error_nomor);
                            $('#no_tagihan').addClass('is-invalid');
                        } else {
                            $('.error_nomor').html('');
                            $('#no_tagihan').removeClass('is-invalid');
                            $('#no_tagihan').addClass('is-valid');
                        }
                        if (err.error_tanggal) {
                            $('.error_tanggal').html(err.error_tanggal);
                            $('#tanggal').addClass('is-invalid');
                        } else {
                            $('.error_tanggal').html('');
                            $('#tanggal').removeClass('is-invalid');
                            $('#tanggal').addClass('is-valid');
                        }
                        if (err.error_penerima) {
                            $('.error_penerima').html(err.error_penerima);
                            $('#penerima').addClass('is-invalid');
                        } else {
                            $('.error_penerima').html('');
                            $('#penerima').removeClass('is-invalid');
                            $('#penerima').addClass('is-valid');
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