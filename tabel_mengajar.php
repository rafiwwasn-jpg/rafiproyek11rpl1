<?php
session_start();

// Kunci gembok! Jika yang login bukan admin, langsung tendang ke dashboard.
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini khusus Admin.'); window.location.href='formlogin.php';</script>";
    exit;
}

include "koneksi.php";
include "navsiswa.php"; // Sesuaikan dengan navbar kamu

// Query untuk menggabungkan tabel mengajar, mapel, dan siswa
$sql = "SELECT mengajar.id, mapel.kode_mapel, mapel.nama_mapel, siswa.nis, siswa.nama AS nama_siswa 
        FROM mengajar
        JOIN mapel ON mengajar.mapel_id = mapel.id
        JOIN siswa ON mengajar.siswa_id = siswa.id
        ORDER BY mapel.nama_mapel ASC, siswa.nama ASC";

$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Plotting Mengajar - pripayer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styls.css">
</head>
<body>
    
    <div class="container mt-5 mb-5">
        
        <!-- Bagian Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Data Plotting Mengajar</h1>
            <div class="d-flex gap-2">
                <a href="tambah_ngajar.php" class="btn btn-primary">➕ Tambah Data</a>
                <button onclick="history.back()" class="btn btn-secondary">Kembali</button>
            </div>
        </div>

        <!-- Tabel Data -->
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Kode Mapel</th>
                    <th width="30%">Mata Pelajaran</th>
                    <th width="15%">NIS Siswa</th>
                    <th width="25%">Nama Siswa</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($query && mysqli_num_rows($query) > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                        $kode = !empty($data['kode_mapel']) ? htmlspecialchars($data['kode_mapel']) : '-';
                        $nis = !empty($data['nis']) ? htmlspecialchars($data['nis']) : '-';
                ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <td class="text-center"><span class="badge bg-secondary"><?php echo $kode; ?></span></td>
                    <td><?php echo htmlspecialchars($data['nama_mapel']); ?></td>
                    <td class="text-center"><?php echo $nis; ?></td>
                    <td><?php echo htmlspecialchars($data['nama_siswa']); ?></td>
                    <td class="text-center">
                        <a href="aksi_hapus_mengajar.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data plotting ini?')">Hapus</a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center text-muted py-4'>Belum ada data plotting mengajar yang ditambahkan.</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
