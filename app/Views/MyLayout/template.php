<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=0.8, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Haebot</title>

    <base href="<?= base_url('assets') ?>">
    <?= $this->include('MyLayout/css') ?>

    <style>
        .topbar_shadow {
            box-shadow: 2px 22px 37px -10px rgba(52, 91, 145, 1);
            -webkit-box-shadow: 2px 22px 37px -10px rgba(52, 91, 145, 1);
            -moz-box-shadow: 2px 22px 37px -10px rgba(52, 91, 145, 1);
        }

        .notification {
            margin-top: 3px;
            text-decoration: none;
            padding-left: 10px;
            padding-right: 10px;
            padding-bottom: 5px;
            padding-top: 5px;
            position: relative;
            display: inline-block;
            border-radius: 50%;
            margin-right: 10px;
        }

        .notification .badge {
            position: absolute;
            top: -6px;
            right: -10px;
            padding: 5px 8px;
            border-radius: 50%;
            background-color: #C0392B;
            color: white;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <!-- NAVBAR -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark shadow-lg" style="background-color: #0C5BC6;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="/beranda">
            <img src="assets/logo/logo-haebot.jpeg" class="rounded-circle me-2" width="19%" alt="logo">
            <b> Haebot Store </b>
        </a>

        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-0 me-md-3">
            <li class="nav-item dropdown me-3">
                <a href="#" class="nav-link notification" id="navbarDropdownNotifikasi" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span><i class="fas fa-bell fa-fw"></i></span>
                    <span id="badge-jml-notif" class="badge"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" id="dropdown-notif" aria-labelledby="navbarDropdownNotifikasi">
                    <li class="dropdown-item">
                        <a href="#" class="text-decoration-none mx-4 text-dark">
                            <span class="text-success"><i class="fa-solid fa-triangle-exclamation"></i></span>
                            Belum ada notifikasi apapun.
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?= base_url() ?>/logout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- NAVBAR -->


    <div id="layoutSidenav">
        <!-- SIDEBAR -->
        <?= $this->include('MyLayout/sidebar') ?>
        <!-- SIDEBAR -->


        <!-- CONTENT -->
        <div id="layoutSidenav_content">


            <?= $this->renderSection('content') ?>


            <footer class="py-2 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Haebot Store 2023</div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- CONTENT -->
    </div>



    <script>
        $(function() {
            $(document).ready(function() {
                get_notif();
            })

            function get_notif() {
                $.ajax({
                    global: false,
                    url: '<?= base_url() ?>get-notif',
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.jml != 0) {
                            $('.notification').css('border', '1px #D5D8DC solid');
                            $('#badge-jml-notif').html(data.jml);

                            var $dropdownMenu = $('#dropdown-notif');
                            $dropdownMenu.empty();

                            $.each(data.notif, function(index, item) {
                                let href = '';
                                switch (item.untuk) {
                                    case 'Order':
                                        href += '<?= base_url() ?>sales-order';
                                        break;
                                    case 'Pemesanan':
                                        href += '<?= base_url() ?>purchase-pemesanan';
                                        break;
                                    case 'Fixing Pemesanan':
                                        href += '<?= base_url() ?>purchase-fixing-pemesanan';
                                        break;
                                    case 'Pembelian':
                                        href += '<?= base_url() ?>purchase-pembelian';
                                        break;
                                    case 'Fixing Penjualan':
                                        href += '<?= base_url() ?>sales-fixing-penawaran';
                                        break;
                                }

                                var $li = $('<li>').addClass('dropdown-item');
                                var $a = $('<a>').attr('href', href).html('<span class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i></span> ' + item.notif).addClass('text-decoration-none mx-4 text-dark');
                                $li.append($a);
                                $dropdownMenu.append($li);
                            });
                        }
                    }
                });
            }

            // Update every 5 seconds.
            setInterval(get_notif, 20000);
        });
    </script>
</body>

</html>