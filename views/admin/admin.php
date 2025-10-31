<?php
require_once 'koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY idadmin DESC");
?>

<section class="content">
  <div class="card card-solid shadow-sm border-0">

    <!-- Header -->
    <div class="card-header bg-primary text-white">
      <h3 class="card-title m-0">
        <i class="fas fa-users me-2"></i> Data Admin
      </h3>
    </div>

    <!-- Body -->
    <div class="card-body pb-0">

      <!-- Tombol tambah admin di sudut kanan atas tabel -->
      <div class="d-flex justify-content-end mb-3">
        <a href="index.php?halaman=tambahadmin" class="btn btn-primary btn-sm shadow-sm">
          <i class="fas fa-user-plus"></i> Tambah Admin
        </a>
      </div>

      <div class="row">
        <?php if (mysqli_num_rows($query) > 0): ?>
          <?php while ($data = mysqli_fetch_assoc($query)): ?>
            <?php
              $fotoPath = (!empty($data['foto']) && file_exists("foto/fotoadmin/" . $data['foto']))
                ? "foto/fotoadmin/" . htmlspecialchars($data['foto'])
                : "dist/img/user2-160x160.jpg";
            ?>
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                  Administrator
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-8">
                      <h2 class="lead mb-1">
                        <b><?= htmlspecialchars($data['nama']); ?></b>
                      </h2>
                      <p class="text-muted text-sm mb-1">
                        <b>Username:</b> <?= htmlspecialchars($data['username']); ?>
                      </p>
                    </div>
                    <div class="col-4 text-center">
                      <img src="<?= $fotoPath; ?>"
                           alt="Foto Admin"
                           class="img-circle img-fluid"
                           style="width:100px; height:100px; object-fit:cover;">
                    </div>
                  </div>
                </div>
                <div class="card-footer text-end">
                  <a href="index.php?halaman=editadmin&idadmin=<?= urlencode($data['idadmin']); ?>" 
                     class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="db/dbadmin.php?proses=hapus&idadmin=<?= urlencode($data['idadmin']); ?>"
                     class="btn btn-sm btn-danger"
                     onclick="return confirm('Yakin ingin menghapus admin: <?= addslashes($data['nama']); ?>?');">
                    <i class="fas fa-trash"></i> Hapus
                  </a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="col-12 text-center">
            <p class="text-muted mt-3">Belum ada data admin.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Footer -->
    <div class="card-footer text-center text-muted">
      <small>© <?= date('Y'); ?> Aplikasi Perpustakaan — Semua Hak Dilindungi</small>
    </div>
  </div>
</section>
