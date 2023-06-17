<?php
$no = 1;
foreach ($list_produk_fixing as $pr) : ?>
    <tr style="vertical-align: middle;">
        <td><?= $no++ ?></td>
        <td><?= $pr['sku'] ?></td>
        <td><?= $pr['produk'] ?></td>
        <input id="id_produk_<?= $pr['id'] ?>" type="hidden" value="<?= $pr['id'] ?>">
        <td>
            <div hidden class="input-group" id="input_new_harga_satuan_<?= $pr['id'] ?>">
                <span class="input-group-text py-1 px-2" id="basic-addon1">Rp. </span>
                <input id="new_harga_satuan_<?= $pr['id'] ?>" type="text" class="form-control py-1 px-2 harga_satuan" value="<?= number_format($pr['harga_satuan'], 0, ',', '.') ?>">
            </div>
            <div id="text_harga_satuan_<?= $pr['id'] ?>">Rp. <?= number_format($pr['harga_satuan'], 0, ',', '.') ?></div>
        </td>
        <td>
            <input hidden id="new_qty_<?= $pr['id'] ?>" type="number" min="1" class="form-control py-1 px-3" value="<?= $pr['qty'] ?>">
            <div id="text_qty_<?= $pr['id'] ?>"><?= $pr['qty'] ?></div>
        </td>
        <td>Rp. <?= number_format($pr['total_harga'], 0, ',', '.') ?></td>
        <td class="text-center">

            <button hidden id="tombol_update_produk_<?= $pr['id'] ?>" onclick="update(<?= $pr['id'] ?>)" title="Update" type="button" class="px-2 py-0 btn btn-sm btn-outline-success"><i class="fa-fw fa-solid fa-check"></i></button>
            <button id="tombol_edit_produk_<?= $pr['id'] ?>" onclick="edit(<?= $pr['id'] ?>)" title="Edit" type="button" class="px-2 py-0 btn btn-sm btn-outline-primary"><i class="fa-fw fa-solid fa-pencil"></i></button>

            <form id="form_delete" method="POST" class="d-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id_pemesanan_fixing" value="<?= $pr['id_pemesanan_fixing'] ?>">
            </form>
            <button onclick="confirm_delete(<?= $pr['id'] ?>)" title="Hapus" type="button" class="px-2 py-0 btn btn-sm btn-outline-danger"><i class="fa-fw fa-solid fa-xmark"></i></button>

        </td>
    </tr>
<?php endforeach; ?>
<tr class="fs-5">
    <td colspan="5" class="text-end fw-bold pe-4 py-2">Total</td>
    <td colspan="2" class="py-2">Rp. <?= number_format($pemesananFixing['grand_total'], 0, ',', '.')  ?></td>
</tr>

<script>
    $(document).ready(function() {
        $('.harga_satuan').mask('000.000.000', {
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
                $('#form_delete').attr('action', '<?= site_url() ?>purchase-fixing_produk_delete/' + id);
                $('#form_delete').submit();
            }
        })
    }

    function edit(id) {
        $('#input_new_harga_satuan_' + id).attr('hidden', false);
        $('#new_qty_' + id).attr('hidden', false);
        $('#tombol_update_produk_' + id).attr('hidden', false);
        $('#text_harga_satuan_' + id).attr('hidden', true);
        $('#text_qty_' + id).attr('hidden', true);
        $('#tombol_edit_produk_' + id).attr('hidden', true);
    }

    function update(id) {
        $.ajax({
            url: "<?= site_url() ?>purchase-fixing_produk_update/" + id,
            type: 'PUT',
            data: JSON.stringify({
                id_pemesanan_fixing: '<?= $pemesananFixing['id'] ?>',
                new_harga_satuan: $('#new_harga_satuan_' + id).val(),
                new_qty: $('#new_qty_' + id).val()
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil update list produk pembelian'
                    })
                    load_list();
                    $('#input_new_harga_satuan_' + id).attr('hidden', true);
                    $('#new_qty_' + id).attr('hidden', true);
                    $('#tombol_update_produk_' + id).attr('hidden', true);
                    $('#text_harga_satuan_' + id).attr('hidden', false);
                    $('#text_qty_' + id).attr('hidden', false);
                    $('#tombol_edit_produk' + id).attr('hidden', false);
                    update_exw(response.exw);
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