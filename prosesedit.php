<?php
require_once 'koneksi.php';

$id = $_POST['id'];
$role = $_POST['role'];
$username = $_POST['username'];
$password = trim($_POST['password']); 

// 1. UPDATE TABEL USERS (Tanpa Hash)
if ($password != "") {
    $sql_users = "UPDATE users SET username='$username', password='$password' WHERE id='$id'";
} else {
    $sql_users = "UPDATE users SET username='$username' WHERE id='$id'";
}

mysqli_query($koneksi, $sql_users);

// 2. UPDATE TABEL PROFIL (Berdasarkan Role)
if ($role == 'siswa') {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jenis = $_POST['jenis_kelamin'];
    
    $sql_profil = "UPDATE siswa SET nis='$nis', nama='$nama', kelas='$kelas', jenis_kelamin='$jenis' WHERE user_id='$id'";
    mysqli_query($koneksi, $sql_profil);
    
} elseif ($role == 'guru') {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis_kelamin'];
    
    $sql_profil = "UPDATE guru SET nip='$nip', nama='$nama', jenis_kelamin='$jenis' WHERE user_id='$id'";
    mysqli_query($koneksi, $sql_profil);
}

// 3. KEMBALI KE TABEL
echo "<script>alert('Data Pengguna Berhasil Diperbarui!'); window.location.href='tabel_admin.php';</script>";
?>
