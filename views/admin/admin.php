<?php
include "koneksi.php";
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Admin</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Data Admin</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h3 class="card-title mb-0"><i class="fas fa-users"></i> Daftar Admin</h3>
      <a href="index.php?halaman=tambahadmin" class="btn btn-light btn-sm">
        <i class="fas fa-plus"></i> Tambah Admin
      </a>
    </div>

    <div class="card-body">
      <div class="row">
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY nama ASC");
        if (mysqli_num_rows($query) > 0) {
          while ($data = mysqli_fetch_assoc($query)) {
            $foto = !empty($data['foto']) ? "foto/" . $data['foto'] : "foto/default.png";
        ?>
            <div class="col-md-3 text-center mb-4">
              <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body">
                  <!-- FOTO ADMIN -->
                  <div class="d-flex justify-content-center mb-3">
                    <img src="<?= $foto ?>" 
                         alt="Foto Admin" 
                         class="rounded-circle border border-3 border-primary shadow-sm"
                         width="120" height="120" 
                         style="object-fit: cover;">
                  </div>

                  <!-- NAMA DAN USERNAME -->
                  <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($data['nama']) ?></h5>
                  <p class="text-muted mb-3">@<?= htmlspecialchars($data['username']) ?></p>

                  <!-- TOMBOL AKSI -->
                  <div class="d-flex justify-content-center gap-2">
                    <a href="index.php?halaman=tampiladmin&id=<?= $data['idadmin'] ?>" 
                       class="btn btn-sm btn-primary">
                       <i class="fas fa-eye"></i> View
                    </a>
                    <a href="index.php?halaman=editadmin&id=<?= $data['idadmin'] ?>" 
                       class="btn btn-sm btn-warning text-white">
                       <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="db/dbadmin.php?proses=hapus&id=<?= $data['idadmin'] ?>" 
                       onclick="return confirm('Yakin ingin menghapus admin ini?')" 
                       class="btn btn-sm btn-danger">
                       <i class="fas fa-trash"></i> Hapus
                    </a>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
        } else {
          echo "<div class='col-12 text-center text-danger'>Belum ada data admin.</div>";
        }
        ?>
      </div>
    </div>
  </div>
</section>
