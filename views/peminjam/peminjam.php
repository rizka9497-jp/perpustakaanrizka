<?php
// views/peminjam/peminjam.php

// Pastikan koneksi tersedia. Sesuaikan path jika koneksi.php berada di folder lain.
if (!isset($koneksi)) {
    // contoh path relatif: jika index.php ada di root project dan koneksi.php di root:
    include_once __DIR__ . '/../../koneksi.php'; // sesuaikan level folder
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Peminjam</h3>
  </div>

  <div class="card-body">
    <!-- tombol di luar table -->
    <div class="mb-3">
      <a href="index.php?halaman=tambahpeminjam" class="btn btn-primary float-right btn-sm mb-3">
        <i class="fas fa-user-plus"></i> Tambah peminjam
      </a>
    </div>

    <table id="example2" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Nama Peminjam</th>
          <th>ID Peminjam</th>
          <th>Alamat</th>
          <th>Notelpon</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Ambil data dari DB
        $sql = "SELECT idpeminjam, namapeminjam, alamat, notelpon, foto FROM peminjam ORDER BY idpeminjam";
        $res = mysqli_query($koneksi, $sql);
        if (!$res) {
            echo '<tr><td colspan="6">Query error: ' . htmlspecialchars(mysqli_error($koneksi)) . '</td></tr>';
        } else {
            while ($row = mysqli_fetch_assoc($res)) {
                // --- tangani path foto ---
                $foto_db = $row['foto']; // bisa berisi 'foto/rizka.jpg' atau hanya 'rizka.jpg' atau NULL
                if (!empty($foto_db)) {
                    // jika hanya nama file tanpa folder, tambahkan folder 'foto/'
                    $foto_path = (strpos($foto_db, '/') !== false) ? $foto_db : 'foto/' . $foto_db;
                    // cek apakah file fisik ada di server; gunakan DOCUMENT_ROOT untuk path server
                    $server_file = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($foto_path, '/');
                    if (!file_exists($server_file)) {
                        // fallback bila tidak ada file fisik
                        $foto_path = 'dist/img/default-user.png'; // gambar default AdminLTE
                    }
                } else {
                    // bila NULL
                    $foto_path = 'dist/img/default-user.png';
                }

                // escape output
                $nama = htmlspecialchars($row['namapeminjam']);
                $id   = htmlspecialchars($row['idpeminjam']);
                $alamat = htmlspecialchars($row['alamat']);
                $telp = htmlspecialchars($row['notelpon']);
                $foto_url = htmlspecialchars($foto_path);

                echo "<tr>";
                echo "<td>{$nama}</td>";
                echo "<td>{$id}</td>";
                echo "<td>{$alamat}</td>";
                echo "<td>{$telp}</td>";
                echo "<td><img src=\"{$foto_url}\" alt=\"foto-{$id}\" class=\"img-thumbnail\" style=\"width:60px;height:60px;object-fit:cover;\"></td>";
                echo "<td>
                        <a href=\"index.php?halaman=editpeminjam&id={$id}\" class=\"btn btn-warning btn-sm\">
                          <i class=\"fas fa-edit\"></i>
                        </a>
                        <a href=\"hapus_peminjam.php?id={$id}\" class=\"btn btn-danger btn-sm\" onclick=\"return confirm('Yakin ingin menghapus?')\">
                          <i class=\"fas fa-trash\"></i>
                        </a>
                      </td>";
                echo "</tr>";
            }
        }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <th>Nama Peminjam</th>
          <th>ID Peminjam</th>
          <th>Alamat</th>
          <th>Notelpon</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </tfoot>
    </table>
  </div><!-- /.card-body -->
</div><!-- /.card -->
