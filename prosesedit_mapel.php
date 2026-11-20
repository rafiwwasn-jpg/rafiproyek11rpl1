<?php
require_once 'koneksi.php';

// Tangkap data dari form
$id = $_POST['id'];
$kode_mapel = $_POST['kode_mapel'];
$nama_mapel = $_POST['nama_mapel'];
$guru_id = $_POST['guru_id'];

// Update data mapel
$sql = "UPDATE mapel SET 
        kode_mapel = '$kode_mapel', 
        nama_mapel = '$nama_mapel', 
        guru_id = '$guru_id' 
        WHERE id = '$id'";

// Eksekusi dan kembali ke halaman tabel
if (mysqli_query($koneksi, $sql)) {
    echo "<script>alert('Data Mata Pelajaran Berhasil Diperbarui!'); window.location.href='tabelmapel.php';</script>";
} else {
    echo "<script>alert('Gagal mengedit data mata pelajaran!'); window.location.href='tabelmapel.php';</script>";
}
?>
