<?php
include "../koneksi.php";
// tanpa session
$proses = isset($_GET['proses']) ? $_GET['proses'] : '';

if ($proses == 'tambah') {

    // admin default sementara (bisa disesuaikan)
    $idadmin = 6;

    // ambil data dari form
    $idpeminjam = $_POST['idpeminjam'];
    $idbuku_arr = $_POST['idbuku'];
    $jumlah_arr = $_POST['jumlah'];
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime($tanggal_pinjam . ' +6 days'));
    $denda = 0;

    // simpan ke tabel peminjaman utama
    $query_peminjaman = "
        INSERT INTO peminjaman (idpeminjam, idadmin, idbuku, tanggal_pinjam, tanggal_kembali, status, denda)
        VALUES ('$idpeminjam', '$idadmin', 0, '$tanggal_pinjam', '$tanggal_kembali', 'Dipinjam', '$denda')
    ";

    if (mysqli_query($koneksi, $query_peminjaman)) {
        $idpeminjaman = mysqli_insert_id($koneksi);

        // simpan ke tabel detailpeminjaman
        for ($i = 0; $i < count($idbuku_arr); $i++) {
            $idbuku = $idbuku_arr[$i];
            $jumlah = $jumlah_arr[$i];

            // ambil data buku (opsional)
            $queryBuku = mysqli_query($koneksi, "SELECT * FROM buku WHERE idbuku='$idbuku'");
            $dataBuku = mysqli_fetch_assoc($queryBuku);

            $total = $jumlah; 
            $tanggalpinjam = $tanggal_pinjam;
            $tanggalkembali = $tanggal_kembali;
            $tanggaldikembalikan = "NULL"; // NULL untuk belum dikembalikan
            $durasipeminjaman = 6;
            $jumlahharitelat = 0;
            $statusPinjam = 'tidakterlambat'; // default status pinjam
            $keterangan = 'belumkembali'; // default keterangan

            // INSERT detailpeminjaman
            $sqlDetail = "
                INSERT INTO detailpeminjaman 
                (idpeminjaman, idbuku, total, tanggalpinjam, tanggalkembali, tanggaldikembalikan, durasipeminjaman, jumlahharitelat, status, keterangan)
                VALUES 
                ('$idpeminjaman', '$idbuku', '$total', '$tanggalpinjam', '$tanggalkembali', NULL, '$durasipeminjaman', '$jumlahharitelat', '$statusPinjam', '$keterangan')
            ";

            if (!mysqli_query($koneksi, $sqlDetail)) {
                echo "<script>
                    alert('Gagal menyimpan detail peminjaman: " . mysqli_error($koneksi) . "');
                    history.back();
                </script>";
                exit;
            }

            // kurangi stok buku
            mysqli_query($koneksi, "UPDATE buku SET stok = stok - $jumlah WHERE idbuku = '$idbuku'");
        }

        // sukses
        echo "<script>
            alert('Data peminjaman berhasil disimpan!');
            window.location='../index.php?halaman=daftarpeminjaman';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan data peminjaman: " . mysqli_error($koneksi) . "');
            history.back();
        </script>";
    }
}
?>
