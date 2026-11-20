<?php
session_start();
require_once 'koneksi.php';

// Pastikan hanya admin yang bisa mengakses
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='dashboard.php';</script>";
    exit;
}

if (isset($_GET['mapel_id']) && isset($_GET['kelas'])) {
    $mapel_id = intval($_GET['mapel_id']);
    $kelas = mysqli_real_escape_string($koneksi, $_GET['kelas']);

    // Hapus data plotting secara massal dalam 1 query menggunakan subquery (lebih cepat & aman)
    $sql_hapus = "DELETE FROM mengajar 
                  WHERE mapel_id = $mapel_id 
                  AND siswa_id IN (SELECT id FROM siswa WHERE kelas = '$kelas')";
    
    $query_hapus = mysqli_query($koneksi, $sql_hapus);

    if ($query_hapus) {
        echo "<script>alert('Data plotting kelas $kelas berhasil dihapus!'); window.location.href='daftar_mengajar.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "'); window.location.href='daftar_mengajar.php';</script>";
    }
} else {
    header("Location: daftar_mengajar.php");
    exit;
}
?>
