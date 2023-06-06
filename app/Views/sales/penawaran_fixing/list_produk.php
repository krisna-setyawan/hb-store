<?php
$no = 1;
foreach ($produk_penjualan as $pr) : ?>

    <?php
    if ($pr['stok'] < $pr['qty']) {
        $this_stok_kurang = true;
    } else {
        $this_stok_kurang = false;
    }
    ?>

    <tr style="vertical-align: middle;">
        <td><?= $no++ ?></td>
        <td><?= $pr['sku'] ?></td>
        <td><?= $pr['produk'] ?> <br> <small class="<?= ($this_stok_kurang == true) ? 'text-danger' : 'text-secondary' ?>">stok : <?= (!$pr['stok']) ? '0' : $pr['stok'] ?> <?= $pr['satuan'] ?></small></td>
        <td>Rp. <?= number_format($pr['harga_satuan'], 0, ',', '.') ?></td>
        <td class="<?= ($this_stok_kurang == true) ? 'text-danger' : '' ?>"><?= $pr['qty'] ?></td>
        <td>Rp. <?= number_format($pr['biaya_tambahan'], 0, ',', '.') ?></td>
        <td>Rp. <?= number_format($pr['diskon'], 0, ',', '.') ?></td>
        <td>Rp. <?= number_format($pr['total_harga'], 0, ',', '.') ?></td>

        <td class=" text-center">

            <button onclick="edit(<?= $pr['id'] ?>, <?= $pr['qty'] ?>, <?= $pr['biaya_tambahan'] ?>, <?= $pr['diskon'] ?>, '<?= $pr['catatan'] ?>')" title="Edit" type="button" class="px-2 py-0 btn btn-sm btn-outline-primary"><i class="fa-fw fa-solid fa-pencil"></i></button>

            <form id="form_delete" method="POST" class="d-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id_penjualan" value="<?= $pr['id_penjualan'] ?>">
            </form>
            <button onclick="confirm_delete(<?= $pr['id'] ?>)" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-xmark"></i></button>

        </td>
    </tr>
<?php endforeach; ?>
<tr class="fs-5">
    <td colspan="7" class="text-end fw-bold pe-4 py-2">Total</td>
    <td colspan="2" class="py-2">Rp. <?= number_format($penjualan['total_harga_produk'], 0, ',', '.')  ?></td>
</tr>



<script>
    $(document).ready(function() {
        $('.harga_satuan').mask('000.000.000', {
            reverse: true
        });
        $('.biaya_tambahan').mask('000.000.000', {
            reverse: true
        });
        $('.diskon').mask('000.000.000', {
            reverse: true
        });
    })

    function confirm_delete(id) {
        Swal.fire({
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus produk ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_delete').attr('action', '<?= site_url() ?>sales-fixing_produk_delete/' + id);
                $('#form_delete').submit();
            }
        })
    }

    function edit(id, qty, biaya_tambahan, diskon, catatan) {
        const formated_biaya_tambahan = new Intl.NumberFormat('id-ID').format(biaya_tambahan);
        const formated_diskon = new Intl.NumberFormat('id-ID').format(diskon);
        $('#id_list_produk').val(id);
        $('#new_qty').val(qty);
        $('#new_biaya_tambahan').val(formated_biaya_tambahan);
        $('#new_diskon').val(formated_diskon);
        $('#new_catatan').val(catatan);
        $('#btn-update_list_produk').attr('onclick', 'update_produk(' + id + ')')
        $('#my-modal').modal('toggle')
    }

    function update(id) {
        $.ajax({
            url: "<?= site_url() ?>sales-fixing_produk_update/" + id,
            type: 'PUT',
            data: JSON.stringify({
                id_penjualan: '<?= $penjualan['id'] ?>',
                id_list_produk: $('#id_list_produk').val(),
                new_qty: $('#new_qty').val(),
                new_biaya_tambahan: $('#new_biaya_tambahan').val(),
                new_diskon: $('#new_diskon').val(),
                new_catatan: $('#new_catatan').val()
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil update list produk penjualan'
                    })
                    load_list();
                    update_grand_total(response.total_harga_produk);
                    $('#my-modal').modal('hide');
                } else {
                    alert('terjadi error update list produk')
                    console.log(response)
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                alert('Error: ' + errorThrown);
            }
        });
    }
</script>