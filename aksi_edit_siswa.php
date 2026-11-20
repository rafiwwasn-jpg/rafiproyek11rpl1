<?php
session_start();
require_once 'koneksi.php';

// Cek keamanan, cegah akses langsung ke file aksi tanpa submit form
if (!isset($_POST['kirim'])) {
    header("Location: Usersss.php");
    exit;
}

$id = $_POST['id'];
$username = $_POST['username'];
$password = trim($_POST['password']); 
$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$jenis = $_POST['jenis_kelamin'];

// 1. UPDATE TABEL USERS (Cek apakah password diisi atau kosong)
if ($password != "") {
    $sql_users = "UPDATE users SET username='$username', password='$password' WHERE id='$id'";
} else {
    $sql_users = "UPDATE users SET username='$username' WHERE id='$id'";
}
mysqli_query($koneksi, $sql_users);

// Update data session agar navbar langsung berubah tanpa perlu relogin
$_SESSION['username'] = $username;
$_SESSION['nama'] = $nama;

// 2. UPDATE TABEL PROFIL SISWA
$sql_profil = "UPDATE siswa SET nis='$nis', nama='$nama', kelas='$kelas', jenis_kelamin='$jenis' WHERE user_id='$id'";
mysqli_query($koneksi, $sql_profil);

// 3. KEMBALI KE HALAMAN DASHBOARD SISWA (Usersss.php)
echo "<script>alert('Profil Berhasil Diperbarui!'); window.location.href='Usersss.php';</script>";
?>
