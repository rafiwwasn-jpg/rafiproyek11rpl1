<?php
session_start();
require_once 'koneksi.php';

// Pastikan yang mengakses hanya admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='dashboard.php';</script>";
    exit;
}

if (isset($_POST['simpan'])) {
    $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $mapel_id = intval($_POST['mapel_id']);

    // Validasi input kosong
    if (empty($kelas) || empty($mapel_id)) {
        echo "<script>alert('Kelas dan Guru/Mapel wajib dipilih!'); window.location.href='form_tambah_mengajar.php';</script>";
        exit;
    }

    // 1. Ambil semua ID siswa berdasarkan kelas yang dipilih di form
    $q_siswa = mysqli_query($koneksi, "SELECT id FROM siswa WHERE kelas = '$kelas'");
    
    if ($q_siswa && mysqli_num_rows($q_siswa) > 0) {
        $berhasil = 0;
        
        // 2. Lakukan perulangan (looping) untuk memasukkan setiap siswa ke tabel mengajar
        while ($siswa = mysqli_fetch_assoc($q_siswa)) {
            $siswa_id = $siswa['id'];

            // Cek apakah data kombinasi mapel_id dan siswa_id sudah ada (mencegah duplikat)
            $cek = mysqli_query($koneksi, "SELECT id FROM mengajar WHERE mapel_id = $mapel_id AND siswa_id = $siswa_id");
            
            if (mysqli_num_rows($cek) == 0) {
                // Masukkan ke database sesuai struktur tabel asli (mapel_id & siswa_id)
                $insert = mysqli_query($koneksi, "INSERT INTO mengajar (mapel_id, siswa_id) VALUES ($mapel_id, $siswa_id)");
                if ($insert) {
                    $berhasil++;
                }
            }
        }

        echo "<script>alert('Berhasil memploting $berhasil siswa untuk kelas $kelas!'); window.location.href='daftar_mengajar.php';</script>";
    } else {
        echo "<script>alert('Gagal! Tidak ditemukan siswa di kelas $kelas.'); window.location.href='form_tambah_mengajar.php';</script>";
    }
} else {
    header("Location: form_tambah_mengajar.php");
    exit;
}
?>
