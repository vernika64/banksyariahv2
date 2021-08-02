<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title><?= $judul; ?></title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('addons/cpanel/plugins/images/favicon.png'); ?>">
    <!-- Custom CSS -->
    <link href="<?= base_url('addons/cpanel/plugins/bower_components/chartist/dist/chartist.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('addons/cpanel/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css'); ?>">
    <!-- Custom CSS -->
    <link href="<?= base_url('addons/cpanel/css/style.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('addons/cpanel/css/tambahan.css'); ?>" rel="stylesheet">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="dashboard">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="<?= base_url('addons/cpanel/plugins/images/logo-icon.png'); ?>" alt="homepage" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <h4 style="color: black;padding-top:15px;">Bank Syariah</h4>
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">

                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <!-- <li class=" in">
                            <form role="search" class="app-search d-none d-md-block me-3">
                                <input type="text" placeholder="Search..." class="form-control mt-0">
                                <a href="" class="active">
                                    <i class="fa fa-search"></i>
                                </a>
                            </form>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li>
                            <a class="profile-pic" data-bs-toggle="collapse" data-bs-target="#profil" style="cursor:pointer;">
                                <img src=<?= base_url('addons/cpanel/plugins/images/users/varun.jpg'); ?> alt="user-img" width="36" class="img-circle"><span class="text-white font-medium"><?= session()->get('nama'); ?></span></a>
                            <div class="list-group collapse" id="profil" style="position:absolute;width:100%;">
                                <a class="list-group-item list-group-item-action list-group-hv logout-link" href="/">Logout</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="dashboard" aria-expanded="false">
                                <i class="far fa-clock" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <?php

                        switch (session()->get('level')) {
                                // Khusus Administrator
                            case 0:
                        ?>
                                <!-- Modul Teller -->
                                <li class="sidebar-item pt-2">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdtl">
                                        <i class="fa fa-table" aria-hidden="true"></i>
                                        <span class="hide-menu">Modul Teller</span>
                                    </a>
                                    <ul class="collapse" id="mdtl">
                                        <li class="sidebar-item">
                                            <a class="sidebar-link waves-effect waves-dark" href="tr">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Setor Tunai</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a class="sidebar-link waves-effect waves-dark" href="tt">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Tarik Tunai</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Modul Back Office -->
                                <li class="sidebar-item pt-2">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdbo">
                                        <i class="fa fa-table" aria-hidden="true"></i>
                                        <span class="hide-menu">Modul Back Office</span>
                                    </a>
                                    <ul class="collapse" id="mdbo">
                                        <li class="sidebar-item">
                                            <a class="sidebar-link waves-effect waves-dark" href="#">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Pendanaan Murabahah</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-tem">
                                            <a class="sidebar-link waves-effect waves-dark" href="#">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Investasi Mudharabah</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Modul Customer Service -->
                                <li class="sidebar-item pt-2">
                                    <a class="sidebar-link waves-effect waves-dark" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdcs">
                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                        <span class="hide-menu">Modul Customer Service</span>
                                    </a>
                                    <ul class="collapse" id="mdcs">
                                        <li class="sidebar-item">
                                            <a class="sidebar-link waves-effect waves-dark" href="regcif">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">CIF</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item pt-2">
                                            <a class="sidebar-link waves-effect waves-dark" href="registrasirek">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Buka Rekening Tabungan</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item pt-2">
                                            <a class="sidebar-link waves-effect waves-dark">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Tutup Rekening Tabungan</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item pt-2">
                                            <a class="sidebar-link waves-effect waves-dark">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Investasi Mudharabah</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item pt-2">
                                            <a class="sidebar-link waves-effect waves-dark">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Pendanaan Murabahah</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <!-- Modul Supervisor -->
                                <li class="sidebar-item pt-2">
                                    <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdspv">
                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                        <span class="hide-menu">Modul Supervisor</span>
                                    </a>
                                    <ul class="collapse" id="mdspv">
                                        <li class="sidebar-item">
                                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="karyawan">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Karyawan</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a class="sidebar-link waves-effect waves-dark sidebar-link">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Transaksi Murabahah</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-item">
                                            <a class="sidebar-link waves-effect waves-dark sidebar-link">
                                                <i class="fa fa-globe" aria-hidden="true"></i>
                                                <span class="hide-menu">Investasi Mudharabah</span>
                                            </a>
                                        </li>
                                        <a class="sidebar-link waves-effect waves-dark sidebar-link" href="bksetortunai">
                                            <i class="fa fa-globe" aria-hidden="true"></i>
                                            <span class="hide-menu">Log Setor Tunai</span>
                                        </a>
                                </li>
                    </ul>
                    </li>

                <?php
                                break;
                                // Modul Supervisor
                            case 1:

                ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Iron</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Copper</span>
                        </a>
                    </li>

                <?php
                                break;
                                // Modul Back Office
                            case 2:

                ?>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdspv">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Pendanaan Murabahah</span>
                        </a>
                    </li>
                    <li class="sidebar-item pt-2">
                        <a class="sidebar-link waves-effect waves-dark" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdspv">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Investasi Mudharabah</span>
                        </a>
                    </li>

                <?php
                                break;
                                // Modul Customer Service
                            case 3:

                ?>

                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdspv">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">CIF</span>
                        </a>
                    </li>
                    <li class="sidebar-item pt-2">
                        <a class="sidebar-link waves-effect waves-dark" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdspv">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Buka Rekening Tabungan</span>
                        </a>
                    </li>
                    <li class="sidebar-item pt-2">
                        <a class="sidebar-link waves-effect waves-dark" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdspv">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Tutup Rekening Tabungan</span>
                        </a>
                    </li>
                    <li class="sidebar-item pt-2">
                        <a class="sidebar-link waves-effect waves-dark" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdspv">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Investasi Mudharabah</span>
                        </a>
                    </li>
                    <li class="sidebar-item pt-2">
                        <a class="sidebar-link waves-effect waves-dark" aria-expanded="false" role="button" data-bs-toggle="collapse" data-bs-target="#mdspv">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Pendanaan Murabahah</span>
                        </a>
                    </li>

                <?php
                                break;
                                // Modul Teller
                            case 4:

                ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark" href="#">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Tarik Tunai</span>
                        </a>
                        <a class="sidebar-link waves-effect waves-dark" href="#">
                            <i class="fa fa-globe" aria-hidden="true"></i>
                            <span class="hide-menu">Transfer</span>
                        </a>
                    </li>
            <?php
                                break;
                            default:
                                return redirect()->to('/');
                        }
            ?>

            </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?= $judul; ?></h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="d-md-flex">
                            <ol class="breadcrumb ms-auto">
                                <li><a href="#" class="fw-normal"><?= $judul; ?></a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <?= $this->renderSection('cpanel'); ?>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> Bank Syariah System Created by Vernika, Cpanel Template created by <a href="https://www.wrappixel.com/">wrappixel.com</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url('addons/cpanel/plugins/bower_components/jquery/dist/jquery.min.js'); ?>"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url('addons/cpanel/bootstrap/dist/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('addons/cpanel/js/app-style-switcher.js'); ?>"></script>
    <script src="<?= base_url('addons/cpanel/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js'); ?>"></script>
    <!--Wave Effects -->
    <script src="<?= base_url('addons/cpanel/js/waves.js'); ?>"></script>
    <!--Menu sidebar -->
    <script src="<?= base_url('addons/cpanel/js/sidebarmenu.js'); ?>"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url('addons/cpanel/js/custom.js'); ?>"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <!-- <script src="<?= base_url('addons/cpanel/plugins/bower_components/chartist/dist/chartist.min.js'); ?>"></script>
    <script src="<?= base_url('addons/cpanel/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js'); ?>"></script>
    <script src="<?= base_url('addons/cpanel/js/pages/dashboards/dashboard1.js'); ?>"></script> -->
</body>

</html>