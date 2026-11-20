<?php
require_once "koneksi.php";

// Ambil ID dari URL
$id = $_GET['id'];

// Query untuk menghapus data mapel berdasarkan ID
$sql = "DELETE FROM mapel WHERE id = '$id'";

// Eksekusi query
if (mysqli_query($koneksi, $sql)) {
    // Jika berhasil, arahkan kembali ke halaman tabel mapel
    echo "<script>alert('Data mata pelajaran berhasil dihapus!'); window.location.href='tabelmapel.php';</script>";
} else {
    // Jika gagal
    echo "<script>alert('Gagal menghapus data mapel!'); window.location.href='tabelmapel.php';</script>";
}
?>
