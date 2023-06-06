<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Tagihan</h3>
        </div>
        <div class="mb-1">
            <a class="btn btn-sm btn-outline-secondary" href="<?= site_url() ?>finance-tambahTagihan">
                <i class="fa-fw fa-solid fa-plus"></i> Tambah Tagihan
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="row mt-3">
        <div class="col-lg-3 mb-3">
            <a style="text-decoration: none; color: #34495E; cursor: pointer;" id="btn-bulanini">
                <input type="hidden" id="bulanini" name="bulanini">
                <div class=" card-ku py-2 px-3" style=" height: 73px; background-color: #fff;">
                    <div class="d-flex justify-content-between">
                        <div class="my-auto">
                            <p style="font-size: 14px;" class="mb-1">Bulan ini</p>
                            <h5 id="rupiah_bulan_ini">Rp. <?= number_format($rupiah_bulan_ini, 0, ',', '.'); ?></h5>
                        </div>
                        <div class="text-right my-auto">
                            <button class="btn px-3 rounded-pill btn-success" id="jumlah_bulan_ini"><?= $jumlah_bulan_ini ?></button>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 mb-3">
            <a style="text-decoration: none; color: #34495E; cursor: pointer;" id="btn-last30day">
                <input type="hidden" id="last30day" name="last30day">
                <div class=" card-ku py-2 px-3" style=" height: 73px; background-color: #fff;">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p style="font-size: 14px;" class="mb-1">30 Hari lalu</p>
                            <h5 id="rupiah_30_hari_lalu">Rp. <?= number_format($rupiah_last30, 0, ',', '.'); ?></h5>
                        </div>
                        <div class="text-right my-auto">
                            <button class="btn px-3 rounded-pill btn-primary" id="jumlah_30_hari_lalu"><?= $jumlah_last30 ?></button>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 mb-3">
            <a style="text-decoration: none; color: #34495E; cursor: pointer;" id="btn-belumdibayar">
                <input type="hidden" id="belumDiBayar" name="belumDiBayar">
                <div class=" card-ku py-2 px-3" style=" height: 73px; background-color: #fff;">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p style="font-size: 14px;" class="mb-1">Belum dibayar</p>
                            <h5 id="rupiah_belum_dibayar">Rp. <?= number_format($rupiah_belum_dibayar, 0, ',', '.'); ?></h5>
                        </div>
                        <div class="text-right my-auto">
                            <button class="btn px-3 rounded-pill btn-danger" id="jumlah_belum_dibayar"><?= $jumlah_belum_dibayar ?></button>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="table-responsive mt-2">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="4%">No</th>
                    <th class="text-center" width="13%">Tanggal</th>
                    <th class="text-center" width="16%">Nomor</th>
                    <th class="text-center" width="20%">Jumlah Tagihan</th>
                    <th class="text-center" width="20%">Sisa Tagihan</th>
                    <th class="text-center" width="15%">Status</th>
                    <th class="text-center" width="12%">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</main>

<?= $this->include('MyLayout/js') ?>



<!-- Modal -->
<div class="modal fade" id="my-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiForm">

            </div>
        </div>
    </div>
</div>
<!-- Modal -->


<script>
    // Bahan Alert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        background: '#EC7063',
        color: '#fff',
        iconColor: '#fff',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    $(document).ready(function() {
        table = $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= site_url() ?>finance-getDataTagihan',
                data: function(d) {
                    d.last30day = $('#last30day').val();
                    d.bulanini = $('#bulanini').val();
                    d.belumDiBayar = $('#belumDiBayar').val();
                }
            },
            order: [],
            columns: [{
                    data: 'no',
                    orderable: false,
                    className: 'text-center'
                },
                {
                    data: 'tanggal',
                    className: 'ps-3'
                },
                {
                    data: 'no_tagihan',
                    className: 'ps-3'
                },
                {
                    data: 'jumlah',
                    render: function(data, type, row) {
                        return 'Rp ' + data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                    },
                    className: 'ps-3'
                },
                {
                    data: 'sisa_tagihan',
                    render: function(data, type, row) {
                        return 'Rp ' + data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                    },
                    className: 'ps-3'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        var className = '';
                        if (data === 'Belum dibayar') {
                            className = 'fw-bold text-center text-danger';
                        } else if (data === 'Dibayar Sebagian') {
                            className = 'fw-bold text-center text-warning';
                        } else {
                            className = 'fw-bold text-center text-success';
                        }
                        return '<div class="' + className + '">' + data + '</div>';
                    }
                },
                {
                    data: 'aksi',
                    orderable: false,
                    className: 'text-center'
                },
            ]
        });

        $('#btn-last30day').click(function(event) {
            $('#last30day').val('ok');
            $('#bulanini').val('');
            $('#belumDiBayar').val('');
            table.ajax.reload();
        });

        $('#btn-bulanini').click(function(event) {
            $('#last30day').val('');
            $('#bulanini').val('ok');
            $('#belumDiBayar').val('');
            table.ajax.reload();
        });

        $('#btn-belumdibayar').click(function(event) {
            $('#last30day').val('');
            $('#bulanini').val('');
            $('#belumDiBayar').val('ok');
            table.ajax.reload();
        });

        // Alert
        var op = <?= (!empty(session()->getFlashdata('pesan')) ? json_encode(session()->getFlashdata('pesan')) : '""'); ?>;
        if (op != '') {
            Toast.fire({
                icon: 'success',
                title: op
            })
        }
    });


    function showModalDetail(id) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>finance-tagihan/' + id,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiForm').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('#judulModal').html('Detail Rincian Tagihan')
                } else {
                    console.log(res)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }


    function confirm_delete(id) {
        Swal.fire({
            backdrop: false,
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form_delete').attr('action', '<?= site_url() ?>finance-jurnal/' + id);
                $('#form_delete').submit();
            }
        })
    }
</script>

<?= $this->endSection() ?>