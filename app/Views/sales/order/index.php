<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Data Order dari Haebot Party</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>sales">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="13%">No Pemesanan</th>
                    <th class="text-center" width="12%">Tanggal</th>
                    <th class="text-center" width="30%">Perusahaan</th>
                    <th class="text-center" width="18%">Total</th>
                    <th class="text-center" width="10%">Status</th>
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
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModal"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiModal">

            </div>
        </div>
    </div>
</div>
<!-- Modal -->



<script>
    $(document).ready(function() {
        $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= site_url() ?>sales-getdataorder',
            order: [],
            columns: [{
                    data: 'no',
                    orderable: false
                },
                {
                    data: 'no_pemesanan'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'nama_perusahaan'
                },
                {
                    data: 'grand_total',
                    render: function(data, type, row) {
                        return 'Rp ' + data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                    }
                },
                {
                    data: 'status'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    className: 'text-center'
                },
            ]
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


    function detailOrder(kode_trx_api, id_perusahaan) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>sales-order/' + kode_trx_api + '/' + id_perusahaan,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#judulModal').html('Detail Order')
                    $('#isiModal').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('.modal-dialog').addClass('modal-xl')
                    $('.modal-dialog').removeClass('modal-lg')
                } else {
                    console.log(res)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }


    function tolakOrder(kode_trx_api, id_perusahaan, no_pemesanan) {
        Swal.fire({
            title: 'Konfirmasi?',
            text: "Apakah yakin akan menolak order ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            $.ajax({
                type: "post",
                url: "<?= site_url() ?>sales-alasan_tolak_order",
                data: 'kode_trx_api=' + kode_trx_api + '&id_perusahaan=' + id_perusahaan + '&no_pemesanan=' + no_pemesanan,
                dataType: "json",
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire(
                            'Berhasil.',
                            'Menolak order',
                            'success'
                        ).then((result) => {
                            location.reload();
                        })
                    } else {
                        Swal.fire(
                            'Opss.',
                            'Terjadi kesalahan, hubungi IT Support',
                            'error'
                        )
                    }
                },
                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });
        })
    }
</script>
<?= $this->endSection() ?>