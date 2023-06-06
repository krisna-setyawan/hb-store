<div class="row">

    <div class="col-md-6">

        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">No Penjualan</div>
            </div>
            <div class="col-md-9">
                <?= $penjualan['no_penjualan'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Tanggal</div>
            </div>
            <div class="col-md-9">
                <?= $penjualan['tanggal'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Customer</div>
            </div>
            <div class="col-md-9">
                <?= $penjualan['customer'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Admin</div>
            </div>
            <div class="col-md-9">
                <?= $penjualan['admin'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Status</div>
            </div>
            <div class="col-md-9">
                <?= $penjualan['status'] ?>
            </div>
        </div>

    </div>


    <div class="col-md-6">

        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Alamat Kirim</div>
            </div>
            <div class="col-md-9">
                <p class="mb-0" id="text-nama_alamat"><?= $penjualan['nama_alamat'] ?></p>
                <p class="mb-0" id="text-alamat"><?= $penjualan['detail_alamat'] ?>, <?= $penjualan['kelurahan'] ?>, <?= $penjualan['kecamatan'] ?>, <?= $penjualan['kota'] ?>, <?= $penjualan['provinsi'] ?></p>
                <p class="mb-0" id="text-penerima">Penerima : <?= $penjualan['penerima'] ?></p>
                <p class="mb-0" id="text-telp">Telp : <?= $penjualan['no_telp'] ?></p>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Catatan</div>
            </div>
            <div class="col-md-9">
                <?= $penjualan['catatan'] ?>
            </div>
        </div>

    </div>

</div>


<br>


<div class="table-responsive">
    <table class="table table-sm table-bordered" width="100%" id="tabel">
        <thead>
            <tr>
                <th class="text-center" width="3%">#</th>
                <th class="text-center" width="11%">SKU</th>
                <th class="text-center" width="25%">Produk</th>
                <th class="text-center" width="11%">Satuan</th>
                <th class="text-center" width="5%">Qty</th>
                <th class="text-center" width="11%">Add Cost</th>
                <th class="text-center" width="11%">Diskon</th>
                <th class="text-center" width="11%">Note</th>
                <th class="text-center" width="12%">Total</th>
            </tr>
        </thead>
        <tbody id="tabel_list_produk">
            <?php
            $no = 1;
            foreach ($penjualan_detail as $pr) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $pr['sku'] ?></td>
                    <td><?= $pr['produk'] ?></td>
                    <td>Rp. <?= number_format($pr['harga_satuan'], 0, ',', '.') ?></td>
                    <td><?= $pr['qty'] ?></td>
                    <td>Rp. <?= number_format($pr['biaya_tambahan'], 0, ',', '.') ?></td>
                    <td>Rp. <?= number_format($pr['diskon'], 0, ',', '.') ?></td>
                    <td><?= $pr['catatan'] ?></td>
                    <td>Rp. <?= number_format($pr['total_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="8" class="text-end pe-4 py-2">Ongkir</td>
                <td class="py-2">Rp. <?= number_format($penjualan['ongkir'], 0, ',', '.')  ?></td>
            </tr>
            <tr>
                <td colspan="8" class="text-end pe-4 py-2">Diskon</td>
                <td class="py-2">- Rp. <?= number_format($penjualan['diskon'], 0, ',', '.')  ?></td>
            </tr>
            <tr class="fs-5">
                <td colspan="8" class="text-end fw-bold pe-4 py-2">Grand Total</td>
                <td class="py-2">Rp. <?= number_format($penjualan['grand_total'], 0, ',', '.')  ?></td>
            </tr>
        </tbody>
    </table>
</div>