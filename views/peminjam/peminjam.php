<?php
// views/peminjam/peminjam.php

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Peminjam</h3>
  </div>

  <div class="card-body">
    <div class="mb-3">
      <a href="index.php?halaman=tambahpeminjam" class="btn btn-primary float-right btn-sm mb-3">
        <i class="fas fa-user-plus"></i> Tambah Peminjam
      </a>
    </div>

    <table id="example2" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Nama Peminjam</th>
          <th>ID Peminjam</th>
          <th>Alamat</th>
          <th>No Telp</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT id_peminjam, nama_peminjam, alamat, no_telp, foto FROM peminjam ORDER BY id_peminjam";
        $res = mysqli_query($koneksi, $sql);
        if (!$res) {
            die("<tr><td colspan='6'>Query error: " . htmlspecialchars(mysqli_error($koneksi)) . "</td></tr>");
        }

        while ($row = mysqli_fetch_assoc($res)) {
            $foto_db = $row['foto'];
            if (!empty($foto_db)) {
                $foto_path = (strpos($foto_db, '/') !== false) ? $foto_db : 'foto/' . $foto_db;
                $server_file = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($foto_path, '/');
                if (!file_exists($server_file)) {
                    $foto_path = 'dist/img/default-user.png';
                }
            } else {
                $foto_path = 'dist/img/default-user.png';
            }

            $nama   = htmlspecialchars($row['nama_peminjam']);
            $id     = htmlspecialchars($row['id_peminjam']);
            $alamat = htmlspecialchars($row['alamat']);
            $telp   = htmlspecialchars($row['no_telp']);
            $foto_url = htmlspecialchars($foto_path);

            echo "<tr>";
            echo "<td>{$nama}</td>";
            echo "<td>{$id}</td>";
            echo "<td>{$alamat}</td>";
            echo "<td>{$telp}</td>";
            echo "<td><img src=\"{$foto_url}\" class=\"img-thumbnail\" style=\"width:60px;height:60px;object-fit:cover;\"></td>";
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
        ?>
      </tbody>
      <tfoot>
        <tr>
          <th>Nama Peminjam</th>
          <th>ID Peminjam</th>
          <th>Alamat</th>
          <th>No Telp</th>
          <th>Foto</th>
          <th>Aksi</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
