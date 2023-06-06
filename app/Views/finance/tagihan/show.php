<div class="mb-4 d-flex justify-content-between">
    <div class="mt-1">
        <p class="mb-2"> Nomor <b> <?= $tagihan['no_tagihan'] ?> </b></p>
        <p class="mb-2"> Tanggal <b> <?= $tagihan['tanggal'] ?> </b></p>
    </div>
    <div class="mt-1 text-right me-4">
        Penerima <h5> <b> <?= $tagihan['penerima'] ?> </b></h5>
    </div>
</div>

<hr>

<div class="table-responsive">
    <table class="table table-hover table-bordered" width="100%" id="tabel">
        <thead style="background-color: #F5B7B1;" class="text-center border-secondary">
            <tr>
                <th width="3%">No</th>
                <th width="77%">Nama Rincian</th>
                <th width="20%">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($tagihanRincian as $dt) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $dt['nama_rincian'] ?></td>
                    <td class="text-end pe-4 py-2">Rp. <?= number_format($dt['jumlah'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fs-5">
                <td colspan="2" class="text-end pe-4">Total Tagihan</td>
                <td class="text-end pe-4">Rp. <?= number_format($tagihan['jumlah'], 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <h5 class="mt-4">Pembayaran</h5>
    <?php if ($pembayaran) : ?>
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead style="background-color: #83CBCD; border: #566573;">
                <tr>
                    <th class="text-center" width="20%">Pembayaran</th>
                    <th class="text-center" width="15%">Tanggal</th>
                    <th class="text-center" width="27%">Akun Pembayaran</th>
                    <th class="text-center" width="18%">Admin</th>
                    <th class="text-center" width="20%">Jumlah Bayar</th>
                </tr>
            </thead>
            <tbody id="list_rincian_tagihan">
                <?php
                $no = 1;
                $total_pembayaran = 0;
                foreach ($pembayaran as $pb) {
                    $total_pembayaran += $pb['jumlah_bayar'];
                ?>
                    <tr>
                        <td class="ps-3">Pembayaran ke - <?= $no++ ?></td>
                        <td class="ps-3"><?= $pb['tanggal_bayar'] ?></td>
                        <td class="ps-3"><?= $pb['akun'] ?></td>
                        <td class="ps-3"><?= $pb['admin'] ?></td>
                        <td class="text-end pe-4">Rp. <?= number_format($pb['jumlah_bayar'], 0, ',', '.') ?></td>
                    </tr>
                <?php } ?>
                <tr class="fs-5">
                    <td class="text-end pe-4" colspan="4">Total Pembayaran</td>
                    <td class="text-end pe-4 ">Rp. <?= number_format($total_pembayaran, 0, ',', '.') ?></td>
                </tr>
                <tr class="fs-5">
                    <td class="text-end pe-4" colspan="4">Sisa Tagihan</td>
                    <td class="text-end pe-4">Rp. <?= number_format($tagihan['sisa_tagihan'], 0, ',', '.') ?></td>
                </tr>
                <tr class="fs-5">
                    <td class="text-end pe-4" colspan="4">Status Tagihan</td>
                    <td class="text-end pe-4 <?= ($tagihan['status'] == 'Lunas') ? 'text-success' : 'text-danger' ?>"><?= $tagihan['status'] ?></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
</div>