<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">Nama Gudang</div>
        </div>
        <div class="col-md-9">
            <?= $gudang['nama'] ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">Alamat</div>
        </div>
        <div class="col-md-9">
            <p class="mb-0"><?= $gudang['detail_alamat'] ?>, <?= $gudang['kelurahan'] ?>, <?= $gudang['kecamatan'] ?>, <?= $gudang['kota'] ?>, <?= $gudang['provinsi'] ?></p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <div class="fw-bold">Telepon</div>
        </div>
        <div class="col-md-9">
            <?= $gudang['no_telp'] ?>
        </div>
    </div>

    <hr class="my-4">

    <?php foreach ($pj as $pj) : ?>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="fw-bold">Penanggung Jawab <?= $pj['urutan'] ?></div>
            </div>
            <div class="col-md-9">
                <?= $pj['nama_pj'] ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>