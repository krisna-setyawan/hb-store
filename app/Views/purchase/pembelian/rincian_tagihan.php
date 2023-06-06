<div class="table-responsive">
    <table class="table table-sm table-bordered" width="100%">
        <thead>
            <tr>
                <th class="text-center" width="5%">#</th>
                <th class="text-center" width="65%">Nama Rincian</th>
                <th class="text-center" width="30%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($rincian as $rnc) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $rnc['nama_rincian'] ?></td>
                    <td>Rp. <?= number_format($rnc['jumlah'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>