<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>


<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Data Penawaran</h3>
        </div>
        <div class="me-2 mb-1">
            <a class="btn btn-sm btn-outline-dark" href="<?= site_url() ?>sales">
                <i class="fa-fw fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div>
            <a class="btn btn-sm btn-outline-secondary mb-3" id="tombolTambah">
                <i class="fa-fw fa-solid fa-plus"></i> Buat Penawaran
            </a>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="13%">Nomor</th>
                    <th class="text-center" width="12%">Tanggal</th>
                    <th class="text-center" width="30%">Customer</th>
                    <th class="text-center" width="15%">Total</th>
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
        $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= site_url() ?>sales-getdatapenawaran',
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
                    data: 'total_harga_produk',
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


    $('#tombolTambah').click(function(e) {
        e.preventDefault();
        showModalTambah();
    })


    function showModalTambah() {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>sales-penawaran/new',
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#judulModal').html('Tambah Penawaran')
                    $('#isiModal').html(res.data)
                    $('#my-modal').modal('toggle')
                    $('.modal-dialog').removeClass('modal-xl')
                    $('.modal-dialog').addClass('modal-lg')
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }


    function showModalDetail(no) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>sales-penawaran/' + no,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#judulModal').html('Detail Penawaran')
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
                        url: "<?= site_url() ?>sales-alasan_hapus_penawaran",
                        data: 'id=' + id + '&alasan_dihapus=' + text,
                        dataType: "json",
                        success: function(response) {
                            if (response.ok) {
                                $('#form_delete').attr('action', '<?= site_url() ?>sales-penawaran/' + id);
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


    function repeatPenawaran(no) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>sales-repeat_penawaran/' + no,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#judulModal').html('Duplikat Penawaran')
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
</script>

<?= $this->endSection() ?>