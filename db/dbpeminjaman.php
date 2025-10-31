<?php
include "../koneksi.php";
session_start();

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses == 'tambah') {
    // Pastikan admin login
    if (!isset($_SESSION['idadmin'])) {
        echo "<script>alert('Sesi admin tidak ditemukan! Silakan login ulang.'); window.location='../index.php';</script>";
        exit;
    }

    $idpeminjam = $_POST['idpeminjam'];
    $idbuku = $_POST['idbuku'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $idadmin = $_SESSION['idadmin'];

    // Simpan data peminjaman
    $query = "INSERT INTO peminjaman (idpeminjam, idadmin, idbuku, tanggal_pinjam, tanggal_kembali, status, denda)
              VALUES ('$idpeminjam', '$idadmin', '$idbuku', CURRENT_DATE(), '$tanggal_kembali', 'Dipinjam', 0)";

    if (mysqli_query($koneksi, $query)) {
        // Kurangi stok buku
        mysqli_query($koneksi, "UPDATE buku SET stok = stok - 1 WHERE idbuku = '$idbuku'");

        echo "<script>alert('Data peminjaman berhasil ditambahkan!'); window.location='../index.php?halaman=daftarpeminjaman';</script>";
    } else {
        echo "<script>alert('Gagal menambah data: " . mysqli_error($koneksi) . "'); history.back();</script>";
    }
}
?>
