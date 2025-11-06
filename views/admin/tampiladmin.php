<?php
include "../koneksi.php";
?>

<section class="content-header">
  <div class="container-fluid">
    <h1>Data Admin</h1>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <a href="index.php?halaman=tambahadmin" class="btn btn-primary mb-3">
      <i class="fas fa-plus"></i> Tambah Admin
    </a>

    <div class="card">
      <div class="card-header bg-info text-white">
        <h3 class="card-title">Daftar Admin</h3>
      </div>

      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Foto</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY idadmin DESC");
            while ($data = mysqli_fetch_array($query)) {
            ?>
              <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($data['nama']); ?></td>
                <td><?= htmlspecialchars($data['username']); ?></td>
                <td class="text-center">
                  <img src="foto/<?= $data['foto']; ?>" alt="Foto Admin" width="60" height="60" class="img-circle">
                </td>
                <td class="text-center">
                  <a href="index.php?halaman=editadmin&idadmin=<?= $data['idadmin']; ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="db/dbadmin.php?proses=hapus&idadmin=<?= $data['idadmin']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?');">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
