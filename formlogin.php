<?php 
session_start(); // Wajib ada untuk memulai memori login
require "navlogin.php"; 
require_once "koneksi.php"; 

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cari user berdasarkan username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $query = mysqli_query($koneksi, $sql);

    // Cek apakah username ada di database
    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_assoc($query);
        
        // Pengecekan password (teks biasa sesuai permintaan sebelumnya)
        if($password == $data['password']){
            
            // Simpan data role dan username ke session
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];
            
            // Pengecekan role untuk menentukan arah halaman (redirect)
            if($data['role'] == 'guru'){
                // Jika guru, arahkan ke tabel_guru.php
                echo "<script>alert('Login berhasil sebagai GURU!'); window.location.href='tabel_guru.php';</script>";
            } elseif($data['role'] == 'admin') {
                // Jika admin, arahkan ke tabel_admin.php
                echo "<script>alert('Login berhasil sebagai ADMIN!'); window.location.href='tabel_admin.php';</script>";
            } else {
                // Jika selain guru dan admin (misal siswa), arahkan ke Usersss.php
                echo "<script>alert('Login berhasil sebagai " . strtoupper($data['role']) . "!'); window.location.href='Usersss.php';</script>";
            }
            exit;
            
        } else {
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        echo "<script>alert('Username tidak terdaftar!');</script>";
    }
}
?>
    
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          
          <h2 class="text-center mb-4">Login</h2>
          <hr class="mb-4">
          
          <form action="" method="POST">
            
            <div class="mb-3 text-start">
              <input type="text" name="username" class="form-control form-control-lg" placeholder="Username / Email" required>
            </div>
            
            <div class="mb-4 text-start">
              <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
            </div>
            
            <!-- Tombol Login -->
            <button type="submit" name="login" class="btn btn-primary btn-lg w-100 mb-2">Login System</button>
            
            <!-- Tombol Registrasi -->
            <a href="regis.php" class="btn btn-outline-secondary btn-lg w-100">Registrasi</a>
            
          </form>
          
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "footersiswa.php" ?>
