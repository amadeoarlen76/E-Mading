<?php
session_start();
// menyertakan koneksi ke database
include '../../../config/koneksi.php';
// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses validasi dan sanitasi data
    // Simpan data ke database
    $query = "INSERT INTO post (judul, kategori, konten, gambar, publish, tags, creator) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    // Bind parameter
    $stmt->bind_param("sssssss", $judul, $kategori, $konten, $gambar, $publish, $tags, $creator);
    // Ambil data dari formulir
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $konten = $_POST['konten'];
    $gambar = $_FILES['gambar']['name'];
    $publish = $_POST['publish'];
    $tags = $_POST['tags'];
    $creator = $_POST['creator'];
    // Upload gambar ke folder uploads/
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['gambar']['name']);
    move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file);
    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, arahkan kembali ke artikel.php
        $_SESSION['success'] = "Data berhasil disimpan";
        header("Location: ../artikel.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    // Tutup statement
    $stmt->close();
}
// Tutup koneksi ke database (letakkan di luar kondisi POST)
$conn->close();
?>
