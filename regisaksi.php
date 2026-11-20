<?php
require_once 'koneksi.php';

if (isset($_POST['kirim'])) {

    $username = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql_users = "INSERT INTO users 
    (username, password, role, created_at) 
    VALUES 
    ('$username', '$pass', '$role', NOW())";

    $query_users = mysqli_query($koneksi, $sql_users);

    if (!$query_users) {
        die("Gagal simpan ke users: " . mysqli_error($koneksi));
    }

    $user_id = mysqli_insert_id($koneksi);

    if ($role == "siswa") {

        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $jenis_kelamin = $_POST['jenis_kelamin'];

        $sql_siswa = "INSERT INTO siswa 
        (nis, nama, kelas, jenis_kelamin, user_id) 
        VALUES 
        ('$nis', '$nama', '$kelas', '$jenis_kelamin', '$user_id')";

        $query_siswa = mysqli_query($koneksi, $sql_siswa);

        if (!$query_siswa) {
            die("Gagal simpan ke siswa: " . mysqli_error($koneksi));
        }

    } elseif ($role == "guru") {

        $nip = $_POST['nip'];
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];

        $sql_guru = "INSERT INTO guru 
        (nip, nama, jenis_kelamin, user_id) 
        VALUES 
        ('$nip', '$nama', '$jenis_kelamin', '$user_id')";

        $query_guru = mysqli_query($koneksi, $sql_guru);

        if (!$query_guru) {
            die("Gagal simpan ke guru: " . mysqli_error($koneksi));
        }

    } elseif ($role == "admin") {

    }

    echo "<script>
        alert('Data berhasil disimpan!');
        window.location.href='formlogin.php';
    </script>";
}
?>