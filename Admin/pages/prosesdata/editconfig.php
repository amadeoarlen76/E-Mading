<?php
include('../../../config/koneksi.php'); // Pastikan file koneksi.php sudah di-include dengan path yang benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $konten = $_POST['konten'];
    
    // Pemeriksaan untuk elemen "publish"
    $publish = isset($_POST['publish']) ? $_POST['publish'] : ''; // Default kosong jika tidak ada
    
    $tags = $_POST['tags'];
    $creator = $_POST['creator'];

    // Periksa apakah gambar baru diupload
    if ($_FILES['gambar']['name']) {
        // Proses upload gambar
        $file_name = $_FILES['gambar']['name'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($file_tmp, "uploads/" . $file_name);

        // Query untuk memperbarui data artikel dengan gambar baru
        $query = "UPDATE post SET 
                  judul = '$judul', 
                  kategori = '$kategori', 
                  konten = '$konten', 
                  publish = '$publish', 
                  tags = '$tags', 
                  creator = '$creator', 
                  gambar = '$file_name'
                  WHERE id = $id";
    } else {
        // Query untuk memperbarui data artikel tanpa mengubah gambar
        $query = "UPDATE post SET 
                  judul = '$judul', 
                  kategori = '$kategori', 
                  konten = '$konten', 
                  publish = '$publish', 
                  tags = '$tags', 
                  creator = '$creator'
                  WHERE id = $id";
    }

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Data berhasil diperbarui.";
        header("Location: ../artikel.php");
        // Mungkin redirect ke halaman lain atau tampilkan pesan sukses
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
        // Mungkin tampilkan pesan error atau redirect ke halaman lain
    }
} else {
    echo "Metode permintaan tidak valid.";
    // Mungkin tampilkan pesan atau redirect ke halaman lain
}
?>
