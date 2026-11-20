<?php
include "koneksi.php";
include "navadmin.php";

$data = []; 

// Query untuk mengambil data dari tabel 'mapel'
// Menggunakan LEFT JOIN ke tabel 'guru' agar bisa menampilkan nama guru
$sql = "SELECT mapel.*, guru.nama AS nama_guru 
        FROM mapel 
        LEFT JOIN guru ON mapel.guru_id = guru.id 
        ORDER BY mapel.id ASC;";

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
    <meta charset="UTF-8">
    <title>Daftar Mata Pelajaran - pripayer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styls.css">
</head>
<body>
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Daftar Mata Pelajaran</h1>
            <div class="d-flex gap-2">
                <button id="btnSwitch" class="btn btn-success">Switch</button>
            </div>
        </div>

        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th class="kolom-hide">No</th>
                    <th class="kolom-hide">Kode Mapel</th>
                    <th>Nama Mata Pelajaran</th>
                    <th>Guru Pengampu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($data)) {
                    $no = 1;
                    foreach ($data as $mapel) {
                ?>
                <tr>
                    <td class="kolom-hide"><?php echo $no++; ?></td>
                    <td class="kolom-hide"><?php echo htmlspecialchars($mapel['kode_mapel']); ?></td>
                    <td><?php echo htmlspecialchars($mapel['nama_mapel']); ?></td>
                    <td><?php echo !empty($mapel['nama_guru']) ? htmlspecialchars($mapel['nama_guru']) : 'Guru ID: ' . htmlspecialchars($mapel['guru_id']); ?></td>
                    <td>
                        <a href="formedit_mapel.php?id=<?php echo $mapel['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="hapus_mapel.php?id=<?php echo $mapel['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus data mata pelajaran ini?')">Hapus</a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                ?>
                <tr>
                    <td colspan="5" class="text-center">Belum ada data mata pelajaran.</td>
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