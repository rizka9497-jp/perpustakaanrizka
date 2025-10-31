<?php
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';
include "../koneksi.php";
session_start();

// Folder penyimpanan foto
$folderFoto = "../foto/fotobuku/";

// ==================================================================================
// PROSES TAMBAH BUKU
// ==================================================================================
if ($proses == 'tambah') {

    // Ambil data dari form
    $judul        = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang    = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $tahun_terbit = mysqli_real_escape_string($koneksi, $_POST['tahun_terbit']);
    $stok         = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $idkategori   = mysqli_real_escape_string($koneksi, $_POST['idkategori']);
    $idrak        = mysqli_real_escape_string($koneksi, $_POST['idrak']);

    // Upload Foto Buku
    $foto     = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';
    $tmp_foto = isset($_FILES['foto']['tmp_name']) ? $_FILES['foto']['tmp_name'] : '';
    $namafilebaru = '';

    if (!empty($foto)) {
        $namafilebaru = date('YmdHis') . '_' . basename($foto);
        $tujuan = $folderFoto . $namafilebaru;

        if (!file_exists($folderFoto)) {
            mkdir($folderFoto, 0777, true);
        }

        move_uploaded_file($tmp_foto, $tujuan);
    }

    // Simpan ke database
    $query = "INSERT INTO buku (
                judul,
                pengarang,
                tahun_terbit,
                stok,
                idkategori,
                idrak,
                foto
              ) VALUES (
                '$judul',
                '$pengarang',
                '$tahun_terbit',
                '$stok',
                '$idkategori',
                '$idrak',
                '$namafilebaru'
              )";

    mysqli_query($koneksi, $query) or die("Gagal menambah buku: " . mysqli_error($koneksi));


// ==================================================================================
// PROSES EDIT BUKU
// ==================================================================================
} elseif ($proses == 'edit') {

    $idbuku       = mysqli_real_escape_string($koneksi, $_POST['idbuku']);
    $judul        = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang    = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $tahun_terbit = mysqli_real_escape_string($koneksi, $_POST['tahun_terbit']);
    $stok         = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $idkategori   = mysqli_real_escape_string($koneksi, $_POST['idkategori']);
    $idrak        = mysqli_real_escape_string($koneksi, $_POST['idrak']);

    $foto     = isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : '';
    $tmp_foto = isset($_FILES['foto']['tmp_name']) ? $_FILES['foto']['tmp_name'] : '';

    // Ambil data lama
    $queryShow  = mysqli_query($koneksi, "SELECT foto FROM buku WHERE idbuku='$idbuku'");
    $result     = mysqli_fetch_assoc($queryShow);
    $namafilebaru = isset($result['foto']) ? $result['foto'] : ''; // default: gunakan foto lama (jika ada)

    if (!empty($foto)) {
        $namafilebaru = date('YmdHis') . '_' . basename($foto);
        $tujuan = $folderFoto . $namafilebaru;

        if (!file_exists($folderFoto)) {
            mkdir($folderFoto, 0777, true);
        }

        // Hapus foto lama jika ada
        if (!empty($result['foto']) && file_exists($folderFoto . $result['foto'])) {
            unlink($folderFoto . $result['foto']);
        }

        move_uploaded_file($tmp_foto, $tujuan);
    }

    // Update data buku
    $query = "UPDATE buku SET 
                judul='$judul',
                pengarang='$pengarang',
                tahun_terbit='$tahun_terbit',
                stok='$stok',
                idkategori='$idkategori',
                idrak='$idrak',
                foto='$namafilebaru'
              WHERE idbuku='$idbuku'";

    mysqli_query($koneksi, $query) or die("Gagal mengedit buku: " . mysqli_error($koneksi));


// ==================================================================================
// PROSES HAPUS BUKU
// ==================================================================================
} elseif ($proses == 'hapus') {

    $idbuku = isset($_GET['idbuku']) ? mysqli_real_escape_string($koneksi, $_GET['idbuku']) : '';

    if ($idbuku == '') {
        echo "<script>
                alert('ID buku tidak ditemukan.');
                window.location='../index.php?halaman=buku';
              </script>";
        exit;
    }

    // Cek apakah buku digunakan di tabel detailpeminjaman
    $cekRelasi = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM detailpeminjaman WHERE idbuku='$idbuku'");
    $relasi = mysqli_fetch_assoc($cekRelasi);

    if ($relasi['jml'] > 0) {
        echo "<script>
                alert('Buku tidak dapat dihapus karena masih digunakan di data peminjaman.');
                window.location='../index.php?halaman=buku';
              </script>";
        exit;
    }

    // Hapus foto lama
    $queryShow  = mysqli_query($koneksi, "SELECT foto FROM buku WHERE idbuku='$idbuku'");
    $result     = mysqli_fetch_assoc($queryShow);

    if (!empty($result['foto']) && file_exists($folderFoto . $result['foto'])) {
        unlink($folderFoto . $result['foto']);
    }

    // Hapus data buku
    mysqli_query($koneksi, "DELETE FROM buku WHERE idbuku='$idbuku'")
        or die("Gagal menghapus buku: " . mysqli_error($koneksi));
}

// ==================================================================================
// Redirect ke halaman utama buku
// ==================================================================================
header("Location: ../index.php?halaman=buku");
exit;
?>
