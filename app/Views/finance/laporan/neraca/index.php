<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Neraca</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>finance-laporan">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row justify-content-end">
        <div class="col-md-2">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                <input type="text" class="form-control text-center" id="tglNeraca" name="tglNeraca" onchange="loadTableNeraca()" value="<?= $tglNeraca ?>">
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover" width="100%" id="tabelNeraca">
            <tbody id="tabelListNeraca">

            </tbody>
        </table>
    </div>
</main>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $('#tglNeraca').datepicker({
            format: "yyyy-mm-dd"
        });

        loadTableNeraca();
    })


    function loadTableNeraca() {
        var tglNeraca = $('#tglNeraca').val();
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>finance-listNeraca',
            data: 'tglNeraca=' + tglNeraca,
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('#tabelListNeraca').html(response.data);
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }
</script>
<?= $this->endSection() ?>