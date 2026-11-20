<?php
// Cek status session agar tidak error jika session sudah dimulai sebelumnya
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mengambil username dari session (bukan nama profil)
$username_aktif = $_SESSION['username'] ?? 'Admin';
$role_aktif = $_SESSION['role'] ?? 'Admin';
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
    
    <!-- Informasi Login di Ujung Kiri (Menampilkan USERNAME asli dan ROLE) -->
    <span class="navbar-brand text-dark fs-6">
      👤 Login: <strong><?php echo htmlspecialchars($username_aktif); ?></strong> 
      <span class="badge bg-warning text-dark ms-1"><?php echo strtoupper(htmlspecialchars($role_aktif)); ?></span>
    </span>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <!-- Dropdown Tambah User -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Edit Profile
          </a>
          <!-- Isi Dropdown Disisakan 1 Saja -->
          <ul class="dropdown-menu custom-dropdown">
            <li><a class="dropdown-item fw-bold text-primary" href="formsemuanyah.php">Tambah User</a></li>
            <li><a class="dropdown-item fw-bold text-primary" href="form_edit_admin.php">Edit Profile</a></li>
            <li><a class="dropdown-item fw-bold text-success" href="tabelmapel.php">Mapel</a></li>
            <li><a class="dropdown-item fw-bold text-success" href="form_tambah_mengajar.php">Tambah Mengajar</a></li>
            <li><a class="dropdown-item fw-bold text-success" href="daftar_mengajar.php">Daftar Mengajar</a></li>
            <li><a class="dropdown-item fw-bold text-success" href="form_tambah_mapel_guru.php">Masukan Mapel</a></li>
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
