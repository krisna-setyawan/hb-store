<!-- // loading ajax -->
<div id='ajax-wait' style="display: none; position: fixed; z-index: 1999">
    <img alt='loading...' src='<?= base_url() ?>assets/animated/loading.gif' width='50' height='50' />
</div>

<div class="col-md-4">
    <div class="input-group mt-2">
        <span class="me-4 mt-1 fs-5"> Cari Produk Lain (F1)</span>
        <input autocomplete="off" type="text" class="form-control" placeholder="Nama Produk atau SKU" id="input_produk_lain">
        <button class="btn btn-secondary px-2" type="button" id="cari_produk"><i class="fa-fw fa-solid fa-search"></i></button>
    </div>
</div>

<br>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" width="100%" id="table_cari_produk">
        <thead class="text-light" style="background-color: #3A98B9;">
            <tr>
                <th class="text-center" width="5%">#</th>
                <th class="text-center" width="34%">Produk</th>
                <th class="text-center" width="10%">Ratio</th>
                <th class="text-center" width="10%">AVGSL</th>
                <th class="text-center" width="10%">AVGBY</th>
                <th class="text-center" width="10%">Rate</th>
                <th class="text-center" width="11%">Last Buy</th>
                <th class="text-center" width="10%">Stok</th>
            </tr>
        </thead>
        <tbody id="list_produk_pencarian">
            <?php
            $no = 1;
            foreach ($produk_customer as $pr) : ?>
                <tr>
                    <td style="cursor: pointer;" onclick="addProdukCustomer(<?= $pr['id_produk'] ?>, '<?= $pr['produk'] ?>')" class="text-center"><?= $no++ ?></td>
                    <td style="cursor: pointer;" onclick="addProdukCustomer(<?= $pr['id_produk'] ?>, '<?= $pr['produk'] ?>')"><?= $pr['produk'] ?></td>
                    <td style="cursor: pointer;" onclick="addProdukCustomer(<?= $pr['id_produk'] ?>, '<?= $pr['produk'] ?>')" class="text-center">-</td>
                    <td style="cursor: pointer;" onclick="addProdukCustomer(<?= $pr['id_produk'] ?>, '<?= $pr['produk'] ?>')" class="text-center">-</td>
                    <td style="cursor: pointer;" onclick="addProdukCustomer(<?= $pr['id_produk'] ?>, '<?= $pr['produk'] ?>')" class="text-center">-</td>
                    <td style="cursor: pointer;" onclick="addProdukCustomer(<?= $pr['id_produk'] ?>, '<?= $pr['produk'] ?>')" class="text-center">-</td>
                    <td style="cursor: pointer;" onclick="addProdukCustomer(<?= $pr['id_produk'] ?>, '<?= $pr['produk'] ?>')" class="text-center">-</td>
                    <td style="cursor: pointer;" onclick="addProdukCustomer(<?= $pr['id_produk'] ?>, '<?= $pr['produk'] ?>')" class="text-center"><?= $pr['stok'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    // loading ajax
    $(document).ajaxStart(function() {
        $("#ajax-wait").css({
            left: ($(window).width() - 32) / 2 + "px", // 32 = lebar gambar
            top: ($(window).height() - 32) / 2 + "px", // 32 = tinggi gambar
            display: "block"
        })
    }).ajaxComplete(function() {
        $("#ajax-wait").fadeOut();
    });


    $(document).ready(function() {
        makeDatatable();
    })


    function makeDatatable() {
        $('#table_cari_produk').dataTable({
            "language": {
                "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "infoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "loadingRecords": "Sedang memuat...",
                "processing": "Sedang memproses...",
                "search": "Cari:",
                "zeroRecords": "Tidak ditemukan data yang sesuai",
            }
        });
    }


    function addProdukCustomer(id_produk, produk) {
        $('#produk').val(produk);
        $('#id_produk').val(id_produk);

        $('#my-modal').modal('hide')
    }

    $(document).on('keydown', function(event) {
        if (event.which == 112) { //cek apakah tombol yang ditekan adalah tombol f1
            event.preventDefault(); //mencegah perilaku default dari tombol f1 (biasanya membuka halaman help)
            $('#input_produk_lain').focus(); //mengatur fokus ke input dengan id "myInput"
        }
    });

    $('#cari_produk').click(function() {
        cari_produk();
    })

    $('#input_produk_lain').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            cari_produk();
        }
    });

    function cari_produk() {
        $('#table_cari_produk').DataTable().destroy();
        let input_produk_lain = $('#input_produk_lain').val();
        $.ajax({
            type: 'POST',
            url: '<?= site_url() ?>sales-find_produk_by_nama_sku',
            data: 'input_produk_lain=' + input_produk_lain,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#list_produk_pencarian').html(res.data)
                    makeDatatable();
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }
</script>