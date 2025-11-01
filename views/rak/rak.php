<?php
include "koneksi.php";

// Nonaktifkan tampilan error di browser (opsional, untuk produksi)
error_reporting(0);
ini_set('display_errors', 0);
?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card text-xs">
    <div class="card-header bg-primary">
      <h2 class="card-title">Tambah Rak</h2>
    </div>

    <div class="card-body">
      <div class="card card-warning">

        <!-- form start -->
        <form action="db/dbrak.php?proses=tambah" method="POST">
          <div class="card-body-sm ml-2">
            <div class="form-group">
              <label for="Namarak">Nama Rak</label>
              <input type="text" class="form-control" id="Namarak" name="Namarak"
                     placeholder="Masukkan nama rak" required>
            </div>
          </div>

          <div class="card-footer-sm float-right">
            <button type="reset" class="btn-sm btn-warning">
              <i class="fa fa-retweet"></i> Reset
            </button>
            <button type="submit" class="btn-sm btn-primary">
              <i class="fa fa-save"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="card-footer"></div>
  </div>

</section>

<?php
// Ambil data dari tabel rak
$query = mysqli_query($koneksi, "SELECT * FROM rak ORDER BY Namarak ASC");

if (!$query) {
  die("Query Error: " . mysqli_error($koneksi));
}
?>

<div class="card mt-4">
  <div class="card-header">
    <h3 class="card-title">Data Rak</h3>
  </div>

  <div class="card card-solid">
    <div class="col">
      <a href="index.php?halaman=tambahrak" class="btn btn-primary float-right btn-sm mt-3">
        <i class="fas fa-plus"></i> Tambah Rak
      </a>

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Rak</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php
          $no = 1;
          while ($data = mysqli_fetch_assoc($query)) :
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($data['Namarak'] ?? ''); ?></td>
              <td>
                <a href="index.php?halaman=editrak&Idrak=<?= $data['Idrak'] ?? ''; ?>"
                   class="btn btn-warning btn-sm">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="db/dbrak.php?proses=hapus&Idrak=<?= $data['Idrak'] ?? ''; ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin ingin menghapus Rak <?= htmlspecialchars($data['Namarak'] ?? ''); ?>?');">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
