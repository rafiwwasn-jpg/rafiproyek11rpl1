<?php
session_start(); // Wajib di paling atas untuk membaca sesi login

// Cek apakah user sudah login, kalau belum lempar kembali ke form login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='formlogin.php';</script>";
    exit;
}

include "koneksi.php";
include "navadmin.php";

$data = []; 
$username_aktif = $_SESSION['username'];
$role_aktif = $_SESSION['role'];

// Membedakan Query berdasarkan Role
if ($role_aktif == 'siswa') {
    // Jika siswa, HANYA tampilkan data miliknya sendiri
    $sql = "SELECT users.*, 
            COALESCE(siswa.nama, guru.nama) AS nama
            FROM users
            LEFT JOIN siswa ON users.id = siswa.user_id
            LEFT JOIN guru ON users.id = guru.user_id
            WHERE users.username = '$username_aktif'
            ORDER BY users.id DESC;";
} else {
    // Jika guru atau admin, tampilkan SEMUA data
    $sql = "SELECT users.*, 
            COALESCE(siswa.nama, guru.nama) AS nama
            FROM users
            LEFT JOIN siswa ON users.id = siswa.user_id
            LEFT JOIN guru ON users.id = guru.user_id
            ORDER BY users.id DESC;";
}

$hasil = mysqli_query($koneksi, $sql);

if ($hasil && mysqli_num_rows($hasil) > 0) { 
    while($row = mysqli_fetch_assoc($hasil)) {
        $data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Data Users - pripayer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styls.css">
</head>
<body>
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Daftar Users</h1>
            <div class="d-flex gap-2">
                <button id="btnSwitch" class="btn btn-success">Switch</button>
            </div>
        </div>

        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="kolom-hide">No</th>
                    <th>Username</th>
                    <th class="kolom-hide">Password</th>
                    <th>Role</th>
                    <th>Nama</th>
                    <!-- Sembunyikan kolom action (Edit/Hapus) jika yang login adalah siswa -->
                    <?php if ($role_aktif != 'siswa') { ?>
                    <th>Aksi</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data as $user) {
                ?>
                <tr>
                    <td class="kolom-hide"><?php echo $no++; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td class="kolom-hide"><?php echo $user['password']; ?></td>
                    <td><span class="badge bg-secondary"><?php echo strtoupper($user['role']); ?></span></td>
                    <td><?php echo $user['nama']; ?></td>
                    
                    <!-- Hanya tampilkan tombol aksi jika bukan siswa -->
                    <?php if ($role_aktif != 'siswa') { ?>
                    <td>
                        <a href="formedit.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="aksi_hapus.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus data ini?')">Hapus</a>
                    </td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const btnSwitch = document.getElementById('btnSwitch');
        const kolomHide = document.querySelectorAll('.kolom-hide');
        let isHidden = false;

        btnSwitch.addEventListener('click', () => {
            isHidden = !isHidden;
            kolomHide.forEach(kolom => {
                kolom.classList.toggle('d-none', isHidden);
            });
            
            btnSwitch.classList.toggle('btn-success', !isHidden);
            btnSwitch.classList.toggle('btn-danger', isHidden);
        });
    </script>
</body>
</html>
