<?php
include "../../koneksi.php";

if (!isset($_GET['idpeminjaman'])) {
    echo "<script>alert('ID peminjaman tidak ditemukan!');history.back();</script>";
    exit;
}

$idpeminjaman = intval($_GET['idpeminjaman']);
$tanggal_dikembalikan = date('Y-m-d');

// ambil semua detail peminjaman yang belum dikembalikan
$query = "
    SELECT iddetailpeminjaman, tanggalkembali
    FROM detailpeminjaman
    WHERE idpeminjaman = '$idpeminjaman' AND keterangan = 'belumkembali'
";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
        $iddetail = $data['iddetailpeminjaman'];
        $tanggalkembali = $data['tanggalkembali'];

        // hitung keterlambatan
        $selisih = (strtotime($tanggal_dikembalikan) - strtotime($tanggalkembali)) / 86400;
        $jumlahharitelat = ($selisih > 0) ? floor($selisih) : 0;
        $denda = $jumlahharitelat * 1000; // misal denda 1000 per hari

        // update data detail
        $update = "
            UPDATE detailpeminjaman 
            SET tanggaldikembalikan = '$tanggal_dikembalikan',
                jumlahharitelat = '$jumlahharitelat',
                denda = '$denda',
                keterangan = 'sudahkembali',
                status = IF($jumlahharitelat > 0, 'terlambat', 'tidakterlambat')
            WHERE iddetailpeminjaman = '$iddetail'
        ";
        mysqli_query($koneksi, $update);
    }

    // ubah status utama peminjaman (opsional)
    mysqli_query($koneksi, "
        UPDATE peminjaman 
        SET status = 'Dikembalikan' 
        WHERE idpeminjaman = '$idpeminjaman'
    ");

    echo "<script>
        alert('Pengembalian berhasil diproses!');
        window.location='../../index.php?halaman=daftarpengembalian';
    </script>";
} else {
    echo "<script>
        alert('Tidak ada detail peminjaman yang perlu dikembalikan!');
        window.location='../../index.php?halaman=daftarpengembalian';
    </script>";
}
?>
