<?php
include "../koneksi.php";
session_start();

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses == 'tambah') {
    $namakategori = mysqli_real_escape_string($koneksi, $_POST['namakategori']);

    // Cegah duplikasi nama kategori
    $cek = mysqli_query($koneksi, "SELECT * FROM kategori WHERE namakategori='$namakategori'");
    if (mysqli_num_rows($cek) > 0) {
        die("Kategori sudah ada!");
    }

    $query = "INSERT INTO kategori (namakategori) VALUES ('$namakategori')";
    if (!mysqli_query($koneksi, $query)) {
        die("Gagal menambah kategori: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=kategori&status=tambah_sukses");
    exit;
}


elseif ($proses == 'edit') {
    $namalama = mysqli_real_escape_string($koneksi, $_POST['namalama']);
    $namabaru = mysqli_real_escape_string($koneksi, $_POST['namakategori']);

    $query = "UPDATE kategori SET namakategori='$namabaru' WHERE namakategori='$namalama'";
    if (!mysqli_query($koneksi, $query)) {
        die("Gagal mengedit kategori: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=kategori&status=edit_sukses");
    exit;
}


elseif ($proses == 'hapus') {
    if (!isset($_GET['namakategori']) || empty($_GET['namakategori'])) {
        die("Error: Nama kategori tidak ditemukan untuk dihapus.");
    }

    $namakategori = mysqli_real_escape_string($koneksi, $_GET['namakategori']);

    // Ambil idkategori berdasarkan nama kategori
    $getKategori = mysqli_query($koneksi, "SELECT idkategori FROM kategori WHERE namakategori='$namakategori'");
    $dataKategori = mysqli_fetch_assoc($getKategori);
    $idkategori = $dataKategori['idkategori'];

    // Cek apakah kategori ini masih dipakai di tabel buku
    $cekBuku = mysqli_query($koneksi, "SELECT * FROM buku WHERE idkategori='$idkategori'");
    if (mysqli_num_rows($cekBuku) > 0) {
        die("Gagal menghapus: Masih ada buku yang menggunakan kategori ini!");
    }

    // Jika aman, hapus kategori
    $query = "DELETE FROM kategori WHERE idkategori='$idkategori'";
    if (!mysqli_query($koneksi, $query)) {
        die("Gagal menghapus kategori: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=kategori&status=hapus_sukses");
    exit;
}
