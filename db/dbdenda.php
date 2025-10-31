<?php
// ======================================================================
// 📄 dbdenda.php - Proses CRUD Data Denda
// Lokasi: D:\laragon\www\rizkaaulia\11pertemuan29\db\dbdenda.php
// ======================================================================

include "../koneksi.php";
session_start();

$proses = isset($_GET['proses']) ? $_GET['proses'] : '';


// ======================================================================
// PROSES TAMBAH DENDA
// ======================================================================
if ($proses == 'tambah') {

    $jumlahdenda = mysqli_real_escape_string($koneksi, $_POST['jumlahdenda']);
    $statuspembayaran = mysqli_real_escape_string($koneksi, $_POST['statuspembayaran']);

    // Simpan ke database
    $query = "INSERT INTO denda (jumlahdenda, statuspembayaran)
              VALUES ('$jumlahdenda', '$statuspembayaran')";

    if (!mysqli_query($koneksi, $query)) {
        die("<script>alert('Gagal menambah denda: " . mysqli_error($koneksi) . "'); 
             window.location='../views/denda/denda.php';</script>");
    }

    echo "<script>
            alert('Data denda berhasil ditambahkan!');
            window.location='../views/denda/denda.php';
          </script>";
    exit;
}


// ======================================================================
// PROSES EDIT DENDA
// ======================================================================
elseif ($proses == 'edit') {

    $iddenda = mysqli_real_escape_string($koneksi, $_POST['iddenda']);
    $jumlahdenda = mysqli_real_escape_string($koneksi, $_POST['jumlahdenda']);
    $statuspembayaran = mysqli_real_escape_string($koneksi, $_POST['statuspembayaran']);

    // Update data
    $query = "UPDATE denda 
              SET jumlahdenda='$jumlahdenda',
                  statuspembayaran='$statuspembayaran'
              WHERE iddenda='$iddenda'";

    if (!mysqli_query($koneksi, $query)) {
        die("<script>alert('Gagal mengedit denda: " . mysqli_error($koneksi) . "'); 
             window.location='../views/denda/denda.php';</script>");
    }

    echo "<script>
            alert('Data denda berhasil diperbarui!');
            window.location='../views/denda/denda.php';
          </script>";
    exit;
}


// ======================================================================
// PROSES HAPUS DENDA
// ======================================================================
elseif ($proses == 'hapus') {

    if (!isset($_GET['iddenda']) || empty($_GET['iddenda'])) {
        die("<script>alert('ID denda tidak ditemukan!'); 
             window.location='../views/denda/denda.php';</script>");
    }

    $iddenda = intval($_GET['iddenda']);

    // Hapus data dari database
    $query = "DELETE FROM denda WHERE iddenda='$iddenda'";

    if (!mysqli_query($koneksi, $query)) {
        die("<script>alert('Gagal menghapus denda: " . mysqli_error($koneksi) . "'); 
             window.location='../views/denda/denda.php';</script>");
    }

    echo "<script>
            alert('Data denda berhasil dihapus!');
            window.location='../views/denda/denda.php';
          </script>";
    exit;
}


// ======================================================================
// PROSES TIDAK DIKENALI
// ======================================================================
else {
    echo "<script>
            alert('Proses tidak dikenali!');
            window.location='../views/denda/denda.php';
          </script>";
    exit;
}
?>
