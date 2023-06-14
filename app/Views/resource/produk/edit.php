<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Edit Produk dan Stok</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>resource-produk">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row justify-content-between">

        <div class="col-md-6">

            <form id="form" autocomplete="off" class="row g-3 mt-2 mb-3" action="<?= site_url() ?>resource-produk/<?= $produk['id'] ?>" method="POST">

                <?= csrf_field() ?>

                <input type="hidden" name="_method" value="PUT">

                <div class="row mb-3">
                    <label for="nama" class="col-sm-3 col-form-label">Nama Produk</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= (validation_show_error('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama',  $produk['nama']); ?>">
                        <div class="invalid-feedback"> <?= validation_show_error('nama'); ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="sku" class="col-sm-3 col-form-label">SKU</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= (validation_show_error('sku')) ? 'is-invalid' : ''; ?>" id="sku" name="sku" value="<?= old('sku',  $produk['sku']); ?>">
                        <div class="invalid-feedback"> <?= validation_show_error('sku'); ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="id_kategori" class="col-sm-3 col-form-label">Kategori</label>
                    <div class="col-sm-9">
                        <select class="form-control <?= (validation_show_error('id_kategori')) ? 'is-invalid' : ''; ?>" name="id_kategori" id="id_kategori">
                            <?php foreach ($kategori as $kt) : ?>
                                <option <?= (old('id_kategori', $produk['id_kategori']) == $kt['id']) ? 'selected' : ''; ?> value="<?= $kt['id'] ?>-krisna-<?= $kt['nama'] ?>"><?= $kt['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback"> <?= validation_show_error('id_kategori'); ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="hs_code" class="col-sm-3 col-form-label">HS Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= (validation_show_error('hs_code')) ? 'is-invalid' : ''; ?>" id="hs_code" name="hs_code" value="<?= old('hs_code',  $produk['hs_code']); ?>">
                        <div class="invalid-feedback"> <?= validation_show_error('hs_code'); ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="satuan" class="col-sm-3 col-form-label">Satuan</label>
                    <div class="col-sm-9">
                        <select class="form-control <?= (validation_show_error('satuan')) ? 'is-invalid' : ''; ?>" name="satuan" id="satuan">
                            <option value=""></option>
                            <option <?= (old('satuan', $produk['satuan']) == "Unit") ? 'selected' : ''; ?> value="Unit">Unit</option>
                            <option <?= (old('satuan', $produk['satuan']) == "Pcs") ? 'selected' : ''; ?> value="Pcs">Pcs</option>
                        </select>
                        <div class="invalid-feedback"> <?= validation_show_error('satuan'); ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
                    <div class="col-sm-9">
                        <select class="form-control <?= (validation_show_error('tipe')) ? 'is-invalid' : ''; ?>" name="tipe" id="tipe">
                            <option value=""></option>
                            <option <?= (old('tipe', $produk['tipe']) == "SET") ? 'selected' : ''; ?> value="SET">SET</option>
                            <option <?= (old('tipe', $produk['tipe']) == "SINGLE") ? 'selected' : ''; ?> value="SINGLE">SINGLE</option>
                            <option <?= (old('tipe', $produk['tipe']) == "ECER") ? 'selected' : ''; ?> value="ECER">ECER</option>
                        </select>
                        <div class="invalid-feedback"> <?= validation_show_error('tipe'); ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="jenis" class="col-sm-3 col-form-label">Jenis</label>
                    <div class="col-sm-9">
                        <select class="form-control <?= (validation_show_error('jenis')) ? 'is-invalid' : ''; ?>" name="jenis" id="jenis">
                            <option value=""></option>
                            <option <?= (old('jenis', $produk['jenis']) == "Produk Fisik") ? 'selected' : ''; ?> value="Produk Fisik">Produk Fisik</option>
                            <option <?= (old('jenis', $produk['jenis']) == "Produk Digital") ? 'selected' : ''; ?> value="Produk Digital">Produk Digital</option>
                        </select>
                        <div class="invalid-feedback"> <?= validation_show_error('jenis'); ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="harga_jual" class="col-sm-3 col-form-label">Harga Jual</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="text" class="form-control <?= (validation_show_error('harga_jual')) ? 'is-invalid' : ''; ?>" id="harga_jual" name="harga_jual" value="<?= old('harga_jual',  $produk['harga_jual']); ?>">
                            <div class="invalid-feedback"> <?= validation_show_error('harga_jual'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="berat" class="col-sm-3 col-form-label">Berat</label>
                    <div class="col-sm-9">
                        <input type="number" min="0" class="form-control <?= (validation_show_error('berat')) ? 'is-invalid' : ''; ?>" id="berat" name="berat" value="<?= old('berat',  $produk['berat']); ?>">
                        <div class="invalid-feedback"> <?= validation_show_error('berat'); ?></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="panjang" class="col-sm-3 col-form-label">Ukuran</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-text">P</span>
                            <input type="number" min="0" class="form-control <?= (validation_show_error('panjang')) ? 'is-invalid' : ''; ?>" id="panjang" name="panjang" value="<?= old('panjang',  $produk['panjang']); ?>">
                            <div class="invalid-feedback"> <?= validation_show_error('panjang'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-text">L</span>
                            <input type="number" min="0" class="form-control <?= (validation_show_error('lebar')) ? 'is-invalid' : ''; ?>" id="lebar" name="lebar" value="<?= old('lebar',  $produk['lebar']); ?>">
                            <div class="invalid-feedback"> <?= validation_show_error('lebar'); ?></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-text">T</span>
                            <input type="number" min="0" class="form-control <?= (validation_show_error('tinggi')) ? 'is-invalid' : ''; ?>" id="tinggi" name="tinggi" value="<?= old('tinggi',  $produk['tinggi']); ?>">
                            <div class="invalid-feedback"> <?= validation_show_error('tinggi'); ?></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="minimal_penjualan" class="col-sm-3 col-form-label">Minimal Penjualan</label>
                    <div class="col-sm-9">
                        <input type="number" min="0" class="form-control <?= (validation_show_error('minimal_penjualan')) ? 'is-invalid' : ''; ?>" id="minimal_penjualan" name="minimal_penjualan" value="<?= old('minimal_penjualan',  $produk['minimal_penjualan']); ?>">
                        <div class="invalid-feedback"> <?= validation_show_error('minimal_penjualan'); ?></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="kelipatan_penjualan" class="col-sm-3 col-form-label">Kelipatan Penjualan</label>
                    <div class="col-sm-9">
                        <input type="number" min="0" class="form-control <?= (validation_show_error('kelipatan_penjualan')) ? 'is-invalid' : ''; ?>" id="kelipatan_penjualan" name="kelipatan_penjualan" value="<?= old('kelipatan_penjualan',  $produk['kelipatan_penjualan']); ?>">
                        <div class="invalid-feedback"> <?= validation_show_error('kelipatan_penjualan'); ?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status_marketing" class="col-sm-3 col-form-label">Marketing</label>
                    <div class="col-sm-9">
                        <select class="form-control <?= (validation_show_error('status_marketing')) ? 'is-invalid' : ''; ?>" name="status_marketing" id="status_marketing">
                            <option value=""></option>
                            <option <?= (old('status_marketing', $produk['status_marketing']) == "Belum desain") ? 'selected' : ''; ?> value="Belum desain">Belum desain</option>
                            <option <?= (old('status_marketing', $produk['status_marketing']) == "Sudah desain") ? 'selected' : ''; ?> value="Sudah desain">Sudah desain</option>
                            <option <?= (old('status_marketing', $produk['status_marketing']) == "Sudah dipost") ? 'selected' : ''; ?> value="Sudah dipost">Sudah dipost</option>
                        </select>
                        <div class="invalid-feedback"> <?= validation_show_error('status_marketing'); ?></div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="note" class="col-sm-3 col-form-label">Note</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control <?= (validation_show_error('note')) ? 'is-invalid' : ''; ?>" id="note" name="note" value="<?= old('note',  $produk['note']); ?>">
                        <div class="invalid-feedback"> <?= validation_show_error('note'); ?></div>
                    </div>
                </div>

                <div class="text-center">
                    <button id="tombolSimpan" class="btn px-5 btn-outline-primary" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
                </div>
            </form>

        </div>

        <div class="col-md-6 table-responsive">

            <?php if ($tipe == 'SET' || $tipe == 'SINGLE') { ?>

                <div class="d-flex mb-0">
                    <div class="me-auto">
                        <h5 class="mb-3 mt-2">List Produk Komponen</h5>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-secondary py-0 mt-2" data-bs-toggle="modal" data-bs-target="#modal-add-komponen">
                            Tambah Komponen <i class="fa-fw fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <?php if ($result == 'ok') { ?>

                    <table class="table table-bordered table-striped table-secondary">
                        <thead>
                            <tr class="text-center">
                                <th width="10%" width="10%">No</th>
                                <th width="30%">Produk</th>
                                <th width="20%">Stok</th>
                                <th width="20%">Butuh</th>
                                <th width="20%">Bisa membuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($virtual_stok as $vs) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $vs['nama_produk'] ?></td>
                                    <td class="text-center"><?= $vs['stok_bahan'] ?></td>
                                    <td class="text-center"><?= $vs['qty_bahan'] ?></td>
                                    <td class="text-center"><?= $vs['bisa_membuat'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php } else { ?>

                    <h2 class="text-center mt-2"><?= $result ?></h2>

                <?php } ?>

            <?php } else { ?>

                <div class="d-flex mb-0">
                    <div class="me-auto">
                        <h5 class="mb-3 mt-2">List Produk Set</h5>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-secondary py-0 mt-2" data-bs-toggle="modal" data-bs-target="#modal-add-set">
                            Tambah Set <i class="fa-fw fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <?php if ($result == 'ok') { ?>

                    <table class="table table-bordered table-striped table-secondary">
                        <thead>
                            <tr class="text-center">
                                <th width="10%" width="10%">No</th>
                                <th width="30%">Produk</th>
                                <th width="20%">Stok</th>
                                <th width="20%">Pecahan</th>
                                <th width="20%">Bisa dipecah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($virtual_stok as $vs) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $vs['nama_produk'] ?></td>
                                    <td class="text-center"><?= $vs['stok_jadi'] ?></td>
                                    <td class="text-center"><?= $vs['qty_bahan'] ?></td>
                                    <td class="text-center"><?= $vs['bisa_dipecah'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php } else { ?>

                    <h2 class="text-center mt-2"><?= $result ?></h2>

                <?php } ?>

            <?php } ?>

        </div>

    </div>

</main>

<!-- Modal add komponen -->
<div class="modal fade" id="modal-add-komponen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Produk Komponen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-bahan" autocomplete="off" action="<?= site_url() ?>resource-produkplan" method="POST">

                    <?= csrf_field() ?>

                    <input type="hidden" name="id_produk_redirect" value="<?= $produk['id'] ?>">
                    <input type="hidden" name="id_produk_jadi" value="<?= $produk['id'] ?>">

                    <div class="mb-3">
                        <label for="id_produk_bahan" class="form-label">Produk</label>
                        <select class="form-control" name="id_produk_bahan" id="id_produk_bahan">
                            <?php foreach ($all_plan as $ap) : ?>
                                <option value="<?= $ap['id'] ?>"><?= $ap['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <label for="qty_bahan" class="form-label">Jumlah</label>
                    <input type="number" min="0" class="form-control mb-3" id="qty_bahan" name="qty_bahan" placeholder="Jumlah produk">

                    <hr>

                    <button class="btn btn-outline-secondary mb-2 btn-sm" id="submit-add-bahan" type="submit">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal add set -->
<div class="modal fade" id="modal-add-set" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Produk Set</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-add-set" autocomplete="off" action="<?= site_url() ?>resource-produkplan" method="POST">

                    <?= csrf_field() ?>

                    <input type="hidden" name="id_produk_redirect" value="<?= $produk['id'] ?>">
                    <input type="hidden" name="id_produk_bahan" value="<?= $produk['id'] ?>">

                    <div class="mb-3">
                        <label for="id_produk_jadi" class="form-label">Produk</label>
                        <select class="form-control" name="id_produk_jadi" id="id_produk_jadi">
                            <?php foreach ($all_plan as $ap) : ?>
                                <option value="<?= $ap['id'] ?>"><?= $ap['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <label for="qty_bahan" class="form-label">Jumlah</label>
                    <input type="number" min="0" class="form-control mb-3" id="qty_bahan" name="qty_bahan" placeholder="Jumlah produk">

                    <hr>

                    <button class="btn btn-outline-secondary mb-2 btn-sm" id="submit-add-set" type="submit">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $("#id_kategori").select2({
            theme: "bootstrap-5",
            tags: true,
        });

        $("#id_produk_bahan").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#modal-add-komponen')
        });

        $("#id_produk_jadi").select2({
            theme: "bootstrap-5",
            dropdownParent: $('#modal-add-set')
        });

        $('#harga_beli').mask('000.000.000', {
            reverse: true
        });
        $('#harga_jual').mask('000.000.000', {
            reverse: true
        });

        // Alert
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }
    })
</script>

<?= $this->endSection() ?>