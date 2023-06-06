<?= $this->extend('MyLayout/template') ?>

<?= $this->section('content') ?>

<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<main class="p-md-3 p-2">

    <div class="d-flex mb-0">
        <div class="me-auto mb-1">
            <h3 style="color: #566573;">Data Penjualan</h3>
        </div>
    </div>

    <hr class="mt-0 mb-4">

    <div class="table-responsive">
        <table class="table table-hover table-striped table-bordered" width="100%" id="tabel">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th class="text-center" width="11%">Nomor</th>
                    <th class="text-center" width="10%">Tanggal</th>
                    <th class="text-center" width="25%">Customer</th>
                    <th class="text-center" width="14%">Total</th>
                    <th class="text-center" width="12%">Status</th>
                    <th class="text-center" width="12%">Pembayaran</th>
                    <th class="text-center" width="9%">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</main>

<?= $this->include('MyLayout/js') ?>

<!-- Modal -->
<div class="modal fade" id="my-modal-show" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" style="max-width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalShow">Detail Penjualan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="isiShow">

            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="my-modal-show2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="judulModalShow2">Tambah Tagihan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle="modal" data-bs-target="#my-modal-show"></button>
            </div>
            <div class="modal-body" id="isiShow2">

                <form autocomplete="off" action="<?= site_url() ?>sales-tambah_tagihan" method="POST" id="form_tambah_tagihan">

                    <?= csrf_field() ?>

                    <div class="card-body py-0 my-0">

                        <input type="hidden" id="total_tagihan" name="total_tagihan">
                        <input type="hidden" id="id_penjualan" name="id_penjualan">
                        <input type="hidden" id="no_penjualan" name="no_penjualan">

                        <div class="mb-4 d-flex justify-content-between">
                            <div class="mt-2">
                                <h4 id="text_total_tagihan">Total Tagihan : Rp. 0</h4>
                            </div>
                            <div>
                                <input type="text" class="form-control border-primary border-2" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="hf" class="form-label">HF</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text px-2">Rp</span>
                                <input value="0" type="number" class="form-control input_form_tagihan" id="hf" name="hf">
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="ppn_hf" class="form-label">PPN HF</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text px-2">Rp</span>
                                <input value="0" type="number" class="form-control input_form_tagihan" id="ppn_hf" name="ppn_hf">
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="ongkir_port" class="form-label">Ongkir Port</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text px-2">Rp</span>
                                <input value="0" type="number" class="form-control input_form_tagihan" id="ongkir_port" name="ongkir_port">
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="ongkir_laut_udara" class="form-label">Ongkir Laut / Udara</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text px-2">Rp</span>
                                <input value="0" type="number" class="form-control input_form_tagihan" id="ongkir_laut_udara" name="ongkir_laut_udara">
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="ongkir_transit" class="form-label">Ongkir Transit</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text px-2">Rp</span>
                                <input value="0" type="number" class="form-control input_form_tagihan" id="ongkir_transit" name="ongkir_transit">
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="ongkir_gudang" class="form-label">Ongkir Gudang</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text px-2">Rp</span>
                                <input value="0" type="number" class="form-control input_form_tagihan" id="ongkir_gudang" name="ongkir_gudang">
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="bm" class="form-label">BM</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text px-2">Rp</span>
                                <input value="0" type="number" class="form-control input_form_tagihan" id="bm" name="bm">
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="ppn" class="form-label">PPN</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text px-2">Rp</span>
                                <input value="0" type="number" class="form-control input_form_tagihan" id="ppn" name="ppn">
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="pph" class="form-label">PPH</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text px-2">Rp</span>
                                <input value="0" type="number" class="form-control input_form_tagihan" id="pph" name="pph">
                            </div>
                        </div>

                        <div class="text-center">
                            <button id="tombolTambahTagihan" class="btn px-5 btn-outline-primary mb-3" type="submit">Simpan <i class="fa-fw fa-solid fa-check"></i></button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<script>
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
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        $('#tabel').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?= site_url() ?>sales-get_data_penjualan',
            order: [],
            columns: [{
                    data: 'no',
                    orderable: false
                },
                {
                    data: 'no_penjualan'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'customer'
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
                    data: 'status_pembayaran'
                },
                {
                    data: 'aksi',
                    orderable: false,
                    className: 'text-center'
                },
            ]
        });

        $('#tanggal').datepicker({
            format: "yyyy-mm-dd"
        });
    });


    function showModalDetail(no) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>sales-show_data_penjualan/' + no,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiShow').html(res.data)
                    $('#judulModalShow').html('Detail Penjualan')
                    $('#my-modal-show').modal('toggle')
                } else {
                    console.log(res)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }


    function showModalTagihan(no) {
        $.ajax({
            type: 'GET',
            url: '<?= site_url() ?>sales-show_tagihan_penjualan/' + no,
            dataType: 'json',
            success: function(res) {
                if (res.data) {
                    $('#isiShow').html(res.data)
                    $('#judulModalShow').html('List Tagihan')
                    $('#my-modal-show').modal('toggle')
                } else {
                    console.log(res)
                }
            },
            error: function(e) {
                alert('Error \n' + e.responseText);
            }
        })
    }


    function showModalTambahTagihan(id_penjualan, no_penjualan) {
        $('#judulModalShow2').html('Tambah Tagihan')
        $('#my-modal-show2').modal('toggle')
        $('#my-modal-show').modal('hide')
        $('#id_penjualan').val(id_penjualan);
        $('#no_penjualan').val(no_penjualan);
    }


    $('#form_tambah_tagihan').submit(function(e) {
        e.preventDefault();

        if ($('#total_tagihan').val() == '' || $('#total_tagihan').val() == 0) {
            Swal.fire(
                'Opss.',
                'Total tagihan Rp.0 lalu apa yang mau ditagihkan?',
                'error'
            )
        } else {
            var no_penjualan = $('#no_penjualan').val();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#tombolTambahTagihan').html('Tunggu <i class="fa-solid fa-spin fa-spinner"></i>');
                    $('#tombolTambahTagihan').prop('disabled', true);
                },
                complete: function() {
                    $('#tombolTambahTagihan').html('Simpan <i class="fa-fw fa-solid fa-check"></i>');
                    $('#tombolTambahTagihan').prop('disabled', false);
                },
                success: function(response) {
                    $('#my-modal-show2').modal('hide')
                    showModalTagihan(no_penjualan);
                    Toast.fire({
                        icon: 'success',
                        title: 'Berhasil membuat tagihan.'
                    });
                    $('#form_tambah_tagihan')[0].reset();
                    $('#text_total_tagihan').html('Total Tagihan : Rp 0')
                },
                error: function(e) {
                    alert('Error \n' + e.responseText);
                }
            });
            return false
        }
    })

    $('.input_form_tagihan').on('input', function() {
        hitung_total_tagihan()
    })

    $('.input_form_tagihan').change(function() {
        if ($(this).val() == '') {
            $(this).val('0');
        }
        hitung_total_tagihan()
    })


    function hitung_total_tagihan() {
        let hf = $('#hf').val()
        let ppn_hf = $('#ppn_hf').val()
        let ongkir_port = $('#ongkir_port').val()
        let ongkir_laut_udara = $('#ongkir_laut_udara').val()
        let ongkir_transit = $('#ongkir_transit').val()
        let ongkir_gudang = $('#ongkir_gudang').val()
        let bm = $('#bm').val()
        let ppn = $('#ppn').val()
        let pph = $('#pph').val();

        let total_tagihan = parseInt(hf) + parseInt(ppn_hf) + parseInt(ongkir_port) + parseInt(ongkir_laut_udara) + parseInt(ongkir_transit) + parseInt(ongkir_gudang) + parseInt(bm) + parseInt(ppn) + parseInt(pph);

        $('#total_tagihan').val(total_tagihan)
        $('#text_total_tagihan').html('Total Tagihan : ' + format_rupiah(total_tagihan))
    }
</script>

<?= $this->endSection() ?>