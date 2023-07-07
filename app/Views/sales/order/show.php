<div class="row">
    <div class="col-md-10">
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Customer</div>
            </div>
            <div class="col-md-9">
                <?= $order['nama_perusahaan'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">No Pemesanan Customer</div>
            </div>
            <div class="col-md-9">
                <?= $pemesanan['no_pemesanan'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Kode Transaksi</div>
            </div>
            <div class="col-md-9">
                <?= $pemesanan['kode_trx_api'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Tanggal</div>
            </div>
            <div class="col-md-9">
                <?= $pemesanan['tanggal'] ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="fw-bold">Status Order</div>
            </div>
            <div class="col-md-9">
                <?= $order['status'] ?>
            </div>
        </div>
    </div>
    <div class="col-md-2 text-start mt-2">
        <a onclick="terimaOrder(<?= $pemesanan['kode_trx_api'] ?>, '<?= $pemesanan['id_perusahaan'] ?>')">
            <button class="btn btn-success mb-1"><i class="fa-regular fa-pen-to-square"></i> Terima Order</button>
        </a>
    </div>
</div>

<br>


<div class="table-responsive">
    <table class="table table-sm table-bordered" width="100%" id="tabel">
        <thead>
            <tr>
                <th class="text-center" width="5%">#</th>
                <th class="text-center" width="15%">SKU</th>
                <th class="text-center" width="35%">Produk</th>
                <th class="text-center" width="20%">Satuan</th>
                <th class="text-center" width="5%">Qty</th>
                <th class="text-center" width="20%">Total</th>
            </tr>
        </thead>
        <tbody id="tabel_list_produk">
            <?php
            $no = 1;
            foreach ($list_produk as $pr) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $pr['sku'] ?></td>
                    <td><?= $pr['produk'] ?></td>
                    <td>Rp. <?= number_format($pr['harga_satuan'], 0, ',', '.') ?></td>
                    <td><?= $pr['qty'] ?></td>
                    <td>Rp. <?= number_format($pr['total_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fs-5">
                <td colspan="5" class="text-end fw-bold pe-4 py-2">Total Harga</td>
                <td class="py-2">Rp. <?= number_format($total_harga['total_harga'], 0, ',', '.')  ?></td>
            </tr>
        </tbody>
    </table>
</div>