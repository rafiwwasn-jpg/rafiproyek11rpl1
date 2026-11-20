<?php
session_start();

// Validasi hanya admin yang login yang bisa mengakses halaman ini
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses khusus Admin!'); window.location.href='formlogin.php';</script>";
    exit;
}

require_once 'koneksi.php';
require "navsiswa.php"; 

$username_aktif = $_SESSION['username'];

// Ambil data user admin berdasarkan username yang sedang login
$sql = "SELECT id, username FROM users WHERE username = '$username_aktif'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);

// ==========================================
// LOGIKA MEMBUAT INISIAL UNTUK FOTO PROFIL
// ==========================================
$nama_lengkap = $data['username'] ?? 'Admin';
$pecah_nama = explode(' ', trim($nama_lengkap));
$inisial = '';

// Ambil huruf pertama dari kata pertama
if (isset($pecah_nama[0]) && !empty($pecah_nama[0])) {
    $inisial .= strtoupper(substr($pecah_nama[0], 0, 1));
}
// Ambil huruf pertama dari kata kedua (jika username/nama lebih dari 1 kata)
if (isset($pecah_nama[1]) && !empty($pecah_nama[1])) {
    $inisial .= strtoupper(substr($pecah_nama[1], 0, 1));
}
// Jika inisial masih kosong, default 'A'
if (empty($inisial)) {
    $inisial = 'A'; 
}
?>

<div class="container mb-5">
    <div class="container text-center mt-4">
        <div class="row align-items-center">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h2 class="m-0">Edit Profil Admin</h2>
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

                        <form action="aksi_edit_admin.php" method="POST">
                            
                            <!-- Hidden ID User -->
                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                            <h4 class="text-start text-primary border-bottom pb-2 mb-3">Data Kredensial Akun Admin</h4>

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
