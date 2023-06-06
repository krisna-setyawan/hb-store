<div class="table-responsive">
    <table class="table table-sm table-bordered" width="100%">
        <thead>
            <tr>
                <th class="text-center" width="4%">#</th>
                <th class="text-center" width="36%">Produk</th>
                <th class="text-center" width="15%">Beli</th>
                <th class="text-center" width="15%">Sudah Dikirim</th>
                <th class="text-center" width="15%">Kirim Sekarang</th>
                <th class="text-center" width="15%">Kurang</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($list_produk as $produk) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $produk['produk'] ?></td>
                    <td class="text-center"><?= $produk['qty_beli'] ?></td>
                    <td class="text-center"><?= $produk['qty_dikirim_sebelumnya'] ?></td>
                    <td class="text-center"><?= $produk['qty_dikirim_sekarang'] ?></td>
                    <td class="text-center"><?= $produk['qty_kurang'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>