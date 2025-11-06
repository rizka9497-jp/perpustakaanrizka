

<!-- ===========================================================
     HALAMAN EDIT ADMIN
=========================================================== -->
<section class="content">
  <div class="card shadow-sm border-0">
    <div class="card-header bg-gradient-primary text-white">
      <div class="row">
        <div class="col">
          <h5 class="m-0"><i class="fas fa-user-edit me-2"></i> Edit Data Admin</h5>
        </div>
        <div class="col text-end">
          <a href="index.php?halaman=admin" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
    </div>

    <div class="card-body">

      <form action="db/dbadmin.php?proses=edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idadmin" value="<?= htmlspecialchars($admin['idadmin']); ?>">

        <div class="form-group mb-3">
          <label for="nama">Nama Admin</label>
          <input type="text" class="form-control" id="nama" name="nama"
                 value="<?= htmlspecialchars($admin['nama']); ?>" required>
        </div>

        <div class="form-group mb-3">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username"
                 value="<?= htmlspecialchars($admin['username']); ?>" required>
        </div>

        <div class="form-group mb-3">
          <label for="password">Password (kosongkan jika tidak ingin mengubah)</label>
          <input type="password" class="form-control" id="password" name="password"
                 placeholder="Masukkan password baru (opsional)">
        </div>

        <div class="form-group mb-3">
          <label for="foto">Foto Admin</label>
          <div class="mb-2">
            <img src="<?= $fotoAdmin; ?>" alt="Foto Admin"
                 class="img-thumbnail border"
                 style="width:120px; height:120px; object-fit:cover;">
    
          <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
          <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
        </div>

        <div class="text-end">
          <button type="reset" class="btn btn-warning btn-sm">
            <i class="fa fa-retweet"></i> Reset
          </button>
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa fa-save"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div
