<?php

// Pastikan parameter nama kategori dikirim lewat URL
if (!isset($_GET['nama']) || empty($_GET['nama'])) {
  die("<script>alert('Nama kategori tidak ditemukan.'); window.location.href='../index.php?halaman=kategori';</script>");
}

$nama = urldecode($_GET['nama']);

// Ambil data kategori berdasarkan nama
$query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE namakategori='$nama'");
if (!$query || mysqli_num_rows($query) == 0) {
  die("<script>alert('Data kategori tidak ditemukan.'); window.location.href='../index.php?halaman=kategori';</script>");
}

$kategori = mysqli_fetch_assoc($query);
?>

<!-- Main Content -->
<section class="content">

  <div class="card">
    <div class="card-header bg-gradient-primary mb-3">
      <div class="row">
        <div class="col">
          <strong><h5 style="font-family: Arial, Helvetica, sans-serif;">Edit Kategori</h5></strong>
        </div>
        <div class="col text-end">
          <a href="index.php?halaman=kategori" class="btn btn-light btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
    </div>

    <div class="card-body">
      <div class="card text-xs">

        <!-- Form Edit Kategori -->
        <form action="db/dbkategori.php?proses=edit" method="POST">
          <!-- Simpan nama lama sebagai acuan update -->
          <input type="hidden" name="namalama" value="<?= htmlspecialchars($kategori['namakategori']); ?>">

          <div class="card-body-sm ml-2">
            <div class="form-group mb-3">
              <label for="namakategori">Nama Kategori</label>
              <input type="text"
                     class="form-control"
                     id="namakategori"
                     name="namakategori"
                     value="<?= htmlspecialchars($kategori['namakategori']); ?>"
                     placeholder="Masukkan nama kategori baru"
                     required>
            </div>
          </div>

          <div class="card-footer text-end">
            <button type="reset" class="btn-sm btn-warning">
              <i class="fa fa-retweet"></i> Reset
            </button>
            <button type="submit" class="btn-sm btn-primary">
              <i class="fa fa-save"></i> Simpan Perubahan
            </button>
          </div>
        </form>

      </div>
    </div>

    <div class="card-footer text-center text-muted">
      Form Edit Data Kategori
    </div>
  </div>

</section>
<!-- /.content -->
