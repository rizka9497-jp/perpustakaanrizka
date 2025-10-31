<?php

// Ambil data dari tabel admin
$query = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY id_admin ASC");
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Admin</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?halaman=dashboard">Home</a></li>
          <li class="breadcrumb-item active">Admin</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title">Data Admin</h3>
        <a href="?halaman=tambahadmin" class="btn btn-light btn-sm float-right">
          <i class="fas fa-plus"></i> Tambah Admin
        </a>
      </div>

      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead class="text-center">
            <tr>
              <th>No</th>
              <th>Foto</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Status</th>
              <th>Role</th>
              <th>Tanggal Persetujuan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_array($query)) {
            ?>
              <tr class="text-center">
                <td><?= $no++; ?></td>
                <td>
                  <?php if (!empty($data['foto'])) { ?>
                    <img src="foto/<?= $data['foto']; ?>" alt="Foto Admin" width="60" height="60" class="rounded-circle">
                  <?php } else { ?>
                    <span class="text-muted">Tidak Ada</span>
                  <?php } ?>
                </td>
                <td><?= htmlspecialchars($data['nama_admin']); ?></td>
                <td><?= htmlspecialchars($data['username']); ?></td>
                <td>
                  <?php if ($data['status'] == 'Disetujui') { ?>
                    <span class="badge badge-success">Disetujui</span>
                  <?php } else { ?>
                    <span class="badge badge-danger">Belum</span>
                  <?php } ?>
                </td>
                <td><?= htmlspecialchars($data['role']); ?></td>
                <td><?= htmlspecialchars($data['tanggal_persetujuan']); ?></td>
                <td>
                  <a href="?halaman=tampiladmin&id=<?= $data['id_admin']; ?>" class="btn btn-info btn-sm">
                    <i class="fas fa-eye"></i> Lihat
                  </a>
                  <a href="?halaman=editadmin&id=<?= $data['id_admin']; ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="db/dbadmin.php?proses=hapus&id=<?= $data['id_admin']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">
                    <i class="fas fa-trash"></i> Hapus
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
