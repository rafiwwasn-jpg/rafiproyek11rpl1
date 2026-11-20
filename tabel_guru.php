<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='formlogin.php';</script>";
    exit;
}

include "koneksi.php";
include "navguru.php";

$username_aktif = $_SESSION['username'];
$role_aktif = $_SESSION['role'];
$nama = "";

// Query untuk mengambil nama guru yang sedang login
$sql = "SELECT guru.nama
        FROM users
        LEFT JOIN guru ON users.id = guru.user_id
        WHERE users.username = '$username_aktif'";

$hasil = mysqli_query($koneksi, $sql);

if ($hasil && mysqli_num_rows($hasil) > 0) { 
    $row = mysqli_fetch_assoc($hasil);
    $nama = $row['nama'];
}

// Jika data nama di tabel guru masih kosong, gunakan username
if (empty($nama)) {
    $nama = $username_aktif;
}

// ==========================================
// LOGIKA MEMBUAT INISIAL UNTUK FOTO PROFIL
// ==========================================
$pecah_nama = explode(' ', trim($nama));
$inisial = '';

// Ambil huruf pertama dari kata pertama
if (isset($pecah_nama[0]) && !empty($pecah_nama[0])) {
    $inisial .= strtoupper(substr($pecah_nama[0], 0, 1));
}
// Ambil huruf pertama dari kata kedua (jika namanya lebih dari 1 kata)
if (isset($pecah_nama[1]) && !empty($pecah_nama[1])) {
    $inisial .= strtoupper(substr($pecah_nama[1], 0, 1));
}
// Jika inisial masih kosong
if (empty($inisial)) {
    $inisial = 'U'; 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard <?php echo ucfirst($role_aktif); ?> - pripayer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styls.css">
</head>
<body>
    
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center p-5">
                        
                        <!-- Tampilan Foto Profil Inisial -->
                        <div class="mb-4">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto shadow" 
                                 style="width: 100px; height: 100px; font-size: 40px; font-weight: bold; letter-spacing: 2px;">
                                <?php echo $inisial; ?>
                            </div>
                        </div>

                        <!-- Teks Sambutan Utama -->
                        <h1 class="display-5 fw-bold text-primary mb-3">
                            Selamat Datang, <?php echo htmlspecialchars($nama); ?>!
                        </h1>
                        
                        <p class="lead mb-4">
                            Anda Adalah <span class="badge bg-success fs-6"><?php echo strtoupper($role_aktif); ?></span>
                        </p>
                        
                        <hr class="my-4 text-muted">
                        
                        <p class="text-muted mb-4">
                            Ini adalah halaman dashboard Anda. Silakan pilih menu di bawah ini untuk melihat data.
                        </p>

                        <!-- Tombol Navigasi -->
                        <div class="d-flex justify-content-center gap-3">
                            <!-- Ubah href sesuai dengan nama file halaman data guru dan siswa Anda -->
                            <a href="data_guru.php" class="btn btn-outline-primary btn-lg px-4">
                                👨‍🏫 List Guru
                            </a>
                            <a href="data_siswa.php" class="btn btn-outline-success btn-lg px-4">
                                🎓 List Murid
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
