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

// Update tabel users (Cek apakah password diisi atau kosong)
if ($password != "") {
    // Enkripsi password baru agar sesuai standar keamanan sistem
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET username='$username', password='$password_hashed' WHERE id='$id'";
} else {
    $sql = "UPDATE users SET username='$username' WHERE id='$id'";
}

$query = mysqli_query($koneksi, $sql);

if ($query) {
    // Update session username agar nama di navbar langsung terupdate secara realtime
    $_SESSION['username'] = $username;
    
    echo "<script>alert('Profil Admin Berhasil Diperbarui!'); window.location.href='tabel_admin.php';</script>";
} else {
    echo "<script>alert('Gagal memperbarui profil: " . mysqli_error($koneksi) . "'); window.location.href='form_edit_admin.php';</script>";
}
?>
