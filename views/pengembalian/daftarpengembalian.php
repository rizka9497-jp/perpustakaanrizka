<?php
include "../../koneksi.php";

// ambil semua data peminjaman yang belum dikembalikan
$query = "
    SELECT 
        p.idpeminjaman,
        pm.namapeminjam,
        b.judulbuku,
        dp.iddetailpeminjaman,
        dp.tanggalpinjam,
        dp.tanggalkembali,
        dp.status,
        dp.keterangan
    FROM detailpeminjaman dp
    JOIN peminjaman p ON dp.idpeminjaman = p.idpeminjaman
    JOIN peminjam pm ON p.idpeminjam = pm.idpeminjam
    JOIN buku b ON dp.idbuku = b.idbuku
    WHERE dp.keterangan = 'belumkembali'
    ORDER BY dp.tanggalpinjam DESC
";

$result = mysqli_query($koneksi, $query);
?>

<section class="content-header">
  <div class="container-fluid">
    <h1>Daftar Pengembalian Buku</h1>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                <td>{$no}</td>
                <td>{$row['namapeminjam']}</td>
                <td>{$row['judulbuku']}</td>
                <td>{$row['tanggalpinjam']}</td>
                <td>{$row['tanggalkembali']}</td>
                <td><span class='badge bg-warning text-dark'>{$row['keterangan']}</span></td>
                <td>
                  <a href='views/pengembalian/prosespengembalian.php?idpeminjaman={$row['idpeminjaman']}' 
                     class='btn btn-success btn-sm'
                     onclick=\"return confirm('Apakah buku ini sudah dikembalikan?');\">
                     Kembalikan Sekarang
                  </a>
                </td>
              </tr>";
              $no++;
            }
          } else {
            echo "<tr><td colspan='7' class='text-center'>Tidak ada buku yang perlu dikembalikan.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
