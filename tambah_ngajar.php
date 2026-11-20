<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini khusus Admin.'); window.location.href='usersss.php';</script>";
    exit;
}

require_once "koneksi.php";
require "navadmin.php"; 

$sql_mapel = "SELECT id, nama_mapel FROM mapel ORDER BY nama_mapel ASC";
$query_mapel = mysqli_query($koneksi, $sql_mapel);

$sql_siswa = "SELECT id, nis, nama FROM siswa ORDER BY nama ASC";
$query_siswa = mysqli_query($koneksi, $sql_siswa);
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="m-0">Form Plotting Mengajar</h3>
                </div>
                <div class="card-body p-4">
                    
                    <p class="text-muted text-center mb-4">
                        Silakan hubungkan Mata Pelajaran dengan Siswa yang mengikutinya.
                    </p>
                    
                    <!-- Form dikirim ke aksi_tambah_mengajar.php -->
                    <form action="aksi_tambah_mengajar.php" method="POST">
                        
                        <div class="mb-4 text-start">
                            <label class="form-label fw-bold">Pilih Mata Pelajaran</label>
                            <select name="mapel_id" class="form-select form-select-lg" required>
                                <option value="" disabled selected>-- Klik untuk memilih Mapel --</option>
                                <?php
                                if (mysqli_num_rows($query_mapel) > 0) {
                                    while ($mapel = mysqli_fetch_assoc($query_mapel)) {
                                        echo "<option value='{$mapel['id']}'>{$mapel['nama_mapel']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>Data Mapel kosong!</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="mb-5 text-start">
                            <label class="form-label fw-bold">Pilih Siswa</label>
                            <select name="siswa_id" class="form-select form-select-lg" required>
                                <option value="" disabled selected>-- Klik untuk memilih Siswa --</option>
                                <?php
                                if (mysqli_num_rows($query_siswa) > 0) {
                                    while ($siswa = mysqli_fetch_assoc($query_siswa)) {
                                        $nis = !empty($siswa['nis']) ? $siswa['nis'] : 'Tanpa NIS';
                                        echo "<option value='{$siswa['id']}'>{$nis} - {$siswa['nama']}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>Data Siswa kosong!</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button onclick="history.back()" type="button" class="btn btn-secondary btn-lg w-50">Batal</button>
                            <button type="submit" name="kirim" class="btn btn-primary btn-lg w-50">Simpan Data</button>
                        </div>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "footersiswa.php" ?>
