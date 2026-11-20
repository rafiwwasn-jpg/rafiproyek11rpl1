<?php 
require "koneksi.php";
require "navadmin.php";

$id = $_GET['id'];

$sql = "SELECT users.*, siswa.nis, siswa.kelas, guru.nip, 
        COALESCE(siswa.nama, guru.nama) AS nama, 
        COALESCE(siswa.jenis_kelamin, guru.jenis_kelamin) AS jenis_kelamin 
        FROM users 
        LEFT JOIN siswa ON users.id = siswa.user_id 
        LEFT JOIN guru ON users.id = guru.user_id 
        WHERE users.id = '$id'";

$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);
?>

<div class="container">
    <div class="container text-center mt-4">
        <div class="row align-items-center">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Edit Data Pengguna</h1>
                    </div>
                    <div class="card-body">
                        
                        <form action="prosesedit.php" method="POST">
                            
                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                            <input type="hidden" name="role" value="<?php echo $data['role']; ?>">

                            <h5 class="text-start">Role:</h5>
                            <div class="form-check text-start">
                                <input class="form-check-input" type="radio" value="siswa" <?php if($data['role']=='siswa') echo 'checked'; ?> disabled>
                                <label class="form-check-label">Siswa</label>
                            </div>
                            <div class="form-check text-start">
                                <input class="form-check-input" type="radio" value="guru" <?php if($data['role']=='guru') echo 'checked'; ?> disabled>
                                <label class="form-check-label">Guru</label>
                            </div>
                            <div class="form-check text-start mb-4">
                                <input class="form-check-input" type="radio" value="admin" <?php if($data['role']=='admin') echo 'checked'; ?> disabled>
                                <label class="form-check-label">Admin</label>
                            </div>

                            <div style="display:<?php echo ($data['role'] == 'siswa') ? 'block' : 'none'; ?>;">
                                <h1>Data Profil Siswa</h1>
                                <hr>
                                <input class="form-control mb-3" type="text" name="nis" placeholder="Nomor Induk" value="<?php echo $data['nis']; ?>">
                                <input class="form-control mb-3" type="text" name="kelas" placeholder="Kelas Siswa" value="<?php echo $data['kelas']; ?>">
                            </div>

                            <div style="display:<?php echo ($data['role'] == 'guru') ? 'block' : 'none'; ?>;">
                                <h1>Data Profil Guru</h1>
                                <hr>
                                <input class="form-control mb-3" type="text" name="nip" placeholder="Nomor Induk Pegawai" value="<?php echo $data['nip']; ?>">
                            </div>

                            <div style="display:<?php echo ($data['role'] != 'admin') ? 'block' : 'none'; ?>;">
                                <input class="form-control mb-3" type="text" name="nama" placeholder="Nama" value="<?php echo $data['nama']; ?>">
                                
                                <h5 class="text-start mt-3">Jenis Kelamin:</h5>
                                <div class="form-check text-start">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" <?php if($data['jenis_kelamin']=='L') echo 'checked'; ?>>
                                    <label class="form-check-label">Laki-Laki</label>
                                </div>
                                <div class="form-check text-start mb-4">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" <?php if($data['jenis_kelamin']=='P') echo 'checked'; ?>>
                                    <label class="form-check-label">Perempuan</label>
                                </div>
                            </div>

                            <h1>Data Kredensial Akun</h1>
                            <hr>
                            <div class="mb-3 text-start">
                                <input type="text" name="username" class="form-control" placeholder="Username / Email" value="<?php echo $data['username']; ?>" required>
                            </div>
                            <div class="mb-3 text-start">
                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika password tidak diubah">
                            </div>

                            <button type="submit" name="kirim" class="btn btn-primary w-100 mt-3">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>

<?php require "footersiswa.php" ?>
