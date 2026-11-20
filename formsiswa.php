<?php require "navsiswa.php" ?>
    
<div class="container">
    <div class="container text-center mt-4">
        <div class="row align-items-center">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Data Profil Siswa</h1>
                    </div>
                    <div class="card-body">
                        
                        <form action="tambahuser.php" method="POST">
                            
                            <input class="form-control mb-3" type="text" name="nis" placeholder="Nomor Induk" required>
                            
                            <!-- Kembali menggunakan name="nama" -->
                            <input class="form-control mb-3" type="text" name="nama" placeholder="Nama" required>
                            
                            <input class="form-control mb-3" type="text" name="kelas" placeholder="Kelas Siswa" required>

                            <h5 class="text-start">Jenis Kelamin:</h5>
                            <div class="form-check text-start">
                                <!-- Kembali menggunakan name="jenis_kelamin" -->
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" id="radioL" required>
                                <label class="form-check-label" for="radioL">Laki-Laki</label>
                            </div>
                            <div class="form-check text-start mb-4">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" id="radioP" required>
                                <label class="form-check-label" for="radioP">Perempuan</label>
                            </div>
                            
                            <h1 style="margin-top: 30px;">Data Kredensial Akun</h1>
                            <hr>
                            
                            <div class="mb-3 text-start">
                                <input type="text" name="username" class="form-control" placeholder="Username / Email" required>
                            </div>
                            <div class="mb-3 text-start">
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <input type="hidden" name="role" value="siswa">
                            
                            <button type="submit" name="kirim" class="btn btn-primary w-100 mt-3">Submit Data</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>

<?php require "footersiswa.php" ?>
