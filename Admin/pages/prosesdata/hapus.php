
<?php
session_start();

include '../../../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query SQL untuk menghapus data
    $query = "DELETE FROM post WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    // Eksekusi query
    if ($stmt->execute()) {
        $_SESSION['success'] = "Artikel berhasil dihapus";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi ke database
$conn->close();

// Alihkan kembali ke artikel.php setelah penghapusan
header("Location: ../artikel.php");
exit();
?>
