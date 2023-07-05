    <?php
    $no = 1;
    foreach ($produk as $pr) : ?>
        <tr>
            <td onclick="addProduk(<?= $pr['id'] ?>, '<?= $pr['nama'] ?>', '<?= $pr['sku'] ?>')" class="text-center"><?= $no++ ?></td>
            <td onclick="addProduk(<?= $pr['id'] ?>, '<?= $pr['nama'] ?>', '<?= $pr['sku'] ?>')"><?= $pr['nama'] ?></td>
            <td onclick="addProduk(<?= $pr['id'] ?>, '<?= $pr['nama'] ?>', '<?= $pr['sku'] ?>')" class="text-center">-</td>
            <td onclick="addProduk(<?= $pr['id'] ?>, '<?= $pr['nama'] ?>', '<?= $pr['sku'] ?>')" class="text-center">-</td>
            <td onclick="addProduk(<?= $pr['id'] ?>, '<?= $pr['nama'] ?>', '<?= $pr['sku'] ?>')" class="text-center">-</td>
            <td onclick="addProduk(<?= $pr['id'] ?>, '<?= $pr['nama'] ?>', '<?= $pr['sku'] ?>')" class="text-center">-</td>
            <td onclick="addProduk(<?= $pr['id'] ?>, '<?= $pr['nama'] ?>', '<?= $pr['sku'] ?>')" class="text-center">-</td>
            <td onclick="addProduk(<?= $pr['id'] ?>, '<?= $pr['nama'] ?>', '<?= $pr['sku'] ?>')" class="text-center"><?= $pr['stok'] ?></td>
        </tr>
    <?php endforeach; ?>

    <script>
        function addProduk(id_produk, produk, sku) {
            let jenis_supplier = $('#jenis_supplier').val();

            if (jenis_supplier == 'Haebot') {
                let supplier = $('#supplier').val();
                let id_perusahaan = $('#id_perusahaan').val();

                $.ajax({
                    type: "post",
                    url: "<?= site_url() ?>purchase-validate_produk_api",
                    data: 'sku=' + sku + '&id_perusahaan=' + id_perusahaan,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 'ok') {
                            $('#produk').val(produk);
                            $('#id_produk').val(id_produk);

                            $('#my-modal').modal('hide')
                        } else {
                            Swal.fire(
                                'Opss.',
                                'Maaf ' + response.message,
                                'error'
                            )
                        }
                    },
                    error: function(e) {
                        alert('Error \n' + e.responseText);
                    }
                });
            } else {
                $('#produk').val(produk);
                $('#id_produk').val(id_produk);

                $('#my-modal').modal('hide')
            }
        }
    </script>