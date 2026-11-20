<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='formlogin.php';</script>";
    exit;
}

include "koneksi.php";
include "navguru.php";

// Query untuk mengambil semua data user dengan role 'guru'
$sql = "SELECT users.username, guru.nip, guru.nama, guru.jenis_kelamin 
        FROM users 
        LEFT JOIN guru ON users.id = guru.user_id 
        WHERE users.role = 'guru' 
        ORDER BY guru.nama ASC"; 

$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Guru - pripayer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styls.css">
</head>
<body>
    
    <div class="container mt-5">
        
        <!-- Bagian Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Daftar Guru</h1>
            <div class="d-flex gap-2">
                <button onclick="history.back()" class="btn btn-secondary">Kembali</button>
            </div>
        </div>

        <!-- Tabel Data (Tanpa Card, thead table-dark) -->
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">NIP</th>
                    <th width="30%">Nama Lengkap</th>
                    <th width="20%">Jenis Kelamin</th>
                    <th width="25%">Username (Akun)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (mysqli_num_rows($query) > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                        // Cek data kosong (jika profil belum diisi)
                        $nip = !empty($data['nip']) ? htmlspecialchars($data['nip']) : '<span class="text-muted fst-italic">Belum diisi</span>';
                        $nama = !empty($data['nama']) ? htmlspecialchars($data['nama']) : '<span class="text-muted fst-italic">Belum diisi</span>';
                        
                        // Mengubah kode L/P menjadi teks lengkap
                        $jk = '<span class="text-muted fst-italic">Belum diisi</span>';
                        if ($data['jenis_kelamin'] == 'L') {
                            $jk = 'Laki-Laki';
                        } elseif ($data['jenis_kelamin'] == 'P') {
                            $jk = 'Perempuan';
                        }
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $nip; ?></td>
                    <td><?php echo $nama; ?></td>
                    <td><?php echo $jk; ?></td>
                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($data['username']); ?></span></td>
                </tr>
                <?php 
                    }
                } else {
                    // Jika tidak ada data guru di database
                    echo "<tr><td colspan='5' class='text-center text-muted py-4'>Belum ada data guru yang terdaftar.</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
