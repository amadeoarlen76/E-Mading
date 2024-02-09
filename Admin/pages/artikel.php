<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php"); // Arahkan ke halaman login jika belum login
    exit();
}

// Periksa waktu sesi untuk timeout (30 menit)
$timeout = 30 * 60; // 30 menit dalam satuan sekon
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();     // Unset semua variabel sesi
    session_destroy();   // Hancurkan sesi
    header("Location: ../../login.php"); // Arahkan ke halaman login setelah timeout
    exit();
}


// Koneksi ke database buat fungsi read
$host = "localhost";
$username = "root";
$password = "";
$database = "emading";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari database
$query = "SELECT id, judul, kategori, konten, gambar, publish, tags, creator FROM post";
$result = $conn->query($query);

// Periksa hasil kueri
if (!$result) {
    die("Error: " . $conn->error);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <style>
  .thumbnail-image {
    max-width: 80%; /* Ganti dengan lebar yang diinginkan */
    max-height: 80%; /* Ganti dengan tinggi yang diinginkan */
  }
  </style>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JeWePe | List Artikel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Kumpulan navbar atas -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
      <div class="dropdown">
      <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">
        <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-1" alt="User Image" width="40" height="40">
        <span class="caret"></span>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="#">Profile</a>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </div>

    </ul>
  </nav>
  <!-- /.Kumpulan navbar atas -->

  <!-- Kumpulan Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index.html" class="brand-link">
      <img src="" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">JeWePe - E-Mading</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Logo Pengguna -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- Menu Dashboard -->
          <li class="nav-item">
            <a href="../index.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!-- Menu Open Product -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="fas fa-store nav-icon"></i>
              <p>
                Post Artikel
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar Artikel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="../pages/kategori.html" class="nav-link">
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Artikel</h1>
          </div>
          <div class="col-sm-6">

            <!-- Tombol Tambah Berita -->
            <a href="tambah.php" class="btn btn-primary" role="button">Tambah Artikel</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Tabel Start -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Konten</th>
                    <th>Gambar</th>
                    <th>Publish</th>
                    <th>Tags</th>
                    <th>Creator</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Tampilkan data dari database
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['judul']}</td>";
                    echo "<td>{$row['kategori']}</td>";
                    echo "<td>" . substr($row['konten'], 0, 55) . "...</td>";
                    echo "<td style='max-width: 100px;'><img src='prosesdata/uploads/{$row['gambar']}' alt='Gambar' class='thumbnail-image' style='width: 100%;'></td>";

                    // Ganti nilai boolean dengan kata-kata deskriptif
                    $publishStatus = $row['publish'] ? 'Yes' : 'No';
                    echo "<td>{$publishStatus}</td>";
                    echo "<td>{$row['tags']}</td>";
                    echo "<td>{$row['creator']}</td>";
                    echo "<td>
                    <button class='btn btn-warning redirectToEdit' data-id='{$row['id']}'>Edit</button>
                    <button class='btn btn-danger delete-article' data-id='{$row['id']}'>Delete</button>
                          </td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
            </div>
            <!-- Tabel end -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.Main content end-->
</div>
<!-- ./wrapper -->


  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023 JeWePe.</strong> All rights reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../gins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  function redirectToEdit(id) {
    window.location.href = 'edit.php?id=' + id;
  }
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // Event handler untuk tombol "Edit"
        $('.redirectToEdit').on('click', function () {
      var articleId = $(this).data('id');
      redirectToEdit(articleId);
    });
    // Event handler untuk tombol "Delete"
    $('.delete-article').on('click', function () {
      var articleId = $(this).data('id');
      var confirmation = confirm("Apakah Anda yakin ingin menghapus artikel ini?");
      if (confirmation) {
        window.location.href = 'prosesdata/hapus.php?id=' + articleId;
      }
    });
  });
</script>
</body>
</html>


<?php
// Tutup koneksi ke database
$conn->close();
?>