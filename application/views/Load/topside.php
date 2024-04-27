<script src="<?= base_url('assets/jquery-3.7.1.min.js') ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/bs5/css/bootstrap.min.css') ?>">
<script src="<?= base_url('assets/bs5/js/bootstrap.bundle.min.js') ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/bi/font/bootstrap-icons.min.css') ?>">

<link rel="stylesheet" href="<?= base_url('assets/datatables/datatables.min.css') ?>">
<script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/sweetalert2.min.css') ?>">
<script src="<?= base_url('assets/sweetalert2.all.min.js') ?>"></script>

<link rel="stylesheet" href="<?= base_url('assets/select2.min.css') ?>">
<script src="<?= base_url('assets/select2.min.js') ?>"></script>

<script src="<?= base_url('assets/xlsx.full.min.js') ?>"></script>

<style>
    table.tadata thead tr {
        background-color: red
    }
</style>

<div class="container-fluid">
    <nav style="height: 62.3px" class="navbar navbar-light bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="#"><?= $title ?></a>
            <button class="navbar-toggler text-light" data-bs-theme="dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon text-light"></span>
            </button>
            <div style="width: 17%;" class="offcanvas offcanvas-end bg-primary" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                        <?= $this->session->userdata('email') ?>
                    </h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body d-flex justify-content-between bg-primary-subtle flex-column">
                    <ul class="navbar-nav  flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link
                        <?php
                        if ($title == 'Dashboard') {
                            echo 'active';
                        }
                        ?>
                        
                        " href=" <?= base_url('Dashboard') ?>">
                                <h5><i class="bi bi-house-fill"></i> Dashboard</h5>
                            </a>
                        </li>
                        <?php if ($this->session->userdata('id_user') == 1) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php
                                                    if ($title == 'Menu User') {
                                                        echo 'active';
                                                    }
                                                    ?>" href="<?= base_url('User') ?>">
                                    <h5><i class="bi bi-person-circle"></i> User</h5>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php
                                                    if ($title == 'Menu Produk') {
                                                        echo 'active';
                                                    }
                                                    ?>" href="<?= base_url('Produk') ?>">
                                    <h5><i class="bi bi-boxes"></i> Produk</h5>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php
                                                    if ($title == 'Menu Member') {
                                                        echo 'active';
                                                    }
                                                    ?>" href="<?= base_url('Member') ?>">
                                    <h5><i class="bi bi-person-vcard"></i> Member</h5>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php
                                                    if ($title == 'Menu Diskon') {
                                                        echo 'active';
                                                    }
                                                    ?>" href="<?= base_url('Diskon') ?>">
                                    <h5><i class="bi bi-cash"></i> Diskon</h5>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php
                                                    if ($title == 'Menu Transaksi') {
                                                        echo 'active';
                                                    }
                                                    ?>" href="<?= base_url('Transaksi') ?>">
                                    <h5><i class="bi bi-cart"></i> Transaksi</h5>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php
                                                    if ($title == 'Master Toko') {
                                                        echo 'active';
                                                    }
                                                    ?>" href="<?= base_url('Master_toko') ?>">
                                    <h5><i class="bi bi-shop"></i> Master Toko</h5>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <h5>Laporan</h5>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownId">
                                    <a class="dropdown-item" href="<?= base_url("Laporan/stok") ?>">Laporan Stok</a>
                                    <a class="dropdown-item" href="<?= base_url("Laporan/transaksi") ?>">Laporan Transaksi</a>
                                </div>
                            </li>
                        <?php } ?>

                    </ul>

                    <a href="<?= base_url('Login/out') ?>" style="margin-top: 60px;" class="btn btn-danger">LOGOUT</a>
                </div>
            </div>
        </div>
    </nav>

    <body style="margin-top: 100px; background-color: #">

        <script>
            function notif(status, title) {
                Swal.fire({
                    toast: true,
                    icon: status,
                    title: title,
                    animation: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
            }
        </script>