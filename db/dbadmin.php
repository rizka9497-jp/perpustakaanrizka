<?php
include "../koneksi.php";
session_start();

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses == 'tambah') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Upload foto
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if (!empty($foto)) {
        $lokasi = "../foto/" . $foto;
        move_uploaded_file($tmp, $lokasi);
    } else {
        $foto = "default.png"; // jika tidak upload foto
    }

    $query = "INSERT INTO admin (nama, username, password, foto) 
              VALUES ('$nama', '$username', '$password', '$foto')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data admin berhasil ditambahkan!'); window.location='../index.php?halaman=tampiladmin';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data admin: " . mysqli_error($koneksi) . "');</script>";
    }

} elseif ($proses == 'edit') {
    $idadmin = $_POST['idadmin'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if (!empty($foto)) {
        $lokasi = "../foto/" . $foto;
        move_uploaded_file($tmp, $lokasi);
        $query = "UPDATE admin SET nama='$nama', username='$username', password='$password', foto='$foto' WHERE idadmin='$idadmin'";
    } else {
        $query = "UPDATE admin SET nama='$nama', username='$username', password='$password' WHERE idadmin='$idadmin'";
    }

    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "<script>alert('Data admin berhasil diubah!'); window.location='../index.php?halaman=tampiladmin';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data admin: " . mysqli_error($koneksi) . "');</script>";
    }

} elseif ($proses == 'hapus') {
    $idadmin = $_GET['idadmin'];
    $query = "DELETE FROM admin WHERE idadmin='$idadmin'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data admin berhasil dihapus!'); window.location='../index.php?halaman=tampiladmin';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data admin: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>
