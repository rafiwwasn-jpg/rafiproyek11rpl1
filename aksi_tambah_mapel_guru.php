<?php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='dashboard.php';</script>";
    exit;
}

if (isset($_POST['simpan'])) {
    $guru_id = intval($_POST['guru_id']);
    $nama_mapel = mysqli_real_escape_string($koneksi, $_POST['nama_mapel']);
    $kode_mapel = mysqli_real_escape_string($koneksi, $_POST['kode_mapel']);

    if (empty($guru_id) || empty($nama_mapel) || empty($kode_mapel)) {
        echo "<script>alert('Semua kolom wajib diisi!'); window.location.href='form_tambah_mapel_guru.php';</script>";
        exit;
    }

    // Masukkan data mapel baru dengan menghubungkannya ke guru yang dipilih
    $sql_insert = "INSERT INTO mapel (nama_mapel, kode_mapel, guru_id) VALUES ('$nama_mapel', '$kode_mapel', $guru_id)";
    $query = mysqli_query($koneksi, $sql_insert);

    if ($query) {
        echo "<script>alert('Mata pelajaran berhasil ditambahkan dan dihubungkan ke guru!'); window.location.href='tabel_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($koneksi) . "'); window.location.href='form_tambah_mapel_guru.php';</script>";
    }
} else {
    header("Location: form_tambah_mapel_guru.php");
    exit;
}
?>
