<?php
include "../../koneksi.php"; // sesuaikan path koneksimu
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Pengembalian Buku</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item active">Pengembalian</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Buku yang Masih Dipinjam</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
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
            $query = mysqli_query($koneksi, "
              SELECT 
                p.idpeminjaman,
                pm.nama_peminjam,
                b.judul_buku,
                p.tanggal_pinjam,
                p.tanggal_kembali,
                p.status
              FROM peminjaman p
              JOIN peminjam pm ON p.idpeminjam = pm.idpeminjam
              JOIN buku b ON p.idbuku = b.idbuku
              WHERE p.status = 'Dipinjam'
              ORDER BY p.tanggal_pinjam DESC
            ");

            if (mysqli_num_rows($query) > 0) {
              while ($data = mysqli_fetch_assoc($query)) {
                echo "
                  <tr>
                    <td class='text-center'>{$no}</td>
                    <td>{$data['nama_peminjam']}</td>
                    <td>{$data['judul_buku']}</td>
                    <td class='text-center'>{$data['tanggal_pinjam']}</td>
                    <td class='text-center'>{$data['tanggal_kembali']}</td>
                    <td class='text-center'>
                      <span class='badge badge-warning'>{$data['status']}</span>
                    </td>
                    <td class='text-center'>
                      <a href='../../db/prosespengembalian.php?id={$data['idpeminjaman']}' 
                         class='btn btn-success btn-sm'
                         onclick='return confirm(\"Yakin buku ini sudah dikembalikan?\")'>
                         <i class='fas fa-undo'></i> Kembalikan
                      </a>
                    </td>
                  </tr>
                ";
                $no++;
              }
            } else {
              echo "<tr><td colspan='7' class='text-center text-muted'>Tidak ada buku yang sedang dipinjam</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
