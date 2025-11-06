<?php

date_default_timezone_set('Asia/Jakarta');

if (!isset($_GET['idpeminjaman'])) {
    echo "<script>alert('ID peminjaman tidak ditemukan!'); window.location='daftarpengembalian.php';</script>";
    exit;
}

$idpeminjaman = intval($_GET['idpeminjaman']);

// Ambil data peminjaman + peminjam
$q = mysqli_query($koneksi, "
    SELECT p.*, pm.namapeminjam 
    FROM peminjaman p
    JOIN peminjam pm ON p.idpeminjam = pm.idpeminjam
    WHERE p.idpeminjaman = '$idpeminjaman'
");
if (mysqli_num_rows($q) == 0) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='daftarpengembalian.php';</script>";
    exit;
}
$d = mysqli_fetch_assoc($q);

// Ambil detail buku yang dipinjam
$qDetail = mysqli_query($koneksi, "
    SELECT dp.*, b.judul, b.idbuku
    FROM detailpeminjaman dp
    JOIN buku b ON dp.idbuku = b.idbuku
    WHERE dp.idpeminjaman = '$idpeminjaman'
");
?>

<div class="card card-outline card-primary">
  <div class="card-header bg-info">
    <h5>Proses Pengembalian Buku - <?= htmlspecialchars($d['namapeminjam']) ?></h5>
  </div>
  <div class="card-body">
    <form action="../../db/dbpeminjaman.php?proses=pengembalian" method="POST">
      <input type="hidden" name="idpeminjaman" value="<?= $idpeminjaman ?>">
      <table class="table table-bordered">
        <thead class="bg-light">
          <tr>
            <th>No</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Terlambat</th>
            <th>Denda</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no = 1; $totalDenda = 0;
          while ($r = mysqli_fetch_assoc($qDetail)) {
            $hariIni = date('Y-m-d');
            $selisih = (strtotime($hariIni) - strtotime($r['tanggalkembali'])) / 86400;
            $telat = ($selisih > 0) ? $selisih : 0;
            $denda = $telat * 1000;
            $totalDenda += $denda;
          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($r['judul']) ?></td>
            <td><?= $r['tanggalpinjam'] ?></td>
            <td><?= $r['tanggalkembali'] ?></td>
            <td><?= $telat ?> hari</td>
            <td>Rp<?= number_format($denda,0,',','.') ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>

      <div class="text-center mt-3">
        <h5>Total Denda: Rp<?= number_format($totalDenda, 0, ',', '.') ?></h5>
        <button type="submit" class="btn btn-success mt-2">
          <i class="fas fa-check"></i> Konfirmasi Pengembalian
        </button>
      </div>
    </form>
  </div>
</div>
