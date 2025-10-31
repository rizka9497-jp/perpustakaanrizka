<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card text-xs">
    <div class="card-header bg-primary">
      <h2 class="card-title">Tambah Kategori</h2>
    </div>

    <div class="card-body">
      <div class="card card-warning">

        <!-- form start -->
        <form action="db/dbkategori.php?proses=tambah" method="POST">
          <div class="card-body-sm ml-2">
            <div class="form-group">
              <label for="namakategori">Nama Kategori</label>
              <input type="text" class="form-control" id="namakategori" name="namakategori"
                placeholder="Masukkan nama kategori" required>
            </div>
          </div>

          <div class="card-footer-sm float-right">
            <button type="reset" class="btn-sm btn-warning"><i class="fa fa-retweet"></i> Reset</button>
            <button type="submit" class="btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card-footer">
    
    </div>
  </div>

</section>


<?php
$query = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY namakategori ASC");

if (!$query) {
  die("Query Error: " . mysqli_error($koneksi));
}
?>

<div class="card mt-4">
  <div class="card-header">
    <h3 class="card-title">Data Kategori</h3>
  </div>

  <div class="card card-solid">
    <div class="col">
      <a href="index.php?halaman=tambahkategori" class="btn btn-primary float-right btn-sm mt-3">
        <i class="fas fa-plus"></i> Tambah Kategori
      </a>

      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Kategori</th>
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
              <td><?= htmlspecialchars($data['namakategori']); ?></td>
              <td>
                <a href="index.php?halaman=editkategori&nama=<?= urlencode($data['namakategori']); ?>" class="btn btn-warning btn-sm">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="db/dbkategori.php?proses=hapus&namakategori=<?= urlencode($data['namakategori']); ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin ingin menghapus kategori <?= htmlspecialchars($data['namakategori']); ?>?');">
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
