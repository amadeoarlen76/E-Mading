<?php
// Pastikan file koneksi.php sudah di-include di sini
include('../../config/koneksi.php');

// Periksa apakah parameter ID ada dalam URL
if(isset($_GET['id'])) {
    // Ambil ID dari URL
    $id = $_GET['id'];

    // Query untuk mendapatkan data artikel berdasarkan ID
    $query = "SELECT * FROM post WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // Periksa apakah query berhasil dieksekusi
    if($result) {
        // Periksa apakah data ditemukan
        if(mysqli_num_rows($result) > 0) {
            // Ambil data dan simpan ke dalam variabel $row
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "Data tidak ditemukan.";
            // Mungkin tampilkan pesan atau redirect ke halaman lain
            exit;
        }
    } else {
        echo "Query gagal dieksekusi: " . mysqli_error($conn);
        // Mungkin tampilkan pesan atau redirect ke halaman lain
        exit;
    }
} else {
    echo "ID tidak ditemukan dalam URL.";
    // Mungkin tampilkan pesan atau redirect ke halaman lain
    exit;
}

// Sisanya dari kode edit.php seperti yang Anda miliki
?>


<!DOCTYPE html>
<html lang="en">
<head>
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
        <div class="user-panel">
          <div class="image">
            <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-1" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
          </div>
        </div><!-- /Block user -->
      </li>

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
            <h1>Edit Artikel</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <form method="post" action="prosesdata/editconfig.php" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="form-group">
          <label for="exampleFormControlInput1">Judul Artikel</label>
          <input type="text" class="form-control" name="judul" id="exampleFormControlInput1" value="<?php echo $row['judul']; ?>" required>
        </div>
        <div class="form-group">
          <label for="exampleFormControlInput1">Kategori</label>
          <input type="text" class="form-control" name="kategori" id="exampleFormControlInput1" value="<?php echo $row['kategori']; ?>" required>
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Masukkan Informasi Menarik</label>
          <textarea class="form-control" name="konten" id="exampleFormControlTextarea1" rows="3" required><?php echo $row['konten']; ?></textarea>
        </div>
        <!-- Upload Gambar -->
        <div class="form-group">
          <label for="exampleInputFile">Thumbnail</label>
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="gambar" id="exampleInputFile">
              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
            </div>
            <div class="input-group-append">
              <span class="input-group-text">Upload</span>
            </div>
          </div>
        </div>
        <!-- Publish -->
        <div class="form-check">
    <input class="form-check-input" type="radio" name="publish" id="publish" value="1" <?php echo ($row['publish'] == 1) ? 'checked' : ''; ?>>
    <label class="form-check-label" for="publish">Publish</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="publish" id="draft" value="0" <?php echo ($row['publish'] == 0 || !$row['publish']) ? 'checked' : ''; ?>>
    <label class="form-check-label" for="draft">Draft</label>
</div>


        
      <!-- Tags -->
      <div class="form-group">
        <label for="exampleFormControlInput1">Tags</label>
        <input type="text" class="form-control" name="tags" id="exampleFormControlInput1" value="<?php echo $row['tags']; ?>">
      </div>

      <!-- Creator -->
      <div class="form-group">
        <label for="exampleFormControlInput1">Creator</label>
        <input type="text" class="form-control" name="creator" id="exampleFormControlInput1" value="<?php echo $row['creator']; ?>" required>
      </div>
       <div class="card-footer">
        <a href="artikel.php" class="btn btn-danger" role="button">Batal Edit</a>
        <button class="btn btn-success" type="submit">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</section>
    <!-- /.Main content end-->

    
  </div>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
