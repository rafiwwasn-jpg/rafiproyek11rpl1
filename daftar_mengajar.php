<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses khusus Admin!'); window.location.href='dashboard.php';</script>";
    exit;
}
require_once "koneksi.php";

// ==========================================
// FITUR AUTO-SYNC OTOMATIS DI BELAKANG LAYAR
// ==========================================
$sql_plot = "SELECT DISTINCT mengajar.mapel_id, siswa.kelas 
             FROM mengajar 
             JOIN siswa ON mengajar.siswa_id = siswa.id";
$query_plot = mysqli_query($koneksi, $sql_plot);

if ($query_plot && mysqli_num_rows($query_plot) > 0) {
    while ($plot = mysqli_fetch_assoc($query_plot)) {
        $mapel_id = $plot['mapel_id'];
        $kelas = $plot['kelas'];

        // Ambil semua siswa di kelas tersebut
        $q_siswa = mysqli_query($koneksi, "SELECT id FROM siswa WHERE kelas = '$kelas'");
        while ($s = mysqli_fetch_assoc($q_siswa)) {
            $siswa_id = $s['id'];

            // Cek apakah siswa ini sudah terdaftar di mapel tersebut
            $cek = mysqli_query($koneksi, "SELECT id FROM mengajar WHERE mapel_id = $mapel_id AND siswa_id = $siswa_id");
            if (mysqli_num_rows($cek) == 0) {
                // Jika belum ada (siswa baru), masukkan secara otomatis!
                mysqli_query($koneksi, "INSERT INTO mengajar (mapel_id, siswa_id) VALUES ($mapel_id, $siswa_id)");
            }
        }
    }
}
// ==========================================

// Query untuk menampilkan rekap per guru, kelas, dan mapel
$sql = "SELECT guru.nama AS nama_guru, siswa.kelas, mapel.nama_mapel, mapel.kode_mapel, mapel.id AS mapel_id
        FROM mengajar
        JOIN mapel ON mengajar.mapel_id = mapel.id
        LEFT JOIN guru ON mapel.guru_id = guru.id
        JOIN siswa ON mengajar.siswa_id = siswa.id
        GROUP BY mapel.id, siswa.kelas
        ORDER BY guru.nama ASC, siswa.kelas ASC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("<div class='alert alert-danger m-5'><b>Error SQL:</b> " . mysqli_error($koneksi) . "</div>");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Guru Mengajar - Siakad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Daftar Guru Mengajar</h1>
            <div>
                <a href="form_tambah_mengajar.php" class="btn btn-primary fw-bold">➕ Tambah Mengajar</a>
                <a href="dashboard.php" class="btn btn-secondary fw-bold">Dashboard</a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Nama Guru</th>
                            <th width="15%">Kelas</th>
                            <th width="30%">Nama Mata Pelajaran</th>
                            <th width="15%">Kode Mapel</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($query) > 0) {
                            while ($data = mysqli_fetch_assoc($query)) {
                                $guru = !empty($data['nama_guru']) ? htmlspecialchars($data['nama_guru']) : '<span class="text-danger">Tidak ada guru</span>';
                                $kode = !empty($data['kode_mapel']) ? htmlspecialchars($data['kode_mapel']) : '-';
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td><?php echo $guru; ?></td>
                            <td class="text-center fw-bold"><?php echo htmlspecialchars($data['kelas']); ?></td>
                            <td><?php echo htmlspecialchars($data['nama_mapel']); ?></td>
                            <td class="text-center"><span class="badge bg-secondary"><?php echo $kode; ?></span></td>
                            <td class="text-center">
                                <a href="aksi_hapus_mengajar_batch.php?mapel_id=<?php echo $data['mapel_id']; ?>&kelas=<?php echo urlencode($data['kelas']); ?>" 
                                   class="btn btn-sm btn-danger fw-bold" 
                                   onclick="return confirm('Yakin ingin menghapus plotting untuk kelas ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center text-muted py-4'>Belum ada data mengajar yang ditambahkan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
