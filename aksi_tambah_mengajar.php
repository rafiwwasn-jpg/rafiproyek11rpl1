<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='usersss.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $mapel_id = $_POST['mapel_id'];
    $siswa_id = $_POST['siswa_id'];

    if (empty($mapel_id) || empty($siswa_id)) {
        // Jika form kosong, kembali ke tambah_ngajar.php
        echo "<script>alert('Pilihan Mapel dan Siswa tidak boleh kosong!'); window.location.href='tambah_ngajar.php';</script>";
        exit;
    }

    $sql_insert = "INSERT INTO mengajar (mapel_id, siswa_id) VALUES ($mapel_id, $siswa_id)";
    $query_insert = mysqli_query($koneksi, $sql_insert);

    if ($query_insert) {
        echo "<script>alert('Berhasil! Data Mengajar sudah ditentukan'); window.location.href='tabel_admim.php';</script>";
    } else {
        $error_db = mysqli_error($koneksi);
        // Jika error database, kembali ke tambah_ngajar.php
        echo "<script>alert('Gagal menyimpan data! Error MySQL: " . addslashes($error_db) . "'); window.location.href='tambah_ngajar.php';</script>";
    }

} else {
    // Jika diakses langsung tanpa lewat form, lempar ke tambah_ngajar.php
    header("Location: tambah_ngajar.php");
    exit;
}
?>
