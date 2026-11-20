<?php require "navadmin.php" ?>

<div class="container">
    <div class="container text-center mt-4">

        <div class="row align-items-center">

            <div class="col-md-2"></div>

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">
                        <h1>Data Pengguna</h1>
                    </div>

                    <div class="card-body">

                        <form action="tambahuser.php" method="POST">

                            <!-- ROLE -->
                            <h5 class="text-start">Role:</h5>

                            <div class="form-check text-start">
                                <input class="form-check-input"
                                       type="radio"
                                       name="role"
                                       value="siswa"
                                       id="roleSiswa"
                                       onchange="ubahRole()"
                                       required>

                                <label class="form-check-label" for="roleSiswa">
                                    Siswa
                                </label>
                            </div>

                            <div class="form-check text-start">
                                <input class="form-check-input"
                                       type="radio"
                                       name="role"
                                       value="guru"
                                       id="roleGuru"
                                       onchange="ubahRole()">

                                <label class="form-check-label" for="roleGuru">
                                    Guru
                                </label>
                            </div>

                            <div class="form-check text-start mb-4">
                                <input class="form-check-input"
                                       type="radio"
                                       name="role"
                                       value="admin"
                                       id="roleAdmin"
                                       onchange="ubahRole()">

                                <label class="form-check-label" for="roleAdmin">
                                    Admin
                                </label>
                            </div>


                            <!-- DATA SISWA -->
                            <div id="dataSiswa" style="display:none;">

                                <h1>Data Profil Siswa</h1>
                                <hr>

                                <input class="form-control mb-3"
                                       type="text"
                                       name="nis"
                                       id="nis"
                                       placeholder="Nomor Induk">

                                <input class="form-control mb-3"
                                       type="text"
                                       name="kelas"
                                       id="kelas"
                                       placeholder="Kelas Siswa">

                            </div>


                            <!-- DATA GURU -->
                            <div id="dataGuru" style="display:none;">

                                <h1>Data Profil Guru</h1>
                                <hr>

                                <input class="form-control mb-3"
                                       type="text"
                                       name="nip"
                                       id="nip"
                                       placeholder="Nomor Induk Pegawai">

                            </div>


                            <!-- NAMA -->
                            <div id="namaDiv" style="display:none;">

                                <input class="form-control mb-3"
                                       type="text"
                                       name="nama"
                                       id="nama"
                                       placeholder="Nama">

                            </div>


                            <!-- JENIS KELAMIN -->
                            <div id="jenisDiv" style="display:none;">

                                <h5 class="text-start">
                                    Jenis Kelamin:
                                </h5>

                                <div class="form-check text-start">

                                    <input class="form-check-input"
                                           type="radio"
                                           name="jenis_kelamin"
                                           value="L"
                                           id="radioL">

                                    <label class="form-check-label"
                                           for="radioL">
                                        Laki-Laki
                                    </label>

                                </div>

                                <div class="form-check text-start mb-4">

                                    <input class="form-check-input"
                                           type="radio"
                                           name="jenis_kelamin"
                                           value="P"
                                           id="radioP">

                                    <label class="form-check-label"
                                           for="radioP">
                                        Perempuan
                                    </label>

                                </div>

                            </div>


                            <!-- DATA KREDENSIAL -->
                            <h1>Data Kredensial Akun</h1>
                            <hr>

                            <div class="mb-3 text-start">

                                <input type="text"
                                       name="username"
                                       class="form-control"
                                       placeholder="Username / Email"
                                       required>

                            </div>

                            <div class="mb-3 text-start">

                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       placeholder="Password"
                                       required>

                            </div>


                            <!-- SUBMIT -->
                            <button type="submit"
                                    name="kirim"
                                    class="btn btn-primary w-100 mt-3">

                                Submit Data

                            </button>

                        </form>

                    </div>
                </div>

            </div>

            <div class="col-md-2"></div>

        </div>

    </div>
</div>


<script>

function ubahRole() {

    let role = document.querySelector(
        'input[name="role"]:checked'
    ).value;

    let dataSiswa = document.getElementById("dataSiswa");
    let dataGuru = document.getElementById("dataGuru");
    let namaDiv = document.getElementById("namaDiv");
    let jenisDiv = document.getElementById("jenisDiv");

    let nis = document.getElementById("nis");
    let kelas = document.getElementById("kelas");
    let nip = document.getElementById("nip");
    let nama = document.getElementById("nama");

    let radioL = document.getElementById("radioL");
    let radioP = document.getElementById("radioP");


    // Sembunyikan semuanya terlebih dahulu

    dataSiswa.style.display = "none";
    dataGuru.style.display = "none";
    namaDiv.style.display = "none";
    jenisDiv.style.display = "none";


    // Hilangkan required

    nis.required = false;
    kelas.required = false;
    nip.required = false;
    nama.required = false;

    radioL.required = false;
    radioP.required = false;


    // =========================
    // SISWA
    // =========================

    if (role === "siswa") {

        dataSiswa.style.display = "block";
        namaDiv.style.display = "block";
        jenisDiv.style.display = "block";

        nis.required = true;
        kelas.required = true;
        nama.required = true;

        radioL.required = true;
        radioP.required = true;
    }


    // =========================
    // GURU
    // =========================

    else if (role === "guru") {

        dataGuru.style.display = "block";
        namaDiv.style.display = "block";
        jenisDiv.style.display = "block";

        nip.required = true;
        nama.required = true;

        radioL.required = true;
        radioP.required = true;
    }


    // =========================
    // ADMIN
    // =========================

    else if (role === "admin") {

        // Admin hanya mengisi
        // username dan password

    }

}

</script>


<?php require "footersiswa.php" ?>