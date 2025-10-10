<?php
// views/buku/buku.php

// Pastikan koneksi tersedia. Sesuaikan path jika koneksi.php berada di folder lain.
if (!isset($koneksi)) {
    include_once __DIR__ . '/../../koneksi.php'; // sesuaikan level folder
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Buku</h3>
  </div>

  <div class="card-body">
    <!-- tombol di luar table -->
    <div class="mb-3">
      <a href="index.php?halaman=tambahbuku" class="btn btn-primary float-right btn-sm mb-3">
        <i class="fas fa-plus"></i> Tambah Buku
      </a>
    </div>

    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Buku</th>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Pengarang</th>
          <th>Tahun Terbit</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Ambil data dari tabel buku
        $sql = "SELECT idbuku, buku, judul, kategori, pengarang, tahunterbit FROM buku ORDER BY idbuku";
        $query = mysqli_query($koneksi, $sql);

        if (!$query) {
            echo '<tr><td colspan="7">Query error: ' . htmlspecialchars(mysqli_error($koneksi)) . '</td></tr>';
        } else {
            $no = 1;
            while ($data = mysqli_fetch_assoc($query)) :
        ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($data['buku']); ?></td>
                <td><?= htmlspecialchars($data['judul']); ?></td>
                <td><?= htmlspecialchars($data['kategori']); ?></td>
                <td><?= htmlspecialchars($data['pengarang']); ?></td>
                <td><?= htmlspecialchars($data['tahunterbit']); ?></td>
                <td>
                  <a href="index.php?halaman=editbuku&id=<?= htmlspecialchars($data['idbuku']); ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="hapus_buku.php?id=<?= htmlspecialchars($data['idbuku']); ?>" class="btn btn-danger btn-sm"
                     onclick="return confirm('Yakin ingin menghapus data ini?');">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
        <?php
            endwhile;
        }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <th>No</th>
          <th>Buku</th>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Pengarang</th>
          <th>Tahun Terbit</th>
          <th>Aksi</th>
        </tr>
      </tfoot>
    </table>
  </div><!-- /.card-body -->
</div><!-- /.card -->
