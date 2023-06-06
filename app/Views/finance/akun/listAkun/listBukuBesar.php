
<?php   
    $saldoSebelum   = 0;
?>
<?php foreach ($saldoAwal as $sa) : ?>
    <?= 
        $saldoSebelum  += (float)$sa['debit']*(float)$sa['ktdebit'];
        $saldoSebelum  += (float)$sa['kredit']*(float)$sa['ktkredit'];
    ?>
<?php endforeach; ?>
<tr>
    <td colspan="3"><h5>Saldo Awal</h5></td>
    <td class="text-end pe-4 py-2">Rp. <?= number_format($saldoSebelum, 0, ',', '.') ?></td>
    <td class="text-end pe-4 py-2">-</td>
    <td class="text-end pe-4 py-2">-</td>
</tr>


<?php 
    $saldo       = $saldoSebelum;
    $totalDebit  = 0; 
    $totalKredit = 0;  
    $saldoAwal   = 0;
?>
<?php foreach ($bukuAkun as $ba) : ?>
<?= 
    $totalDebit  += $ba['debit'];
    $totalKredit += $ba['kredit']; 
    $saldo  += (float)$ba['debit']*(float)$ba['ktdebit'];
    $saldo  += (float)$ba['kredit']*(float)$ba['ktkredit'];
?>
<tr>
    <td><?= $ba['tanggal'] ?></td>
    <td><?= $ba['nomor'] ?></td>
    <td><?= $ba['referensi'] ?></td>
    <td class="text-end pe-4 py-2">Rp. <?= number_format($ba['debit'], 0, ',', '.') ?></td>
    <td class="text-end pe-4 py-2">Rp. <?= number_format($ba['kredit'], 0, ',', '.') ?></td>
    <td class="text-end pe-4 py-2">Rp. <?= number_format($saldo, 0, ',', '.') ?></td>
</tr>
<?php endforeach; ?>    
            
<tr>
    <td colspan="3"><h5>Saldo Akhir</h5></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalDebit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalKredit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($saldo, 0, ',', '.') ?></td>
</tr>
<tr>
    <td colspan="6"></td>
</tr>
<tr>
    <td colspan="3"><h5>Total</h5></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalDebit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2">Rp. <?= number_format($totalKredit, 0, ',', '.') ?></td>
    <td class="text-end fw-bold pe-4 py-2"></td>
</tr>