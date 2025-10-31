<?php
include 'koneksi.php'; // koneksi ke database

// Ambil data dari form
$idpeminjam   = $_POST['idpeminjam'];
$idadmin      = $_POST['idadmin'];
$idbuku       = $_POST['idbuku'];
$tanggalPinjam = $_POST['tanggal_pinjam'];
$tanggalKembali = $_POST['tanggal_kembali'];

// Validasi stok buku
$cekStok = mysqli_query($koneksi, "SELECT stok FROM buku WHERE idbuku='$idbuku'");
$dataBuku = mysqli_fetch_assoc($cekStok);

if ($dataBuku['stok'] <= 0) {
    echo "<script>alert('Stok buku habis!'); window.location='formpeminjaman.php';</script>";
    exit;
}

// 1. Simpan ke tabel peminjaman
mysqli_query($koneksi, "INSERT INTO peminjaman (idpeminjam, idadmin) VALUES ('$idpeminjam', '$idadmin')");

// Ambil id peminjaman terakhir
$idpeminjaman = mysqli_insert_id($koneksi);

// 2. Simpan ke detailpeminjaman
mysqli_query($koneksi, "
    INSERT INTO detailpeminjaman 
    (idpeminjaman, idbuku, tanggalpinjam, tanggalkembali, durasipeminjaman, jumlahharitelat, status, keterangan)
    VALUES 
    ('$idpeminjaman', '$idbuku', '$tanggalPinjam', '$tanggalKembali', DATEDIFF('$tanggalKembali','$tanggalPinjam'), 0, 'tidakterlambat', 'belumkembali')
");

// 3. Kurangi stok buku
mysqli_query($koneksi, "UPDATE buku SET stok = stok - 1 WHERE idbuku='$idbuku'");

if (mysqli_affected_rows($koneksi) > 0) {
    echo "<script>alert('Peminjaman berhasil disimpan!'); window.location='daftarpeminjaman.php';</script>";
} else {
    echo "<script>alert('Gagal menyimpan data peminjaman!'); history.back();</script>";
}
?>
