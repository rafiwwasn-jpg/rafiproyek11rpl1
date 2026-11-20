<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='formlogin.php';</script>";
    exit;
}

include "koneksi.php";
include "navsiswa.php"; // Sesuaikan dengan navbar yang kamu gunakan

// Query untuk mengambil data mapel beserta nama gurunya
// ASUMSI: Di tabel 'mapel' terdapat kolom 'guru_id' yang berelasi dengan tabel 'guru'
$sql = "SELECT mapel.kode_mapel, mapel.nama_mapel, guru.nama AS nama_guru
        FROM mapel 
        LEFT JOIN guru ON mapel.guru_id = guru.id
        ORDER BY mapel.nama_mapel ASC"; 

$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Mapel - pripayer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styls.css">
</head>
<body>
    
    <div class="container mt-5">
        
        <!-- Bagian Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Daftar Mata Pelajaran</h1>
            <div class="d-flex gap-2">
                <button onclick="history.back()" class="btn btn-secondary">Kembali</button>
            </div>
        </div>

        <!-- Tabel Data -->
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode Mapel</th>
                    <th width="40%">Nama Mata Pelajaran</th>
                    <th width="40%">Nama Guru Pengajar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                // Cek apakah query berhasil dan ada datanya
                if ($query && mysqli_num_rows($query) > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                        $kode = !empty($data['kode_mapel']) ? htmlspecialchars($data['kode_mapel']) : '<span class="text-muted fst-italic">-</span>';
                        $nama_mapel = !empty($data['nama_mapel']) ? htmlspecialchars($data['nama_mapel']) : '<span class="text-muted fst-italic">Belum ada nama</span>';
                        
                        // Menangani jika data guru belum di-set untuk mapel tersebut
                        $nama_guru = !empty($data['nama_guru']) ? htmlspecialchars($data['nama_guru']) : '<span class="text-muted fst-italic">Belum ada guru yang ditugaskan</span>';
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><span class="badge bg-secondary"><?php echo $kode; ?></span></td>
                    <td><?php echo $nama_mapel; ?></td>
                    <td><?php echo $nama_guru; ?></td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center text-muted py-4'>Belum ada data mata pelajaran.</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
