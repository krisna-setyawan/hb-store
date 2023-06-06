<?= $this->include('MyLayout/css') ?>


<div class="mb-4 d-flex justify-content-between">
    <div class="mt-2">
        <h5>Transaksi <?= $akun['nama'] ?> (<?= $akun['kode'] ?>)</h5>
    </div>

    <div class="col-md-3">
        <div class="input-group mb-3">
            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
            <input type="text" class="form-control text-center" id="tglAwal" name="tglAwal" onchange="loadTable()" value="<?= $tglAwal ?>">
            <span class="input-group-text"><i class="fa-solid fa-repeat"></i></span>
            <input type="text" class="form-control text-center" id="tglAkhir" name="tglAkhir" onchange="loadTable()" value="<?= $tglAkhir ?>">
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered" width="100%" id="tabelBuku">
        <thead style="background-color: #C6ECB6;" class="border-secondary text-center">
            <tr>
                <th width="10%">Tanggal</th>
                <th width="20%">Nomor</th>
                <th width="25%">Reference</th>
                <th width="15%">Debit</th>
                <th width="15%">Kredit</th>
                <th width="15%">Saldo Berjalan</th>
            </tr>
        </thead>
        <tbody id="tabelBukuBesar">

        </tbody>
    </table>
</div>
<?= $this->include('MyLayout/js') ?>
<script>
    $(document).ready(function() {
        $('#tglAwal').datepicker({
            format: "yyyy-mm-dd"
        });
        $('#tglAkhir').datepicker({
            format: "yyyy-mm-dd"
        });


        loadTable();
    })

    function loadTable() {
        var idAkun = <?= $akun['id'] ?>;
        var tglAwal = $('#tglAwal').val();
        var tglAkhir = $('#tglAkhir').val();
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>finance-listBuku',
            data: 'idAkun=' + idAkun +
                '&tglAwal=' + tglAwal +
                '&tglAkhir=' + tglAkhir,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#tabelBukuBesar').html(response.data);
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }
</script>