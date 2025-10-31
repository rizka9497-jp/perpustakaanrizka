<section class="content">
  <div class="card shadow-sm">
    <div class="card-header bg-primary">
      <h3 class="card-title text-white m-0">Tambah Peminjam</h3>
    </div>

    <form action="db/dbpeminjam.php?proses=tambah" method="POST" enctype="multipart/form-data">
      <div class="card-body">

        <div class="form-group mb-3">
          <label for="namapeminjam" class="fw-bold">Nama Peminjam</label>
          <input type="text" class="form-control" id="namapeminjam" name="namapeminjam"
            placeholder="Masukkan nama peminjam" required>
        </div>

        <div class="form-group mb-3">
          <label for="alamat" class="fw-bold">Alamat</label>
          <input type="text" class="form-control" id="alamat" name="alamat"
            placeholder="Masukkan alamat" required>
        </div>

        <div class="form-group mb-3">
          <label for="notelpon" class="fw-bold">No. Telepon</label>
          <input type="text" class="form-control" id="notelpon" name="notelpon"
            placeholder="Masukkan nomor telepon" required>
        </div>

        <div class="form-group mb-4">
          <label for="foto" class="fw-bold">Foto Peminjam</label>
          <input type="file" class="form-control mt-2" id="foto" name="foto" accept="image/*">
        </div>

      </div>

      <div class="card-footer text-right">
        <button type="reset" class="btn btn-warning mr-2">
          <i class="fa fa-retweet"></i> Reset
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-save"></i> Simpan Peminjam
        </button>
      </div>
    </form>
  </div>
</section>
