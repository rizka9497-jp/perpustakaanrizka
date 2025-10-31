<?php
include "../koneksi.php";
session_start();

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

// Folder penyimpanan foto admin
$folderFoto = "../foto/fotoadmin/";

// Pastikan folder ada
if (!file_exists($folderFoto)) {
    mkdir($folderFoto, 0777, true);
}

// ======================================================================
// PROSES TAMBAH ADMIN
// ======================================================================
if ($proses == 'tambah') {

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Upload foto jika ada
    $foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];
    $namafilebaru = '';

    if (!empty($foto)) {
        $namafilebaru = date('YmdHis') . '_' . basename($foto);
        move_uploaded_file($tmp_foto, $folderFoto . $namafilebaru);
    }

    // Simpan ke database
    $query = "INSERT INTO admin (nama, username, password, foto)
              VALUES ('$nama', '$username', '$password', '$namafilebaru')";

    if (!mysqli_query($koneksi, $query)) {
        die('Gagal menambah admin: ' . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=admin");
    exit;
}

// ======================================================================
// PROSES EDIT ADMIN
// ======================================================================
elseif ($proses == 'edit') {

    $idadmin  = $_POST['idadmin'];
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];

    // Ambil foto lama
    $queryShow = mysqli_query($koneksi, "SELECT foto FROM admin WHERE idadmin='$idadmin'");
    $result = mysqli_fetch_assoc($queryShow);
    $namafilebaru = $result['foto'];

    // Jika upload foto baru
    if (!empty($foto)) {
        $namafilebaru = date('YmdHis') . '_' . basename($foto);
        $tujuan = $folderFoto . $namafilebaru;

        // Hapus foto lama jika ada
        if (!empty($result['foto']) && file_exists($folderFoto . $result['foto'])) {
            unlink($folderFoto . $result['foto']);
        }

        move_uploaded_file($tmp_foto, $tujuan);
    }

    // Update password jika diisi
    if (!empty($password)) {
        $query = "UPDATE admin 
                  SET nama='$nama', username='$username', password='$password', foto='$namafilebaru'
                  WHERE idadmin='$idadmin'";
    } else {
        $query = "UPDATE admin 
                  SET nama='$nama', username='$username', foto='$namafilebaru'
                  WHERE idadmin='$idadmin'";
    }

    if (!mysqli_query($koneksi, $query)) {
        die('Gagal mengedit admin: ' . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=admin");
    exit;
}

// ======================================================================
// PROSES HAPUS ADMIN
// ======================================================================
elseif ($proses == 'hapus') {

    if (!isset($_GET['idadmin']) || empty($_GET['idadmin'])) {
        die("<script>alert('ID admin tidak ditemukan!'); window.location='../index.php?halaman=admin';</script>");
    }

    $idadmin = intval($_GET['idadmin']);

    // Ambil foto lama
    $queryShow = mysqli_query($koneksi, "SELECT foto FROM admin WHERE idadmin='$idadmin'");
    $result = mysqli_fetch_assoc($queryShow);

    // Hapus file foto jika ada
    if (!empty($result['foto']) && file_exists($folderFoto . $result['foto'])) {
        unlink($folderFoto . $result['foto']);
    }

    // Hapus data admin
    mysqli_query($koneksi, "DELETE FROM admin WHERE idadmin='$idadmin'")
        or die("Gagal menghapus admin: " . mysqli_error($koneksi));

    header("Location: ../index.php?halaman=admin");
    exit;
}

// ======================================================================
// JIKA PROSES TIDAK DIKENAL
// ======================================================================
else {
    echo "<script>alert('Proses tidak ditemukan!'); window.location='../index.php?halaman=admin';</script>";
    exit;
}
?>
