<?php
session_start();

// Validasi hanya siswa yang login yang bisa mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'siswa') {
    echo "<script>alert('Akses khusus Siswa!'); window.location.href='formlogin.php';</script>";
    exit;
}

require_once 'koneksi.php';
require "navsiswa.php"; 

$username_aktif = $_SESSION['username'];

// Ambil data user dan siswa berdasarkan username yang sedang login
$sql = "SELECT users.id, users.username, siswa.nis, siswa.nama, siswa.kelas, siswa.jenis_kelamin 
        FROM users 
        JOIN siswa ON users.id = siswa.user_id 
        WHERE users.username = '$username_aktif'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);

// ==========================================
// LOGIKA MEMBUAT INISIAL UNTUK FOTO PROFIL
// ==========================================
$nama_lengkap = $data['nama'] ?? 'Siswa';
$pecah_nama = explode(' ', trim($nama_lengkap));
$inisial = '';

// Ambil huruf pertama dari kata pertama
if (isset($pecah_nama[0]) && !empty($pecah_nama[0])) {
    $inisial .= strtoupper(substr($pecah_nama[0], 0, 1));
}
// Ambil huruf pertama dari kata kedua (jika namanya lebih dari 1 kata)
if (isset($pecah_nama[1]) && !empty($pecah_nama[1])) {
    $inisial .= strtoupper(substr($pecah_nama[1], 0, 1));
}
// Jika inisial masih kosong, default 'S'
if (empty($inisial)) {
    $inisial = 'S'; 
}
?>

<div class="container mb-5">
    <div class="container text-center mt-4">
        <div class="row align-items-center">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h2 class="m-0">Edit Profil Siswa</h2>
                    </div>
                    <div class="card-body p-4">
                        
                        <!-- ========================================== -->
                        <!-- TAMPILAN FOTO PROFIL (INISIAL NAMA)        -->
                        <!-- ========================================== -->
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto shadow" 
                                 style="width: 120px; height: 120px; font-size: 50px; font-weight: bold; letter-spacing: 2px;">
                                <?php echo $inisial; ?>
                            </div>
                            <p class="text-muted mt-2 mb-0 fw-bold"><small>Foto Profil (Bawaan Sistem)</small></p>
                        </div>

                        <!-- Form action diubah mengarah ke aksi_edit_siswa.php -->
                        <form action="aksi_edit_siswa.php" method="POST">
                            
                            <!-- Hidden ID -->
                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                            <h4 class="text-start text-primary border-bottom pb-2 mb-3">Data Profil Siswa</h4>
                            
                            <div class="mb-3 text-start">
                                <label class="form-label fw-bold">NIS (Nomor Induk Siswa)</label>
                                <input class="form-control" type="text" name="nis" value="<?php echo htmlspecialchars($data['nis']); ?>" required>
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input class="form-control" type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label fw-bold">Kelas</label>
                                <input class="form-control" type="text" name="kelas" value="<?php echo htmlspecialchars($data['kelas']); ?>" required>
                            </div>

                            <div class="mb-4 text-start">
                                <label class="form-label fw-bold d-block">Jenis Kelamin:</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" id="radioL" <?php if($data['jenis_kelamin'] == 'L') echo 'checked'; ?> required>
                                    <label class="form-check-label" for="radioL">Laki-Laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" id="radioP" <?php if($data['jenis_kelamin'] == 'P') echo 'checked'; ?> required>
                                    <label class="form-check-label" for="radioP">Perempuan</label>
                                </div>
                            </div>

                            <h4 class="text-start text-primary border-bottom pb-2 mb-3 mt-4">Data Kredensial Akun</h4>

                            <div class="mb-3 text-start">
                                <label class="form-label fw-bold">Username / Email</label>
                                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($data['username']); ?>" required>
                            </div>

                            <div class="mb-4 text-start">
                                <label class="form-label fw-bold">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                                <small class="text-muted">Hanya diisi jika ingin mengganti password.</small>
                            </div>

                            <button type="submit" name="kirim" class="btn btn-primary btn-lg w-100 mt-2">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>

<?php require "footersiswa.php" ?>
