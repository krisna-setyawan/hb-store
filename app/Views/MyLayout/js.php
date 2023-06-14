<script src="template/jquery-3.6.3.min.js"></script>
<script src="template/dataTable/datatables.min.js"></script>
<script src="template/sweetalert2/sweetalert2.all.min.js" crossorigin="anonymous"></script>
<script src="template/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="template/js/scripts.js"></script>
<script src="template/jquery-mask/jquery.mask.js" crossorigin="anonymous"></script>
<script src="template/datepicker/bootstrap-datepicker.min.js" crossorigin="anonymous"></script>
<script src="template/select2/js/select2.min.js" crossorigin="anonymous"></script>

<script>
    // Bahan Alert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
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


    function formatRupiah(angka) {
        // var number_string = angka.toString(),
        //     sisa = number_string.length % 3,
        //     rupiah = number_string.substr(0, sisa),
        //     ribuan = number_string.substr(sisa).match(/\d{3}/g);

        // if (ribuan) {
        //     separator = sisa ? "." : "";
        //     rupiah += separator + ribuan.join(".");
        // }

        // return rupiah;
        // Mengubah tipe data menjadi integer jika parameter awalnya berupa string

        let formattedValue = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(angka);
        formattedValue = formattedValue.replace(/\D00(?=\d*$)/, '').replace(/(\.|,)00$/, '');
        return formattedValue;

        // let formattedValue = new Intl.NumberFormat('id-ID', {
        //     style: 'currency',
        //     currency: 'IDR'
        // }).format(angka).replace(/\D00$/, '');
        // return formattedValue;
    }


    function format_rupiah(angka) {
        // var number_string = angka.toString(),
        //     sisa = number_string.length % 3,
        //     rupiah = number_string.substr(0, sisa),
        //     ribuan = number_string.substr(sisa).match(/\d{3}/g);

        // if (ribuan) {
        //     separator = sisa ? "." : "";
        //     rupiah += separator + ribuan.join(".");
        // }

        // return rupiah;
        // Mengubah tipe data menjadi integer jika parameter awalnya berupa string

        let formattedValue = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(angka);
        formattedValue = formattedValue.replace(/\D00(?=\d*$)/, '').replace(/(\.|,)00$/, '');
        return formattedValue;

        // let formattedValue = new Intl.NumberFormat('id-ID', {
        //     style: 'currency',
        //     currency: 'IDR'
        // }).format(angka).replace(/\D00$/, '');
        // return formattedValue;
    }
</script>