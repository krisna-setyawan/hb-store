<div class="mb-4 d-flex justify-content-between">
    <div class="mt-1">
        Transaksi <h5> <?= $transaksi['nomor_transaksi'] ?></h5>
    </div>
    <div class="mt-1 text-right">
        Tanggal <h5> <?= $transaksi['tanggal'] ?></h5>
    </div>
</div>

<hr>

<div class="table-responsive">
    <table class="table table-hover table-bordered" width="100%" id="tabel">
        <thead style="background-color: #F6DCA9;" class="text-center border-secondary">
            <tr>
                <th width="20%">Akun</th>
                <th width="50%">Deskripsi</th>
                <th width="15%">Debit</th>
                <th width="15%">Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($detail as $dt) : ?>
                <tr>
                    <td><?= $dt['kode'] ?>-<?= $dt['akun'] ?></td>
                    <td><?= $dt['deskripsi'] ?></td>
                    <td class="text-end pe-4 py-2">Rp. <?= number_format($dt['debit'], 0, ',', '.') ?></td>
                    <td class="text-end pe-4 py-2">Rp. <?= number_format($dt['kredit'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fs-5">
                <td colspan="2" class="text-end fw-bold pe-4 py-2">Total</td>
                <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($transaksi['total_transaksi'], 0, ',', '.') ?></td>
                <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($transaksi['total_transaksi'], 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>
</div>