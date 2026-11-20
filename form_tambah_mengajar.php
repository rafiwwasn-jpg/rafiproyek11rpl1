<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses khusus Admin!'); window.location.href='dashboard.php';</script>";
    exit;
}
require_once "koneksi.php";

// Mengambil daftar kelas unik dari tabel siswa
$sql_kelas = "SELECT DISTINCT kelas FROM siswa WHERE kelas IS NOT NULL AND kelas != '' ORDER BY kelas ASC";
$query_kelas = mysqli_query($koneksi, $sql_kelas);

// Mengambil data BERBASIS TABEL GURU, di-join dengan mapel untuk mendapatkan mapel_id
$sql_guru = "SELECT guru.id AS guru_id, guru.nama AS nama_guru, mapel.id AS mapel_id, mapel.nama_mapel 
             FROM guru 
             LEFT JOIN mapel ON mapel.guru_id = guru.id 
             ORDER BY guru.nama ASC";
$query_guru = mysqli_query($koneksi, $sql_guru);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Tambah Mengajar - Siakad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h3 class="m-0">Form Tambah Mengajar</h3>
                    </div>
                    <div class="card-body p-4">
                        <form action="aksi_tambah_mengajar_batch.php" method="POST">
                            
                            <!-- Pilih Kelas -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih Kelas</label>
                                <select name="kelas" class="form-select form-select-lg" required>
                                    <option value="" disabled selected>Pilih Kelas...</option>
                                    <?php
                                    if ($query_kelas && mysqli_num_rows($query_kelas) > 0) {
                                        while ($k = mysqli_fetch_assoc($query_kelas)) {
                                            echo "<option value='{$k['kelas']}'>{$k['kelas']}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Pilih Guru (Bersumber dari tabel guru) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih Guru</label>
                                <select name="mapel_id" class="form-select form-select-lg" required>
                                    <option value="" disabled selected>Pilih Guru...</option>
                                    <?php
                                    if ($query_guru && mysqli_num_rows($query_guru) > 0) {
                                        while ($g = mysqli_fetch_assoc($query_guru)) {
                                            $nama_guru = !empty($g['nama_guru']) ? htmlspecialchars($g['nama_guru']) : 'Tanpa Nama';
                                            $nama_mapel = !empty($g['nama_mapel']) ? htmlspecialchars($g['nama_mapel']) : 'Belum ada Mapel';
                                            
                                            // Nilai (value) yang dikirim tetap mapel_id agar tabel database 'mengajar' tidak error,
                                            // tapi tampilannya berbasis nama Guru terlebih dahulu.
                                            echo "<option value='{$g['mapel_id']}'>{$nama_guru} — ({$nama_mapel})</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" name="simpan" class="btn btn-primary btn-lg w-50 fw-bold">Simpan Data</button>
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
