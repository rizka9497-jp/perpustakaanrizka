<?php
include "../koneksi.php";
session_start();

if (!isset($_SESSION['idadmin'])) {
    echo "<script>alert('Sesi admin tidak ditemukan. Silakan login kembali.'); window.location='../login.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idpeminjam = $_POST['idpeminjam'];
    $idbuku = $_POST['idbuku'];
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime('+6 days', strtotime($tanggal_pinjam)));
    $status = 'Dipinjam';

    // Validasi stok buku
    $cek_stok = mysqli_query($koneksi, "SELECT stok FROM buku WHERE idbuku='$idbuku'");
    $stok_data = mysqli_fetch_assoc($cek_stok);
    if ($stok_data['stok'] <= 0) {
        echo "<script>alert('Stok buku habis! Tidak bisa dipinjam.'); window.location='../index.php?halaman=tambahpeminjaman';</script>";
        exit;
    }

    // Simpan ke tabel peminjaman
    $query_peminjaman = "INSERT INTO peminjaman (idpeminjam, idadmin, tanggalpinjam, tanggalharuskembali, status) 
                         VALUES ('$idpeminjam', '{$_SESSION['idadmin']}', '$tanggal_pinjam', '$tanggal_kembali', '$status')";
    mysqli_query($koneksi, $query_peminjaman);

    // Ambil ID peminjaman terakhir
    $idpeminjaman = mysqli_insert_id($koneksi);

    // Simpan ke tabel detailpeminjaman (denda default = 0)
    $query_detail = "INSERT INTO detailpeminjaman (idpeminjaman, idbuku, denda) 
                     VALUES ('$idpeminjaman', '$idbuku', 0)";
    mysqli_query($koneksi, $query_detail);

    // Kurangi stok buku
    mysqli_query($koneksi, "UPDATE buku SET stok = stok - 1 WHERE idbuku = '$idbuku'");

    echo "<script>
        alert('Peminjaman berhasil disimpan!');
        window.location='../index.php?halaman=daftarpeminjaman';
    </script>";
} else {
    echo "<script>alert('Akses tidak valid!'); window.location='../index.php?halaman=daftarpeminjaman';</script>";
}
?>
