<?php
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';
include "../koneksi.php";
session_start();

// ==================================================================================
// PROSES TAMBAH PEMINJAM
// ==================================================================================
if ($proses == 'tambah') {
    $namapeminjam = $_POST['namapeminjam'];
    $alamat = $_POST['alamat'];
    $notelpon = $_POST['notelpon'];

    $foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];

    if (!empty($foto)) {
        $namafilebaru = date('YmdHis') . '_' . $foto;
        $tujuan = "../foto/fotopeminjam/" . $namafilebaru;

        if (!file_exists("../foto/fotopeminjam")) {
            mkdir("../foto/fotopeminjam", 0777, true);
        }

        move_uploaded_file($tmp_foto, $tujuan);
    } else {
        $namafilebaru = '';
    }

    mysqli_query($koneksi, "INSERT INTO peminjam SET 
        namapeminjam='$namapeminjam',
        alamat='$alamat',
        notelpon='$notelpon',
        foto='$namafilebaru'
    ");


// ==================================================================================
// PROSES EDIT PEMINJAM
// ==================================================================================
} elseif ($proses == 'edit') {
    $idpeminjam = $_POST['idpeminjam'];
    $namapeminjam = $_POST['namapeminjam'];
    $alamat = $_POST['alamat'];
    $notelpon = $_POST['notelpon'];

    $foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];

    $queryShow = "SELECT foto FROM peminjam WHERE idpeminjam='$idpeminjam'";
    $sqlShow = mysqli_query($koneksi, $queryShow);
    $result = mysqli_fetch_assoc($sqlShow);

    if (!empty($foto)) {
        $namafilebaru = date('YmdHis') . '_' . $foto;
        $tujuan = "../foto/fotopeminjam/" . $namafilebaru;

        if (!file_exists("../foto/fotopeminjam")) {
            mkdir("../foto/fotopeminjam", 0777, true);
        }

        if (!empty($result['foto']) && file_exists("../foto/fotopeminjam/" . $result['foto'])) {
            unlink("../foto/fotopeminjam/" . $result['foto']);
        }

        move_uploaded_file($tmp_foto, $tujuan);
    } else {
        $namafilebaru = $result['foto'];
    }

    mysqli_query($koneksi, "UPDATE peminjam SET 
        namapeminjam='$namapeminjam',
        alamat='$alamat',
        notelpon='$notelpon',
        foto='$namafilebaru'
        WHERE idpeminjam='$idpeminjam'
    ");


// ==================================================================================
// PROSES HAPUS PEMINJAM
// ==================================================================================
} elseif ($proses == 'hapus') {
    $idpeminjam = $_GET['idpeminjam'];

    // Ambil data foto dulu
    $queryShow = "SELECT foto FROM peminjam WHERE idpeminjam='$idpeminjam'";
    $sqlShow = mysqli_query($koneksi, $queryShow);
    $result = mysqli_fetch_assoc($sqlShow);

    // Hapus foto jika ada
    if (!empty($result['foto']) && file_exists("../foto/fotopeminjam/" . $result['foto'])) {
        unlink("../foto/fotopeminjam/" . $result['foto']);
    }

    // Hapus data dari tabel
    mysqli_query($koneksi, "DELETE FROM peminjam WHERE idpeminjam='$idpeminjam'");
}

// Redirect kembali
header("location:../index.php?halaman=peminjam");
exit;
?>
