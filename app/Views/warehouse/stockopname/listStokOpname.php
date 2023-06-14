<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">List Produk Stok Opname</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>warehouse-stockopname/<?= $id_gudang ?>">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">



    <form autocomplete="off" class="row g-3" action="<?= site_url() ?>warehouse-addproduklistStockopname" method="POST" id="form">
        <div class="row mt-3 mb-4">
            <div class="col-md-4">
                <label for="idProduk" class="form-label mb-0">Produk</label>
                <select class="form-control" name="idProduk" id="idProduk">
                    <option value="">Pilih Produk</option>
                    <?php foreach ($produk as $pr) : ?>
                        <option value="<?= $pr['id_produk'] ?>"><?= $pr['nama'] ?></option>
                    <?php endforeach ?>
                </select>
                <div class="invalid-feedback error_idProduk"></div>
            </div>
            <div class="col-md-2">
                <label for="stokFisik" class="form-label mb-0">Stok Fisik</label>
                <input type="number" class="form-control" name="stokFisik" id="stokFisik">
                <div class="invalid-feedback error_stok"></div>
            </div>
            <div class="col-md-2">
                <label for="stokVirtual" class="form-label mb-0">Stok Virtual</label>
                <input type="text" class="form-control" name="stokVirtual" id="stokVirtual" readonly>
            </div>
            <div class="col-md-2">
                <label for="selisih" class="form-label mb-0">Selisih</label>
                <input type="text" class="form-control" name="selisih" id="selisih" readonly>
            </div>

            <input type="hidden" class="form-control" name="idStokOpname" id="idStokOpname" value="<?= $stok['id'] ?>">

            <div class="col-md-2 mt-4">
                <button class="btn btn-secondary px-2" type="submit" id="tambah_produk"><i class="fa-fw fa-solid fa-plus"></i> Tambah Produk</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead style="background-color: #9D8EE7;" class="text-center border-secondary">
                <tr>
                    <th class="text-center" width="5%">#</th>
                    <th class="text-center" width="25%">Produk</th>
                    <th class="text-center" width="15%">Jumlah Virtual</th>
                    <th class="text-center" width="15%">Jumlah Fisik</th>
                    <th class="text-center" width="15%">Selisih</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody id="tabel_list_produk">

            </tbody>
        </table>
    </div>

    <div class="text-start d-flex mt-2">
        <a class="btn px-5 btn btn-outline-dark me-2" href="<?= site_url() ?>warehouse-stockopname/<?= $id_gudang ?>">
            <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali ke List Stock Opname
        </a>
        <form autocomplete="off" action="<?= site_url() ?>warehouse-simpanstok" method="POST" id="formSelesai">
            <input type="hidden" class="form-control" name="idStokOpname" id="idStokOpname" value="<?= $stok['id'] ?>">
            <button id="tombolSimpan" type="button" class="btn px-5 btn-outline-primary">Simpan Stock Opname<i class="fa-fw fa-solid fa-check"></i></button>
        </form>
    </div>

</main>


<?= $this->include('MyLayout/js') ?>


<script>
    $(document).ready(function() {

        load_list();

        $("#idProduk").select2({
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


    function load_list() {
        var idStockOpname = $('#idStokOpname').val();
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>warehouse-list_stok_produk",
            data: 'idStockOpname=' + idStockOpname,
            dataType: "json",
            success: function(response) {
                $('#tabel_list_produk').html(response.list)
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
    }


    $('#idProduk').change(function() {
        let idProduk = $(this).val();

        if (idProduk != '') {
            $.ajax({
                type: 'get',
                url: '<?= site_url('warehouse-stokbyproduk') ?>',
                data: 'idProduk=' + idProduk,
                success: function(html) {
                    $('#stokVirtual').val(html);
                }
            })
        } else {
            $('#stokVirtual').val('');
        }
    })


    $('#stokFisik').on('input', function() {
        var stokVirtual = $('#stokVirtual').val();
        var stokFisik = $('#stokFisik').val();
        var selisih = stokFisik - stokVirtual;
        $("#selisih").val(selisih);
    });


    $('#form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('#tambah_produk').html('Tunggu <i class="fa-solid fa-spin fa-spinner"></i>');
                $('#tambah_produk').prop('disabled', true);
            },
            complete: function() {
                $('#tambah_produk').html('<i class="fa-fw fa-solid fa-plus"></i> Tambah Produk');
                $('#tambah_produk').prop('disabled', false);
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;

                    if (err.error_idProduk) {
                        $('.error_idProduk').html(err.error_idProduk);
                        $('#idProduk').addClass('is-invalid');
                    } else {
                        $('.error_idProduk').html('');
                        $('#idProduk').removeClass('is-invalid');
                        $('#idProduk').addClass('is-valid');
                    }
                    if (err.error_stok) {
                        $('.error_stok').html(err.error_stok);
                        $('#stokFisik').addClass('is-invalid');
                    } else {
                        $('.error_stok').html('');
                        $('#stokFisik').removeClass('is-invalid');
                        $('#stokFisik').addClass('is-valid');
                    }
                }
                if (response.success) {
                    Toast.fire({
                        icon: 'success',
                        title: response.success
                    })
                    $('#stokFisik').val('');
                    $('#stokVirtual').val('');
                    $('#selisih').val('');
                    $('#idProduk').val('').trigger('change');
                    load_list();
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        });
        return false
    })


    $('#tombolSimpan').click(function() {
        let idStockOpname = $('#idStokOpname').val();
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>warehouse-check_list_produk",
            data: 'idStockOpname=' + idStockOpname,
            dataType: "json",
            success: function(response) {
                if (response.ok) {
                    Swal.fire({
                        title: 'Konfirmasi?',
                        text: "Apakah yakin selesaikan stock opname ini ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lanjut!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#formSelesai').submit();
                        }
                    })
                } else {
                    Swal.fire(
                        'Opss.',
                        'Tidak ada produk dalam list produk stok opname!',
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