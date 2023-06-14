<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Fixing Pemesanan dan Buat Pembelian</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>purchase">
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
                    <th class="text-center" width="30%">Supplier</th>
                    <th class="text-center" width="15%">Admin</th>
                    <th class="text-center" width="15%">Status</th>
                    <th class="text-center" width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</main>

<?= $this->include('MyLayout/js') ?>

<script>
    $(document).ready(function() {
        $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= site_url() ?>purchase-get_pemesanan_ordered',
            order: [
                [1, 'desc']
            ],
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
                    data: 'supplier'
                },
                {
                    data: 'admin'
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

        // fungsi untuk menangkap nilai parameter query string dari URL
        function getQueryStringValue(key) {
            return decodeURIComponent(window.location.search.replace(
                new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
        }

        // tangkap nilai parameter query string 'pesan' dari URL
        var pesan = getQueryStringValue('pesan');

        // tampilkan nilai pesan dalam alert
        if (pesan) {
            pesan = pesan.replace(/\+/g, ' ');
            Toast.fire({
                icon: 'success',
                title: pesan
            })
        }
    });


    function confirm_delete(id) {
        Swal.fire({
            title: 'Konfirmasi?',
            text: "Apakah yakin menghapus data pembelian ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const {
                    value: text
                } = await Swal.fire({
                    input: 'textarea',
                    inputLabel: 'Apa alasan menghapus data ini?',
                    inputPlaceholder: '',
                    inputAttributes: {
                        'aria-label': ''
                    },
                    confirmButtonColor: '#3085d6',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                })

                if (text) {
                    $.ajax({
                        type: "post",
                        url: "<?= site_url() ?>purchase-alasan_hapus_pemesanan",
                        data: 'id=' + id + '&alasan_dihapus=' + text,
                        dataType: "json",
                        success: function(response) {
                            if (response.ok) {
                                $('#form_delete').attr('action', '<?= site_url() ?>purchase-pemesanan/' + response.id_pemesanan);
                                $('#form_delete').submit();
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
                }
            }
        })
    }
</script>

<?= $this->endSection() ?>