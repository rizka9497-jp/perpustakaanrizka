<?php
include "../koneksi.php";
session_start();

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses == 'tambah') {
    // Gunakan nama field yang benar sesuai form dan tabel
    $Namarak = mysqli_real_escape_string($koneksi, $_POST['Namarak'] ?? '');

    // Validasi input kosong
    if (empty($Namarak)) {
        die("Error: Nama rak tidak boleh kosong!");
    }

    // Cegah duplikasi nama rak
    $cek = mysqli_query($koneksi, "SELECT * FROM rak WHERE Namarak='$Namarak'");
    if (mysqli_num_rows($cek) > 0) {
        die("Rak dengan nama '$Namarak' sudah ada!");
    }

    // Insert data
    $query = "INSERT INTO rak (Namarak) VALUES ('$Namarak')";
    if (!mysqli_query($koneksi, $query)) {
        die("Gagal menambah rak: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=rak&status=tambah_sukses");
    exit;
}

elseif ($proses == 'edit') {
    $Idrak = mysqli_real_escape_string($koneksi, $_POST['Idrak'] ?? '');
    $Namarak = mysqli_real_escape_string($koneksi, $_POST['Namarak'] ?? '');

    if (empty($Idrak) || empty($Namarak)) {
        die("Error: Data tidak lengkap untuk proses edit!");
    }

    $query = "UPDATE rak SET Namarak='$Namarak' WHERE Idrak='$Idrak'";
    if (!mysqli_query($koneksi, $query)) {
        die("Gagal mengedit rak: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=rak&status=edit_sukses");
    exit;
}

elseif ($proses == 'hapus') {
    if (!isset($_GET['Idrak']) || empty($_GET['Idrak'])) {
        die("Error: ID rak tidak ditemukan untuk dihapus.");
    }

    $Idrak = mysqli_real_escape_string($koneksi, $_GET['Idrak']);

    // Cek apakah rak ini masih dipakai di tabel buku
    $cekBuku = mysqli_query($koneksi, "SELECT * FROM buku WHERE Idrak='$Idrak'");
    if (mysqli_num_rows($cekBuku) > 0) {
        die("Gagal menghapus: Masih ada buku yang menggunakan rak ini!");
    }

    // Jika aman, hapus rak
    $query = "DELETE FROM rak WHERE Idrak='$Idrak'";
    if (!mysqli_query($koneksi, $query)) {
        die("Gagal menghapus rak: " . mysqli_error($koneksi));
    }

    header("Location: ../index.php?halaman=rak&status=hapus_sukses");
    exit;
}

else {
    die("Proses tidak dikenali!");
}
?>
