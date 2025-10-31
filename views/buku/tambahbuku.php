

<section class="content">
  <div class="card shadow-sm">
    <div class="card-header bg-primary">
      <h3 class="card-title text-white m-0">Tambah Buku </h3>
    </div>

    <form action="db/dbbuku.php?proses=tambah" method="POST" enctype="multipart/form-data">
      <div class="card-body">
        
        <!-- Judul Buku -->
        <div class="form-group mb-3">
          <label for="judul" class="fw-bold">Judul Buku</label>
          <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul buku" required>
        </div>

        <!-- Nama Pengarang -->
        <div class="form-group mb-3">
          <label for="pengarang" class="fw-bold"> Pengarang</label>
          <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Masukkan nama pengarang" required>
        </div>

        <!-- Tahun Terbit -->
        <div class="form-group mb-3">
          <label for="tahun_terbit" class="fw-bold">Tahun Terbit</label>
          <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" placeholder="Contoh: 2024" required min="1000" max="2100">
        </div>

        <!-- Jumlah Stok -->
        <div class="form-group mb-3">
          <label for="stok" class="fw-bold"> Stok</label>
          <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukkan jumlah stok" required min="1">
        </div>

        <!-- Pilihan Kategori -->
        <div class="form-group mb-3">
          <label for="idkategori" class="fw-bold">Kategori</label>
          <select class="form-control" id="idkategori" name="idkategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php
              $queryKategori = mysqli_query($koneksi, "SELECT idkategori, namakategori FROM kategori ORDER BY namakategori ASC");
              while ($dataKategori = mysqli_fetch_assoc($queryKategori)) {
                echo '<option value="'.$dataKategori['idkategori'].'">'.$dataKategori['namakategori'].'</option>';
              }
            ?>
          </select>
        </div>

        <!-- Pilihan Rak -->
        <div class="form-group mb-3">
          <label for="idrak" class="fw-bold">rak</label>
          <select class="form-control" id="idrak" name="idrak" required>
            <option value="">-- Pilih Rak  --</option>
            <?php
              $queryRak = mysqli_query($koneksi, "SELECT idrak, namarak FROM rak ORDER BY namarak ASC");
              while ($dataRak = mysqli_fetch_assoc($queryRak)) {
                echo '<option value="'.$dataRak['idrak'].'">'.$dataRak['namarak'].'</option>';
              }
            ?>
          </select>
        </div>

        <!-- Foto Buku -->
        <div class="form-group mb-4">
          <label for="foto" class="fw-bold">Foto Buku</label>
          <input type="file" class="form-control mt-2" id="foto" name="foto" accept="image/*">
        </div>
      </div>

      <!-- Tombol Simpan -->
      <div class="card-footer text-right">
        <button type="reset" class="btn btn-warning mr-2">
          <i class="fa fa-retweet"></i> Reset
        </button>
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-save"></i> Simpan Buku
        </button>
      </div>
    </form>
  </div>
</section>
