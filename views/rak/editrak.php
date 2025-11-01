<?php

// Pastikan parameter Idrak dikirim
if (!isset($_GET['Idrak']) || empty($_GET['Idrak'])) {
    die("Error: ID rak tidak ditemukan.");
}

$Idrak = mysqli_real_escape_string($koneksi, $_GET['Idrak']);

// Ambil data rak dari database
$query = mysqli_query($koneksi, "SELECT * FROM rak WHERE Idrak='$Idrak'");
if (!$query) {
    die("Query Error: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($query);
if (!$data) {
    die("Error: Data rak tidak ditemukan di database.");
}
?>

<!-- Main content -->
<section class="content">

  <div class="card text-xs">
    <div class="card-header bg-warning">
      <h2 class="card-title">Edit Rak</h2>
    </div>

    <div class="card-body">
      <div class="card card-warning">

        <!-- Form Edit -->
        <form action="db/dbrak.php?proses=edit" method="POST">
          <input type="hidden" name="Idrak" value="<?= htmlspecialchars($data['Idrak']); ?>">

          <div class="card-body-sm ml-2">
            <div class="form-group">
              <label for="Namarak">Nama Rak</label>
              <input type="text" class="form-control" id="Namarak" name="Namarak"
                     value="<?= htmlspecialchars($data['Namarak']); ?>"
                     placeholder="Masukkan nama rak" required>
            </div>
          </div>

          <div class="card-footer-sm float-right">
            <a href="index.php?halaman=rak" class="btn btn-secondary btn-sm">
              <i class="fa fa-arrow-left"></i> Kembali
            </a>
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

    <div class="card-footer"></div>
  </div>

</section>
