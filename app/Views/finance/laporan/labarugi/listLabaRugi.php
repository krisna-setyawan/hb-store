<?= $totalPendapatan = 0;
    $totalPendapatanLainnya = 0;
    $totalHargaPokok = 0;
    $totalBeban = 0; 
    $totalBebanLainnya = 0; 
?>
<tr style="background-color: #e6e8fa;">
    <td>
        <div class="me-auto mb-1">
            <h3>Pendapatan</h3>
        </div>
    </td>

    <td class="text-end">
        <div class="me-2 mb-1">
            <h4><?= $tglAkhir ?></h4>
        </div>
    </td>
</tr>

<tr>
    <th width="21%">
        <h5>Pendapatan</h5>
    </th>
    <th width="15%"></th>
</tr>

<?php foreach ($pendapatanPendapatan as $pp) : ?>
    <?= $totalPendapatan += $pp['kredit'] - $pp['debit']; ?>

    <tr>
        <td><?= $pp['kode'] ?>-<?= $pp['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($pp['kredit'] - $pp['debit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <th width="21%">
        <h5>Pendapatan Lainnya</h5>
    </th>
    <th width="15%"></th>
</tr>

<?php foreach ($pendapatanLainnya as $pl) : ?>
    <?= $totalPendapatanLainnya += $pl['kredit'] - $pl['debit']; ?>

    <tr>
        <td><?= $pl['kode'] ?>-<?= $pl['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($pl['kredit'] - $pl['debit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h4>Total Pendapatan</h4>
    </td>
    <td class="text-end">
        <h4>Rp. <?= number_format($totalPendapatan + $totalPendapatanLainnya, 0, ',', '.') ?></h4>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr style="background-color: #e6e8fa;">
    <td>
        <div class="me-auto mb-1">
            <h3>Beban</h3>
        </div>
    </td>

    <td class="text-end">
        <div class="me-2 mb-1">
            <h4><?= $tglAkhir ?></h4>
        </div>
    </td>
</tr>

<tr>
    <th width="21%">
        <h5>Harga Pokok Penjualan</h5>
    </th>
    <th width="15%"></th>
</tr>

<?php foreach ($bebanHargaPokok as $bhp) : ?>
    <?= $totalHargaPokok += $bhp['debit'] - $bhp['kredit']; ?>

    <tr>
        <td><?= $bhp['kode'] ?>-<?= $bhp['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($bhp['debit'] - $bhp['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h4>Total Beban</h4>
    </td>
    <td class="text-end">
        <h4>Rp. <?= number_format($totalHargaPokok, 0, ',', '.') ?></h4>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<?= $labaKotor = ($totalPendapatan + $totalPendapatanLainnya) - $totalHargaPokok; ?>

<tr style="background-color: #e6e8fa;">
    <td>
        <div class="me-auto mb-1">
            <h3>Laba Kotor</h3>
        </div>
    </td>

    <td class="text-end">
        <div class="me-2 mb-1">
            <h4>Rp. <?= number_format($labaKotor, 0, ',', '.') ?></h4>
        </div>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr style="background-color: #e6e8fa;">
    <td>
        <div class="me-auto mb-1">
            <h3>Biaya</h3>
        </div>
    </td>

    <td class="text-end">
        <div class="me-2 mb-1">
            <h4><?= $tglAkhir ?></h4>
        </div>
    </td>
</tr>

<tr>
    <th width="21%">
        <h5>Beban</h5>
    </th>
    <th width="15%"></th>
</tr>

<?php foreach ($biayaBeban as $bb) : ?>
    <?= $totalBeban += $bb['debit'] - $bb['kredit']; ?>

    <tr>
        <td><?= $bb['kode'] ?>-<?= $bb['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($bb['debit'] - $bb['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <th width="21%">
        <h5>Beban Lainnya</h5>
    </th>
    <th width="15%"></th>
</tr>

<?php foreach ($biayaBebanLainnya as $bbl) : ?>
    <?= $totalBebanLainnya += $bbl['debit'] - $bbl['kredit']; ?>

    <tr>
        <td><?= $bbl['kode'] ?>-<?= $bbl['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($bbl['debit'] - $bbl['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h4>Total Biaya</h4>
    </td>
    <td class="text-end">
        <h4>Rp. <?= number_format($totalBeban + $totalBebanLainnya, 0, ',', '.') ?></h4>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<?= $labaBersih = $labaKotor - ($totalBeban + $totalBebanLainnya); ?>
<tr style="background-color: #e6e8fa;">
    <td>
        <div class="me-auto mb-1">
            <h3>Laba Bersih</h3>
        </div>
    </td>

    <td class="text-end">
        <div class="me-2 mb-1">
            <h4>Rp. <?= number_format($labaBersih, 0, ',', '.') ?></h4>
        </div>
    </td>
</tr>