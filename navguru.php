<?php
// Cek status session agar tidak error jika session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil data session
$username_aktif = $_SESSION['username'] ?? '';
$role_aktif = $_SESSION['role'] ?? 'Guest';
$nama_tampil = $username_aktif; // Default jika nama tidak ditemukan

// Query untuk mengambil Nama Asli dari database (tabel siswa atau guru)
if (isset($koneksi) && !empty($username_aktif)) {
    $sql_nav = "SELECT COALESCE(siswa.nama, guru.nama, users.username) AS nama 
                FROM users 
                LEFT JOIN siswa ON users.id = siswa.user_id 
                LEFT JOIN guru ON users.id = guru.user_id 
                WHERE users.username = '$username_aktif'";
    $query_nav = mysqli_query($koneksi, $sql_nav);
    
    if ($query_nav && mysqli_num_rows($query_nav) > 0) {
        $data_nav = mysqli_fetch_assoc($query_nav);
        if (!empty($data_nav['nama'])) {
            $nama_tampil = $data_nav['nama'];
        }
    }
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pizza Planet System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&display=swap" rel="stylesheet">
  </head>
  <body>
    
<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container-fluid">
    
    <!-- Informasi Login di Ujung Kiri (Menampilkan Nama Asli dan Role) -->
    <span class="navbar-brand text-dark fs-6">
      👤 : <strong><?php echo htmlspecialchars($nama_tampil); ?></strong> 
      <span class="badge bg-warning text-dark ms-1"><?php echo strtoupper(htmlspecialchars($role_aktif)); ?></span>
    </span>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <!-- Dropdown Tambah User (Home dan Link sudah dihapus) -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Edit Profile
          </a>
          <!-- Isi Dropdown Disisakan 1 Saja -->
          <ul class="dropdown-menu custom-dropdown">
            <li><a class="dropdown-item fw-bold text-success" href="form_edit_guru.php">Edit Profile</a></li>
            <li><a href="logout.php" class="btn btn-danger fw-bold ms-lg-3 mt-3 mt-lg-0">Log Out</a></li>
          </ul>
        </li>
        
      </ul>
      
      <!-- Kolom Pencarian -->
      <form class="d-flex" role="search">
        <input class="form-control me-2 bg-dark text-white border-success" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success fw-bold" type="submit">Search</button>
      </form>
      
    </div>
  </div>
</nav>
