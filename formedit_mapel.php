<?php 
require "koneksi.php";
require "navsiswa.php";

$id = $_GET['id'];

// 1. Ambil data mapel yang sedang diedit
$sql_mapel = "SELECT * FROM mapel WHERE id = '$id'";
$query_mapel = mysqli_query($koneksi, $sql_mapel);
$data_mapel = mysqli_fetch_assoc($query_mapel);

// 2. Ambil semua data dari tabel guru untuk opsi dropdown
$sql_guru = "SELECT id, nama FROM guru ORDER BY nama ASC";
$query_guru = mysqli_query($koneksi, $sql_guru);
?>

<div class="container">
    <div class="container text-center mt-4">
        <div class="row align-items-center">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Edit Data Mata Pelajaran</h1>
                    </div>
                    <div class="card-body">
                        
                        <form action="prosesedit_mapel.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $data_mapel['id']; ?>">

                            <div class="mb-3 text-start">
                                <label class="form-label">Kode Mata Pelajaran</label>
                                <input type="text" name="kode_mapel" class="form-control" value="<?php echo htmlspecialchars($data_mapel['kode_mapel']); ?>" required>
                            </div>
                            
                            <div class="mb-3 text-start">
                                <label class="form-label">Nama Mata Pelajaran</label>
                                <input type="text" name="nama_mapel" class="form-control" value="<?php echo htmlspecialchars($data_mapel['nama_mapel']); ?>" required>
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label">Guru Pengampu</label>
                                <select name="guru_id" class="form-select" required>
                                    <option value="" disabled>-- Pilih Guru --</option>
                                    <?php 
                                    while ($guru = mysqli_fetch_assoc($query_guru)) { 
                                        $selected = ($guru['id'] == $data_mapel['guru_id']) ? 'selected' : '';
                                        echo "<option value='{$guru['id']}' $selected>{$guru['nama']}</option>";
                                    } 
                                    ?>
                                </select>
                            </div>

                            <button type="submit" name="kirim" class="btn btn-primary w-100 mt-3">Simpan Perubahan</button>
                            <a href="tabelmapel.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>

<?php require "footersiswa.php" ?>
