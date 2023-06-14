<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Fixing Penawaran dan Buat Penjualan</h3>
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
                    <th class="text-center" width="13%">No Penawaran</th>
                    <th class="text-center" width="12%">Tanggal</th>
                    <th class="text-center" width="30%">Customer</th>
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
            ajax: '<?= site_url() ?>sales-get_penawaran_ordered',
            order: [],
            columns: [{
                    data: 'no',
                    orderable: false
                },
                {
                    data: 'no_penawaran'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'customer'
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
            text: "Apakah yakin menghapus data penjualan ini?",
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
                        url: "<?= site_url() ?>sales-alasan_hapus_penawaran",
                        data: 'id=' + id + '&alasan_dihapus=' + text,
                        dataType: "json",
                        success: function(response) {
                            if (response.ok) {
                                if (response.id_penjualan == 0) {
                                    $('#form_delete').attr('action', '<?= site_url() ?>sales-penawaran/' + response.id_penawaran);
                                    $('#form_delete').submit();
                                } else {
                                    $('#form_delete').attr('action', '<?= site_url() ?>sales-penjualan/' + response.id_penjualan);
                                    $('#form_delete').submit();
                                }
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