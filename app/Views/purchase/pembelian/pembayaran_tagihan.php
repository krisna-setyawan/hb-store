<div class="table-responsive">
    <table class="table table-sm table-bordered" width="100%">
        <thead>
            <tr>
                <th class="text-center" width="5%">#</th>
                <th class="text-center" width="20%">Tanggal</th>
                <th class="text-center" width="45%">Admin Pembayaran</th>
                <th class="text-center" width="30%">Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($pembayaran as $rnc) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $rnc['tanggal_bayar'] ?></td>
                    <td><?= $rnc['admin'] ?></td>
                    <td>Rp. <?= number_format($rnc['jumlah_bayar'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>