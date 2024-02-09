<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "emading";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
// Fungsi untuk menambah jumlah views pada berita
function incrementViewerCount($postId, $conn) {
    $query = "UPDATE post SET views = views + 1 WHERE id = $postId";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
}

// Fungsi untuk mendapatkan jumlah viewers berita
if (!function_exists('getViewerCount')) {
    function getViewerCount($postId, $conn) {
        $query = "SELECT views FROM post WHERE id = $postId";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['views'];
        } else {
            die("Query failed: " . mysqli_error($conn));
        }
    }
}
?>