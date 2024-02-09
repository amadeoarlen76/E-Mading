<?php
// Include Config File
include "config/koneksi.php";

// Mulai Sesi
session_start();

// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "emading";

$conn = mysqli_connect($host, $user, $password, $database);

// Validasi input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['email']) || empty($_POST['password'])) {
    echo "Email atau password tidak boleh kosong!";
    exit;
  }

  // Gunakan Prepared Statements
  $query = "SELECT * FROM users WHERE email = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "s", $_POST['email']);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Cek hasil query
  if ($result && mysqli_num_rows($result) == 1) {
    // Ambil data user dari hasil query
    $user = mysqli_fetch_assoc($result);

    // Periksa kecocokan password dengan password_verify
    if (password_verify($_POST['password'], $user['password'])) {
      // Login berhasil
      $_SESSION['email'] = $user['email'];

      // Periksa session email atau id_users, apakah aktif?
      if (isset($_SESSION['email'])) {
        header("Location: Admin/index.php");
      } else {
        echo "Session tidak aktif!";
      }
    } else {
      // Login gagal - password tidak sesuai
      echo "Email atau password salah!";
    }
  } else {
    // Login gagal - user tidak ditemukan
    echo "Email atau password salah!";
  }

  // Tutup prepared statement
  mysqli_stmt_close($stmt);
}

// Tutup koneksi
mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <!-- Css biasa -->
    <link rel="stylesheet" type="text/css" href="/public/style.css">

    <title>LOGIN | E-Mading JeWePe</title>
</head>
<body class="login-layout blur-login">
    <section class="vh-100" style="background-image: url(https://images.unsplash.com/photo-1671342986457-f17f0d88d89c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2071&q=80);">
      <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="d-flex justify-content-center align-items-center vh-100">
          <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center">
              <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="bg-white rounded shadow-3-strong p-4">
                  
                  <div class="card-body p-3 text-center">
                    <h2 class="mb-1">JeWePe</h2>
                    <h3 class="mb-1">E-Mading Login</h3>
                  </div>

                  <form class="bg-white rounded shadow-5-strong p-5" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <!-- Username input -->
                    <div class="form-outline mb-4">
                      <input type="text" id="form1Example1" class="form-control" placeholder="Email" name="email"autofocus/>
                    </div>
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                      <input type="password" id="form1Example2" class="form-control" placeholder="Password" name="password" />
                    </div>
                    <!-- Checkbox & Forget Pass -->
                    <div class="pilihan">
                      <!-- Checkbox -->
                      <div class="form-check d-flex justify-content-start mb-4">
                        <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                        <label class="form-check-label mx-3" for="form1Example3"> Remember Me </label>
                      </div>
                      <!-- Forget Pass Link -->
                      <a class="btn btn-link d-flex justify-content-start mb-4" href="">Forgot Your Password?</a>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary w-100">LOGIN</button>
                  </form>
                </div>
              </div>
            </div>
          </div>  
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>