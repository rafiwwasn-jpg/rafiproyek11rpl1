<?php 
require "navsiswa.php"; 
require_once "koneksi.php"; // Panggil koneksi database

// Logika pemrosesan data ketika tombol submit ditekan
if(isset($_POST['kirim'])){
    $kode_mapel = $_POST['kode_mapel'];
    $nama_mapel = $_POST['nama_mapel'];
    $guru_id = $_POST['guru_id'];

    // Query untuk memasukkan ke tabel mapel
    $sql = "INSERT INTO mapel (kode_mapel, nama_mapel, guru_id) VALUES ('$kode_mapel', '$nama_mapel', '$guru_id')";
    $query = mysqli_query($koneksi, $sql);

    if($query){
        // Jika berhasil, langsung pindah ke halaman tabel mapel
        echo "<script>alert('Data Mata Pelajaran berhasil ditambahkan!'); window.location.href='tabelmapel.php';</script>";
        exit;
    } else {
        // Jika gagal, munculkan pesan error
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($koneksi) . "');</script>";
    }
}

// Ambil semua data dari tabel guru untuk opsi dropdown di form
$sql_guru = "SELECT id, nama FROM guru ORDER BY nama ASC";
$query_guru = mysqli_query($koneksi, $sql_guru);
?>
    
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body p-4">
          
          <h2 class="text-center mb-4">Tambah Mata Pelajaran</h2>
          <hr class="mb-4">
          
          <form action="" method="POST">
            
            <div class="mb-3 text-start">
              <label class="form-label text-muted">Kode Mata Pelajaran</label>
              <input type="text" name="kode_mapel" class="form-control form-control-lg" placeholder="Contoh: 10" required>
            </div>
            
            <div class="mb-3 text-start">
              <label class="form-label text-muted">Nama Mata Pelajaran</label>
              <input type="text" name="nama_mapel" class="form-control form-control-lg" placeholder="Contoh: PIPAS" required>
            </div>

            <div class="mb-4 text-start">
              <label class="form-label text-muted">Guru Pengampu</label>
              <select name="guru_id" class="form-select form-select-lg" required>
                  <option value="" selected disabled>-- Pilih Guru --</option>
                  <?php 
                  // Menampilkan daftar guru ke dalam dropdown
                  while ($guru = mysqli_fetch_assoc($query_guru)) { 
                      echo "<option value='{$guru['id']}'>{$guru['nama']}</option>";
                  } 
                  ?>
              </select>
            </div>
            
            <button type="submit" name="kirim" class="btn btn-primary btn-lg w-100">Simpan Data</button>
            <a href="tabelmapel.php" class="btn btn-secondary btn-lg w-100 mt-2">Batal</a>
          </form>
          
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "footersiswa.php" ?>
