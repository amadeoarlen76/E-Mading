<?php
include 'config/koneksi.php';

// Query untuk mengambil data dari database
$query = "SELECT * FROM post";
$result = mysqli_query($conn, $query);

// Memeriksa apakah query berhasil dijalankan
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Setelah loop, cek apakah ada parameter 'id' pada URL
if (isset($_GET['id'])) {
    $postId = $_GET['id'];

    // Panggil fungsi untuk menambah jumlah views
    incrementViewerCount($postId, $conn);

    // Redirect ke halaman blog-single.php
    header("Location: pembaca/blog-single.php?id=$postId");
    exit();
}


// Fungsi untuk mendapatkan jumlah viewers berita
function getViewerCount($postId, $conn) {
    $query = "SELECT COUNT(*) as count FROM post WHERE id = $postId";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    } else {
        die("Query failed: " . mysqli_error($conn));
    }
}

// Query untuk mengambil berita terfavorit berdasarkan views
$queryBanner = "SELECT * FROM post ORDER BY views DESC LIMIT 1";
$resultBanner = mysqli_query($conn, $queryBanner);

// Memeriksa apakah query berhasil dijalankan
if (!$resultBanner) {
    die("Query failed: " . mysqli_error($conn));
}

// Ambil data berita terfavorit
$rowBanner = mysqli_fetch_assoc($resultBanner);
?>

<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>JeWePe - Magazine blog Pages</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--Favicon-->
	<link rel="shortcut icon" href="pembaca/images/favicon.ico" type="image/x-icon">

	<!-- THEME CSS
	================================================== -->
	<!-- Bootstrap -->
	<link rel="stylesheet" href="pembaca/plugins/bootstrap/css/bootstrap.min.css">
	<!-- Themify -->
	<link rel="stylesheet" href="pembaca/plugins/themify/css/themify-icons.css">
	<link rel="stylesheet" href="pembaca/plugins/slick-carousel/slick-theme.css">
	<link rel="stylesheet" href="pembaca/plugins/slick-carousel/slick.css">
	<!-- Slick Carousel -->
	<link rel="stylesheet" href="pembaca/plugins/owl-carousel/owl.carousel.min.css">
	<link rel="stylesheet" href="pembaca/plugins/owl-carousel/owl.theme.default.min.css">
	<link rel="stylesheet" href="pembaca/plugins/magnific-popup/magnific-popup.css">
	<!-- manin stylesheet -->
	<link rel="stylesheet" href="pembaca/css/style.css">
</head>

<body>



	<header class="header-top bg-grey justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-2 header-left col-md-4 col-7">
					<ul class="list-inline header-socials-2 mb-0 text-center">
						<li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="ti-twitter"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="ti-linkedin"></i></a></li>
						<li class="list-inline-item"><a href="#"><i class="ti-pinterest"></i></a></li>
						<li class="list-inline-item">
							<div class="search_toggle mobile-search d-md-block d-lg-none"><i class="ti-search"></i></div>
						</li>
					</ul>
				</div>

				<div class="col-lg-8 text-center col-md-8 col-5">
					<nav class="navbar navbar-expand-lg navigation">
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
							aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="ti-menu"></span>
						</button>
						<div class="collapse navbar-collapse" id="navbarContent">
							<ul id="menu" class="menu navbar-nav mx-auto ">
								<li class="nav-item"><a href="#" class="nav-link">Home</a></li>
								<li class="nav-item"><a href="pembaca/about.html" class="nav-link">About</a></li>
								<li class="nav-item"><a href="pembaca/fashion.html" class="nav-link">Category</a></li>
								<li class="nav-item"><a href="pembaca/contact.html" class="nav-link">Contact</a></li>

							</ul>
						</div>
					</nav>
				</div>

				<div class="col-lg-2">
					<div class="text-right search">
						<div class="search_toggle d-none d-lg-block"><i class="ti-search"></i></div>
					</div>
				</div>
			</div>
		</div>
	</header>


	<div class="header-logo py-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 text-center">
					<a class="navbar-brand" href="#"><img src="pembaca/images/logo.png" alt="" class="img-fluid"></a>
				</div>
			</div>
		</div>
	</div>


	<!--search overlay start-->
	<div class="search-wrap">
		<div class="overlay">
			<form action="#" class="search-form">
				<div class="container">
					<div class="row">
						<div class="col-md-10 col-9">
							<input type="text" class="form-control" placeholder="Search..." />
						</div>
						<div class="col-md-2 col-3 text-right">
							<div class="search_toggle toggle-wrap d-inline-block">
								<i class="ti-close"></i>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!--search overlay end-->

