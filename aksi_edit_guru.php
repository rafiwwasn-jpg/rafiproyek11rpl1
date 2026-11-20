<?php
session_start();
require_once 'koneksi.php';

// Cek keamanan, cegah akses langsung ke file aksi
if (!isset($_POST['kirim'])) {
    header("Location: tabel_guru.php");
    exit;
}

$id = $_POST['id'];
$username = $_POST['username'];
$password = trim($_POST['password']); 
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$jenis = $_POST['jenis_kelamin'];

// 1. UPDATE TABEL USERS (Cek apakah password diisi atau kosong)
if ($password != "") {
    $sql_users = "UPDATE users SET username='$username', password='$password' WHERE id='$id'";
} else {
    $sql_users = "UPDATE users SET username='$username' WHERE id='$id'";
}
mysqli_query($koneksi, $sql_users);

// Update session username jika username diganti
$_SESSION['username'] = $username;
// Update session nama agar navbar ikut terupdate
$_SESSION['nama'] = $nama;

// 2. UPDATE TABEL PROFIL GURU
$sql_profil = "UPDATE guru SET nip='$nip', nama='$nama', jenis_kelamin='$jenis' WHERE user_id='$id'";
mysqli_query($koneksi, $sql_profil);

// 3. KEMBALI KE TABEL GURU
echo "<script>alert('Profil Berhasil Diperbarui!'); window.location.href='tabel_guru.php';</script>";
?>
