<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses khusus Admin!'); window.location.href='dashboard.php';</script>";
    exit;
}
require_once "koneksi.php";

// Query HANYA mengambil guru yang BELUM PUNYA MAPEL sama sekali
$sql_guru = "SELECT id, nama FROM guru 
             WHERE id NOT IN (SELECT DISTINCT guru_id FROM mapel WHERE guru_id IS NOT NULL) 
             ORDER BY nama ASC";
$query_guru = mysqli_query($koneksi, $sql_guru);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mapel untuk Guru - Siakad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h3 class="m-0">Form Input Mapel Guru</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="aksi_tambah_mapel_guru.php" method="POST">
                            
                            <!-- Pilih Guru yang Belum Punya Mapel -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Guru (Belum Punya Mapel)</label>
                                <select name="guru_id" class="form-select form-select-lg" required>
                                    <option value="" disabled selected>-- Pilih Guru --</option>
                                    <?php
                                    if ($query_guru && mysqli_num_rows($query_guru) > 0) {
                                        while ($g = mysqli_fetch_assoc($query_guru)) {
                                            echo "<option value='{$g['id']}'>{$g['nama']}</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Semua guru sudah memiliki mapel!</option>";
                                    }
                                    ?>
                                </select>
                                <div class="form-text text-muted">Hanya menampilkan guru yang belum memiliki mata pelajaran.</div>
                            </div>

                            <!-- Nama Mata Pelajaran -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Mata Pelajaran</label>
                                <input type="text" name="nama_mapel" class="form-control form-control-lg" placeholder="Contoh: Pemrograman Web" required>
                            </div>

                            <!-- Kode Mapel -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Kode Mapel</label>
                                <input type="text" name="kode_mapel" class="form-control form-control-lg" placeholder="Contoh: PW-01" required>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" name="simpan" class="btn btn-primary btn-lg w-50 fw-bold">Simpan Mapel</button>
                                <a href="daftar_mengajar.php" class="btn btn-secondary btn-lg w-50 fw-bold text-center text-decoration-none pt-2">Kembali</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