<!-- Banner gede dari hot news / berita sering dibaca -->
<section class="banner">
    <div class="container">
        <?php
        // Query untuk mengambil berita terfavorit berdasarkan views dan yang dipublish
        $queryBanner = "SELECT * FROM post WHERE publish = 1 ORDER BY views DESC LIMIT 1";
        $resultBanner = mysqli_query($conn, $queryBanner);

        // Memeriksa apakah query berhasil dijalankan
        if ($resultBanner) {
            $rowBanner = mysqli_fetch_assoc($resultBanner);
            if ($rowBanner) {
        ?>
                <div class="banner-img">
                    <a href="pembaca/blog-single.php?id=<?php echo $rowBanner['id']; ?>">
                        <img src="admin/pages/prosesdata/uploads/<?php echo $rowBanner['gambar']; ?>" alt="" class="img-fluid w-100" style="max-width: 100%; max-height: 400px;">
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="banner-content text-center">
                            <div class="meta-cat">
                                <span class="text-capitalize letter-spacing-1 cat-name font-extra text-color"><?php echo $rowBanner['kategori']; ?></span>
                            </div>
                            <div class="post-title">
                                <h2><a href="pembaca/blog-single.php?id=<?php echo $rowBanner['id']; ?>"><?php echo $rowBanner['judul']; ?></a></h2>
                            </div>

                            <div class="post-meta footer-meta">
                                <ul class="list-inline">
                                    <li class="post-like list-inline-item">
                                        By: <span class="count"><?php echo $rowBanner['creator']; ?></span>
                                    </li>
                                    <li class="post-read list-inline-item">
                                        Tags: <span class="count"><?php echo $rowBanner['tags']; ?></span>
                                    </li>
                                    <li class="post-view list-inline-item"><?php echo $rowBanner['views']; ?> Views</li>
                                </ul>
                            </div>
                            <div class="post-content">
                                <p><?php echo substr($rowBanner['konten'], 0, 150) . '...'; ?></p>
                                <a href="pembaca/blog-single.php?id=<?php echo $rowBanner['id']; ?>" class="btn btn-grey mt-3">Read more</a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "Query failed: " . mysqli_error($conn);
        }
        ?>
    </div>
</section>





	<section class="section-padding pt-4">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
					
<!-- Bagian loop untuk menampilkan berita -->
<?php
while ($row = mysqli_fetch_assoc($result)) :
    $postId = $row['id'];
    $viewerCount = getViewerCount($postId, $conn);

    // Tambahkan kondisi untuk mengecek status artikel
    if ($row['publish'] == 1) { // 1 untuk artikel yang published
?>
        <div class="mb-4 post-list border-bottom pb-4">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <!--path gambar -->
                    <a class="post-thumb" href="pembaca/blog-single.php?id=<?php echo $postId; ?>">
                        <img src="admin/pages/prosesdata/uploads/<?php echo $row['gambar']; ?>" alt="" class="img-fluid w-100" style="max-width: 100%; height: 100%; object-fit: cover;">
                    </a>
                </div>

                <div class="col-md-7">
                    <div class="post-article mt-sm-3">
                        <div class="meta-cat">
                            <span class="letter-spacing cat-name font-extra text-uppercase font-sm"><?php echo $row['kategori']; ?></span>
                        </div>
                        <h3 class="post-title mt-2">
                            <a href="pembaca/blog-single.php?id=<?php echo $postId; ?>"><?php echo $row['judul']; ?></a>
                        </h3>

                        <div class="post-meta">
                            <ul class="list-inline">
                                <li class="post-like list-inline-item">
                                    <span class="font-sm letter-spacing-1 text-uppercase">
                                        <i class="ti-time mr-2"></i><?php echo $row['creator']; ?>
                                    </span>
                                </li>
                                <li class="post-view list-inline-item letter-spacing-1">
                                    <?php echo $row['views'] . ' Views'; ?>
                                </li>
                            </ul>
                        </div>
                        <div class="post-content">
                            <p><?php echo substr($row['konten'], 0, 150) . '...'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
endwhile;
?>






					
					<!-- Pagination -->
					<div class="pagination mt-5 pt-4">
						<ul class="list-inline">
							<li class="list-inline-item"><a href="#" class="active">1</a></li>
							<li class="list-inline-item"><a href="#">2</a></li>
							<li class="list-inline-item"><a href="#">3</a></li>
							<li class="list-inline-item"><a href="#" class="prev-posts"><i class="ti-arrow-right"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-4 col-md-8 col-sm-12 col-xs-12">
					<div class="sidebar sidebar-right">
						<div class="sidebar-wrap mt-5 mt-lg-0">
							<div class="sidebar-widget about mb-5 text-center p-3">
								<div class="about-author">
									<img src="pembaca/images/author.jpg" alt="" class="img-fluid">
								</div>
								<h4 class="mb-0 mt-4">Liam Mason</h4>
								<p>Headmaster</p>
								<p>Halo, Selamat datang di Blog Berita JeWePe, dapatkan informasi seputar sekolah ataupun pengetahuan menarik disini!</p>
								<img src="pembaca/images/liammason.png" alt="" class="img-fluid">
							</div>

							<div class="sidebar-widget follow mb-5 text-center">
								<h4 class="text-center widget-title">Follow Me</h4>
								<div class="follow-socials">
									<a href="#"><i class="ti-facebook"></i></a>
									<a href="#"><i class="ti-twitter"></i></a>
									<a href="#"><i class="ti-instagram"></i></a>
									<a href="#"><i class="ti-youtube"></i></a>
									<a href="#"><i class="ti-pinterest"></i></a>
								</div>
							</div>
							<!-- untuk yang di commen dibawah ini, cara untuk menampilkan hot news -->
							<!-- tidak diaktifkan karena tidak tahu cara penggunaannya -->
							<!-- <div class="sidebar-widget mb-5 ">
								<h4 class="text-center widget-title">Trending Posts</h4>

								<div class="sidebar-post-item-big">
									<a href="pembaca/blog-single.html"><img src="pembaca/images/news/img-1.jpg" alt="" class="img-fluid"></a>
									<div class="mt-3 media-body">
										<span class="text-muted letter-spacing text-uppercase font-sm">September 10, 2019</span>
										<h4><a href="pembaca/blog-single.html">Meeting With Clarissa, Founder Of Purple Conversation App</a></h4>
									</div>
								</div>

								<div class="media border-bottom py-3 sidebar-post-item">
									<a href="#"><img class="mr-4" src="pembaca/images/news/thumb-1.jpg" alt=""></a>
									<div class="media-body">
										<span class="text-muted letter-spacing text-uppercase font-sm">September 10, 2019</span>
										<h4><a href="pembaca/blog-single.html">Thoughtful living in los Angeles</a></h4>
									</div>
								</div>

								<div class="media py-3 sidebar-post-item">
									<a href="#"><img class="mr-4" src="pembaca/images/news/thumb-2.jpg" alt=""></a>
									<div class="media-body">
										<span class="text-muted letter-spacing text-uppercase font-sm">September 10, 2019</span>
										<h4><a href="pembaca/blog-single.html">Vivamus molestie gravida turpis.</a></h4>
									</div>
								</div>
							</div> -->


							<div class="sidebar-widget category mb-5">
								<h4 class="text-center widget-title">Categories</h4>
								<ul class="list-unstyled">
									<?php
									// Query untuk mengambil kategori dari tabel post
									$kategori_query = "SELECT DISTINCT kategori, COUNT(*) as count FROM post GROUP BY kategori";
									$kategori_result = mysqli_query($conn, $kategori_query);
									if ($kategori_result) {
										while ($kategori_row = mysqli_fetch_assoc($kategori_result)) {
											$kategori_name = $kategori_row['kategori'];
											$kategori_count = $kategori_row['count'];
											?>
											<li class="align-items-center d-flex justify-content-between">
												<a href="#"><?php echo $kategori_name; ?></a>
												<span><?php echo $kategori_count; ?></span>
											</li>
											<?php
											}
										} else {
											echo "Query failed: " . mysqli_error($conn);
										}
										?>
										</ul>
									</div>

							<div class="sidebar-widget subscribe mb-5">
								<h4 class="text-center widget-title">Newsletter</h4>
								<input type="text" class="form-control" placeholder="Email Address">
								<a href="#" class="btn btn-primary d-block mt-3">Sign Up</a>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="footer-2 section-padding gray-bg pb-5">
		<div class="container">
			<div class="footer-btm mt-5 pt-4 border-top">
				<div class="row">
					<div class="col-lg-12">
						<ul class="list-inline footer-socials-2 text-center">
							<li class="list-inline-item"><a href="#">Privacy policy</a></li>
							<li class="list-inline-item"><a href="#">Support</a></li>
							<li class="list-inline-item"><a href="#">About</a></li>
							<li class="list-inline-item"><a href="#">Contact</a></li>
							<li class="list-inline-item"><a href="#">Terms</a></li>
							<li class="list-inline-item"><a href="#">Category</a></li>
						</ul>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-6">
						<div class="copyright text-center ">
							@ copyright all reserved to <a href="https://themefisher.com/">themefisher.com</a>-2019 Distribution
							<a " href=" https://themewagon.com">ThemeWagon.</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!-- THEME JAVASCRIPT FILES
================================================== -->
	<!-- initialize jQuery Library -->
	<script src="plugins/jquery/jquery.js"></script>
	<!-- Bootstrap jQuery -->
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="plugins/bootstrap/js/popper.min.js"></script>
	<!-- Owl caeousel -->
	<script src="plugins/owl-carousel/owl.carousel.min.js"></script>
	<script src="plugins/slick-carousel/slick.min.js"></script>
	<script src="plugins/magnific-popup/magnific-popup.js"></script>
	<!-- Instagram Feed Js -->
	<script src="plugins/instafeed-js/instafeed.min.js"></script>
	<!-- Google Map -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
	<script src="plugins/google-map/gmap.js"></script>
	<!-- main js -->
	<script src="js/custom.js"></script>


</body>

</html>