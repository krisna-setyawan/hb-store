<tr style="background-color: #e6e8fa;">
    <td>
        <div class="me-auto mb-1">
            <h3>Asset</h3>
        </div>
    </td>

    <td class="text-end">
        <div class="me-2 mb-1">
            <h4><?= $tglNeraca ?></h4>
        </div>
    </td>
</tr>
<tr>
    <th width="21%">
        <h5>Kas & Bank</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalKas = 0; ?>
<?php foreach ($assetKas as $ak) : ?>
    <?= $totalKas += $ak['debit'] - $ak['kredit']; ?>

    <tr>
        <td><?= $ak['kode'] ?>-<?= $ak['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($ak['debit'] - $ak['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

</tr>
<tr>
    <td class="fw-bold">
        <h5>Total Kas & Bank</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalKas, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <th width="21%">
        <h5>Piutang</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalPiutang = 0; ?>
<?php foreach ($assetPiutang as $ap) : ?>
    <?= $totalPiutang += $ap['debit'] - $ap['kredit']; ?>

    <tr>
        <td><?= $ap['kode'] ?>-<?= $ap['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($ap['debit'] - $ap['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5>Total Piutang</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalPiutang, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <th width="21%">
        <h5>Persediaan</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalPersediaan = 0; ?>
<?php foreach ($assetPersediaan as $aper) : ?>
    <?= $totalPersediaan += $aper['debit'] - $aper['kredit']; ?>
    <tr>
        <td><?= $aper['kode'] ?>-<?= $aper['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($aper['debit'] - $aper['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5>Total Persediaan</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalPersediaan, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <th width="21%">
        <h5>Aktiva Lancar Lainnya</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalAktivaLancar = 0; ?>
<?php foreach ($assetAktivaLancar as $aal) : ?>
    <?= $totalAktivaLancar += $aal['debit'] - $aal['kredit']; ?>
    <tr>
        <td><?= $aal['kode'] ?>-<?= $aal['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($aal['debit'] - $aal['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5>Total Aktiva Lancar Lainnya</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalAktivaLancar, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <th width="21%">
        <h5>Aktiva Tetap</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalAktivaTetap = 0; ?>
<?php foreach ($assetAktivaTetap as $aat) : ?>
    <?= $totalAktivaTetap += $aat['debit'] - $aat['kredit']; ?>
    <tr>
        <td><?= $aat['kode'] ?>-<?= $aat['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($aat['debit'] - $aat['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5>Total Aktiva Tetap</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalAktivaTetap, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <th width="21%">
        <h5>Depresiasi dan Amortisasi</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalDepresiasiAmortisasi = 0; ?>
<?php foreach ($assetDepresiasiAmortisasi as $ada) : ?>
    <?= $totalDepresiasiAmortisasi += $ada['debit'] - $ada['kredit']; ?>
    <tr>
        <td><?= $ada['kode'] ?>-<?= $ada['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($ada['debit'] - $ada['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5>Total Depresiasi dan Amortisasi</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalDepresiasiAmortisasi, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <th width="21%">
        <h5>Aktiva Lainnya</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalAktivaLainnya = 0; ?>
<?php foreach ($assetAktivaLainnya as $al) : ?>
    <?= $totalAktivaLainnya += $al['debit'] - $al['kredit']; ?>
    <tr>
        <td><?= $al['kode'] ?>-<?= $al['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($al['debit'] - $al['kredit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5> Total Aktiva Lainnya</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalAktivaLainnya, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <td class="fw-bold">
        <h4>Total Asset</h4>
    </td>
    <td class="text-end">
        <h4>Rp. <?= number_format($totalKas + $totalPiutang + $totalPersediaan + $totalAktivaLancar + $totalAktivaTetap + $totalDepresiasiAmortisasi + $totalAktivaLainnya, 0, ',', '.') ?></h4>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr style="background-color: #e6e8fa;">
    <td>
        <div class="me-auto mb-1">
            <h3>Hutang</h3>
        </div>
    </td>

    <td class="text-end">
        <div class="me-2 mb-1">
            <h4><?= $tglNeraca ?></h4>
        </div>
    </td>
</tr>
<tr>
    <th width="21%">
        <h5>Akun Hutang</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalAkunHutang = 0; ?>
<?php foreach ($hutangAkun as $ha) : ?>
    <?= $totalAkunHutang += $ha['kredit'] - $ha['debit']; ?>
    <tr>
        <td><?= $ha['kode'] ?>-<?= $ha['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($ha['kredit'] - $ha['debit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5>Total Akun Hutang</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalAkunHutang, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <th width="21%">
        <h5>Kewajiban Lancar Lainnya</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalKewajibanLancar = 0; ?>
<?php foreach ($hutangKewajibanLancar as $hkl) : ?>
    <?= $totalKewajibanLancar += $hkl['kredit'] - $hkl['debit']; ?>
    <tr>
        <td><?= $hkl['kode'] ?>-<?= $hkl['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($hkl['kredit'] - $hkl['debit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5>Total Kewajiban Lancar Lainnya</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalKewajibanLancar, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <th width="21%">
        <h5>Kewajiban Jangka Panjang</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalKewajibanPanjang = 0; ?>
<?php foreach ($hutangKewajibanPanjang as $hkp) : ?>
    <?= $totalKewajibanPanjang += $hkp['kredit'] - $hkp['debit']; ?>
    <tr>
        <td><?= $hkp['kode'] ?>-<?= $hkp['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($hkp['kredit'] - $hkp['debit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5>Total Kewajiban Jangka Panjang</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalKewajibanPanjang, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <td class="fw-bold">
        <h4>Total Hutang</h4>
    </td>
    <td class="text-end">
        <h4>Rp. <?= number_format($totalAkunHutang + $totalKewajibanLancar + $totalKewajibanPanjang, 0, ',', '.') ?></h4>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr style="background-color: #e6e8fa;">
    <td>
        <div class="me-auto mb-1">
            <h3>Modal</h3>
        </div>
    </td>

    <td class="text-end">
        <div class="me-2 mb-1">
            <h4><?= $tglNeraca ?></h4>
        </div>
    </td>
</tr>

<tr>
    <th width="21%">
        <h5>Ekuitas</h5>
    </th>
    <th width="15%"></th>
</tr>

<?= $totalEkuitas = 0; ?>
<?php foreach ($modalEkuitas as $me) : ?>
    <?= $totalEkuitas += $me['kredit'] - $me['debit']; ?>
    <tr>
        <td><?= $me['kode'] ?>-<?= $me['nama'] ?></td>
        <td class="text-end">Rp. <?= number_format($me['kredit'] - $me['debit'], 0, ',', '.') ?></td>
    </tr>
<?php endforeach; ?>

<tr>
    <td class="fw-bold">
        <h5>Total Ekuitas</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($totalEkuitas, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
</tr>

<tr>
    <th width="21%">
        <h5>Perubahan Modal</h5>
    </th>
    <th width="15%"></th>
</tr>

<tr>
    <td>Pendapatan sampai periode terakhir</td>
    <td class="text-end">Rp. <?= number_format($labaBersihSebelum, 0, ',', '.') ?></td>
</tr>

<tr>
    <td>Pendaptan periode ini</td>
    <td class="text-end">Rp. <?= number_format($labaBersih, 0, ',', '.') ?></td>
</tr>

<tr>
    <td class="fw-bold">
        <h5>Total Perubahan Modal</h5>
    </td>
    <td class="text-end">
        <h5>Rp. <?= number_format($labaBersihSebelum - $labaBersih, 0, ',', '.') ?></h5>
    </td>
</tr>

<tr>
    <td class="fw-bold">
        <h4>Total Modal</h4>
    </td>
    <td class="text-end">
        <h4>Rp. <?= number_format($totalEkuitas, 0, ',', '.') ?></h4>
    </td>
</tr>