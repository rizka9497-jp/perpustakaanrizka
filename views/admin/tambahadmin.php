<section class="content">
  <div class="container-fluid">
    <div class="card shadow-sm p-3">
      <form action="db/dbadmin.php?proses=tambah" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label>Nama</label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="form-group mt-2">
          <label>Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group mt-2">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group mt-2">
          <label>Foto (Opsional)</label>
          <input type="file" name="foto" class="form-control">
        </div>
        <div class="mt-3">
          <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
          <a href="index.php?halaman=admin" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</section>
