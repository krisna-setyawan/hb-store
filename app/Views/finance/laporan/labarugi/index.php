<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Laba Rugi</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>finance-laporan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row justify-content-end">
        <div class="col-md-3">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                <input type="text" class="form-control text-center" id="tglAwalLaba" name="tglAwalLaba" onchange="loadTableLaba()" value="<?= $tglAwal ?>">
                <span class="input-group-text"><i class="fa-solid fa-repeat"></i></span>
                <input type="text" class="form-control text-center" id="tglAkhirLaba" name="tglAkhirLaba" onchange="loadTableLaba()" value="<?= $tglAkhir ?>">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" width="100%" id="tabelLabaRugi">
            <tbody id="tabelListLabaRugi">
            </tbody>
        </table>
    </div>


</main>

<?= $this->include('MyLayout/js') ?>
<script>
    $(document).ready(function() {
        $('#tglAwalLaba').datepicker({
            format: "yyyy-mm-dd"
        });
        $('#tglAkhirLaba').datepicker({
            format: "yyyy-mm-dd"
        });

        loadTableLaba();
    })


    function loadTableLaba() {
        var tglAwal = $('#tglAwalLaba').val();
        var tglAkhir = $('#tglAkhirLaba').val();
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>finance-listLabaRugi',
            data: 'tglAwal=' + tglAwal +
                '&tglAkhir=' + tglAkhir,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#tabelListLabaRugi').html(response.data);
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }
</script>
<?= $this->endSection() ?>