<?php
// views/buku/buku.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Buku</h3>
  </div>

  <div class="card-body">
    <div class="mb-3">
      <a href="index.php?halaman=tambahbuku" class="btn btn-primary float-right btn-sm mb-3">
        <i class="fas fa-plus"></i> Tambah Buku
      </a>
    </div>

    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Foto</th>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Pengarang</th>
          <th>Tahun Terbit</th>
          <th>Stok</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Ambil data buku beserta nama kategori
        $sql = "
          SELECT 
            b.id_buku, 
            b.judul, 
            k.nama_kategori AS kategori, 
            b.pengarang, 
            b.tahun_terbit, 
            b.stok, 
            b.foto
          FROM buku b
          LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
          ORDER BY b.id_buku
        ";
        $query = mysqli_query($koneksi, $sql);

        if (!$query) {
            echo '<tr><td colspan="8">Query error: ' . htmlspecialchars(mysqli_error($koneksi)) . '</td></tr>';
        } else {
            $no = 1;
            while ($data = mysqli_fetch_assoc($query)) :
                // Tangani foto
                $foto_db = $data['foto'];
                if (!empty($foto_db)) {
                    $foto_path = (strpos($foto_db, '/') !== false) ? $foto_db : 'foto/' . $foto_db;
                    $server_file = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($foto_path, '/');
                    if (!file_exists($server_file)) {
                        $foto_path = 'dist/img/book-default.png';
                    }
                } else {
                    $foto_path = 'dist/img/book-default.png';
                }
        ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><img src="<?= htmlspecialchars($foto_path); ?>" class="img-thumbnail" style="width:60px;height:60px;object-fit:cover;"></td>
                <td><?= htmlspecialchars($data['judul']); ?></td>
                <td><?= htmlspecialchars($data['kategori']); ?></td>
                <td><?= htmlspecialchars($data['pengarang']); ?></td>
                <td><?= htmlspecialchars($data['tahun_terbit']); ?></td>
                <td><?= htmlspecialchars($data['stok']); ?></td>
                <td>
                  <a href="index.php?halaman=editbuku&id=<?= htmlspecialchars($data['id_buku']); ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="hapus_buku.php?id=<?= htmlspecialchars($data['id_buku']); ?>" class="btn btn-danger btn-sm"
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
          <th>Foto</th>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Pengarang</th>
          <th>Tahun Terbit</th>
          <th>Stok</th>
          <th>Aksi</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
