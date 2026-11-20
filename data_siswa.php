<?php
session_start();

// Cek apakah user sudah login dan pastikan rolenya adalah guru
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    echo "<script>alert('Akses khusus Guru!'); window.location.href='dashboard.php';</script>";
    exit;
}

include "koneksi.php";
include "navguru.php"; 

$username_aktif = $_SESSION['username'];

// QUERY BERBASIS KELAS:
// Mengambil semua siswa yang kelasnya sudah di-plot/diajar oleh guru yang sedang login.
// Jadi, siswa baru yang masuk ke kelas tersebut akan OTOMATIS MUNCUL di sini tanpa syarat tambahan!
$sql = "SELECT DISTINCT users.username, siswa.nis, siswa.nama, siswa.kelas, siswa.jenis_kelamin 
        FROM siswa 
        JOIN users ON siswa.user_id = users.id
        WHERE siswa.kelas IN (
            SELECT DISTINCT s_sub.kelas 
            FROM mengajar m_sub
            JOIN mapel mp_sub ON m_sub.mapel_id = mp_sub.id
            JOIN guru g_sub ON mp_sub.guru_id = g_sub.id
            JOIN users ug_sub ON g_sub.user_id = ug_sub.id
            JOIN siswa s_sub ON m_sub.siswa_id = s_sub.id
            WHERE ug_sub.username = '$username_aktif'
        )
        ORDER BY siswa.kelas ASC, siswa.nama ASC"; 

$query = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Murid yang Diajar - pripayer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styls.css">
</head>
<body>
    
    <div class="container mt-5">
        
        <!-- Bagian Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Daftar Murid Berdasarkan Kelas yang Saya Ajar</h1>
            <div class="d-flex gap-2">
                <button onclick="history.back()" class="btn btn-secondary">Kembali</button>
            </div>
        </div>

        <!-- Tabel Data -->
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">NIS</th>
                    <th width="30%">Nama Lengkap</th>
                    <th width="15%">Kelas</th>
                    <th width="15%">Jenis Kelamin</th>
                    <th width="20%">Username (Akun)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($query && mysqli_num_rows($query) > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                        
                        $nis = !empty($data['nis']) ? htmlspecialchars($data['nis']) : '<span class="text-muted fst-italic">Belum diisi</span>';
                        $nama = !empty($data['nama']) ? htmlspecialchars($data['nama']) : '<span class="text-muted fst-italic">Belum diisi</span>';
                        $kelas = !empty($data['kelas']) ? htmlspecialchars($data['kelas']) : '<span class="text-muted fst-italic">Belum diisi</span>';
                        
                        $jk = '<span class="text-muted fst-italic">Belum diisi</span>';
                        if ($data['jenis_kelamin'] == 'L') {
                            $jk = 'Laki-Laki';
                        } elseif ($data['jenis_kelamin'] == 'P') {
                            $jk = 'Perempuan';
                        }
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $nis; ?></td>
                    <td><?php echo $nama; ?></td>
                    <td><span class="badge bg-primary"><?php echo $kelas; ?></span></td>
                    <td><?php echo $jk; ?></td>
                    <td><span class="badge bg-secondary"><?php echo htmlspecialchars($data['username']); ?></span></td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center text-muted py-4'>Belum ada data murid yang kelasnya di-plot untuk Anda.</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
