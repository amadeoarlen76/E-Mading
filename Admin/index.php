<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

// Periksa waktu sesi untuk timeout (30 menit)
$timeout = 30 * 60; // 30 menit dalam detik
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();     // Unset semua variabel sesi
    session_destroy();   // Hancurkan sesi
    header("Location: ../login.php"); // Arahkan ke halaman login setelah timeout
    exit();
}

// Perbarui waktu aktivitas terakhir
$_SESSION['last_activity'] = time();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EMading - JeWePe | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Loading Logo -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="" alt="E-Mading" height="60" width="60">
  </div>

  <!-- Kumpulan Navbar Atas -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- User Logo -->

      <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">
        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-1" alt="User Image" width="40" height="40">
        <span class="caret"></span>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="#">Profile</a>
          <a class="dropdown-item" href="pages/logout.php">Logout</a>
        </div>
      </div>

      <!-- User Logo End -->
    </ul>
  </nav>
  <!-- /.Kumpulan navbar atas -->

  <!-- Kumpulan Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
      <!-- <img src="" alt="" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-light">JeWePe</span>
    </a><!-- /Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Logo Pengguna -->
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- Menu Dashboard -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!-- Menu Open Post Artikel -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-store nav-icon"></i>
              <p>
                Post Artikel
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <!-- Menu Anakan Dropdown -->
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/artikel.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar Artikel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/hapus.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Artikel Dihapus</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Menu Kategori -->
          <li class="nav-item">
            <a href="pages/kategori.html" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>Kategori</p>
              </a>
          </li>
          <!-- Menu Tag -->
          <li class="nav-item">
            <a href="pages/tag.html" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>Tag</p>
              </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Dashboard Header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- Menu Dashboard Title -->
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <!-- Path -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content mid(Dashboard Content)-->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>10</h3>
                <p>Post Dibuat</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>185</h3>
                <p>Post Dihapus</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>4</h3>
                <p>Kategori</p>
              </div>
              <div class="icon">
                <i class="ion ion-archive"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>2</h3>
                <p>Tags berita</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
 
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.Main content mid(Dashboard Content)-->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023 JeWePe  </a>.</strong>
    All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
