<?php
// views/kategori/kategori.php

// Pastikan koneksi tersedia. Sesuaikan path jika koneksi.php berada di folder lain.
if (!isset($koneksi)) {
    include_once __DIR__ . '/../../koneksi.php'; // sesuaikan level folder
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Kategori Buku</h3>
  </div>

  <div class="card-body">
    <!-- tombol di luar table -->
    <div class="mb-3">
      <a href="index.php?halaman=tambahkategori" class="btn btn-primary float-right btn-sm mb-3">
        <i class="fas fa-plus"></i> Tambah Kategori
      </a>
    </div>

    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Kategori</th>
          <th>Nama Kategori</th>
          <th>Keterangan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Ambil data dari tabel kategori
        $sql = "SELECT idkategori, namakategori, keterangan FROM kategori ORDER BY idkategori";
        $query = mysqli_query($koneksi, $sql);

        if (!$query) {
            echo '<tr><td colspan="5">Query error: ' . htmlspecialchars(mysqli_error($koneksi)) . '</td></tr>';
        } else {
            $no = 1;
            while ($data = mysqli_fetch_assoc($query)) :
        ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($data['idkategori']); ?></td>
                <td><?= htmlspecialchars($data['namakategori']); ?></td>
                <td><?= htmlspecialchars($data['keterangan']); ?></td>
                <td>
                  <a href="index.php?halaman=editkategori&id=<?= htmlspecialchars($data['idkategori']); ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="hapus_kategori.php?id=<?= htmlspecialchars($data['idkategori']); ?>" class="btn btn-danger btn-sm"
                     onclick="return confirm('Yakin ingin menghapus kategori ini?');">
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
          <th>ID Kategori</th>
          <th>Nama Kategori</th>
          <th>Keterangan</th>
          <th>Aksi</th>
        </tr>
      </tfoot>
    </table>
  </div><!-- /.card-body -->
</div><!-- /.card -->
