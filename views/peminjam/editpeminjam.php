<?php
include "koneksi.php";

// Validasi dan sanitasi input
$id = isset($_GET['idpeminjam']) ? $_GET['idpeminjam'] : '';
$id_bersih = mysqli_real_escape_string($koneksi, $id);

// Ambil data peminjam dari database
$sql = mysqli_query($koneksi, "SELECT * FROM peminjam WHERE idpeminjam='$id_bersih'");
$data = mysqli_fetch_array($sql);

// Cek jika data tidak ditemukan
if (!$data) {
    echo "<script>
            alert('Data peminjam tidak ditemukan.');
            window.location='index.php?halaman=peminjam';
          </script>";
    exit;
}
?>

<section class="content">
  <div class="card">
    <!-- Header -->
    <div class="card-header bg-gradient-primary mb-3 d-flex justify-content-between align-items-center">
      <h5 class="mb-0 text-white" style="font-family: Arial, Helvetica, sans-serif;">Edit Peminjam</h5>
      <a href="index.php?halaman=tampilpeminjam" class="btn btn-light btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
    </div>

    <!-- Body -->
    <div class="card-body">
      <form action="db/dbpeminjam.php?proses=edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idpeminjam" value="<?= htmlspecialchars($data['idpeminjam']); ?>">

        <div class="form-group">
          <label for="namapeminjam">Nama Peminjam</label>
          <input 
            type="text" 
            class="form-control" 
            id="namapeminjam" 
            name="namapeminjam" 
            value="<?= htmlspecialchars($data['namapeminjam']); ?>" 
            required
          >
        </div>

        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea 
            class="form-control" 
            id="alamat" 
            name="alamat" 
            rows="2" 
            required
          ><?= htmlspecialchars($data['alamat']); ?></textarea>
        </div>

        <div class="form-group">
          <label for="notelpon">Nomor Telepon</label>
          <input 
            type="text" 
            class="form-control" 
            id="notelpon" 
            name="notelpon" 
            value="<?= htmlspecialchars($data['notelpon']); ?>" 
            required
          >
        </div>

        <div class="form-group">
          <label for="foto">Upload Foto Peminjam</label>
          <input 
            type="file" 
            name="foto" 
            id="foto" 
            class="form-control" 
            accept="image/*"
          >

          <?php if (!empty($data['foto'])): 
            $foto_path_display = 'foto/' . htmlspecialchars($data['foto']);
          ?>
            <div class="mt-3 text-center">
              <p class="text-muted mb-1">Foto Saat Ini:</p>
              <img 
                src="<?= $foto_path_display; ?>" 
                alt="Foto Peminjam Lama" 
                width="120" 
                class="rounded border shadow-sm"
              >
            </div>
          <?php endif; ?>
        </div>

        <!-- Tombol Aksi -->
        <div class="text-end mt-4">
          <button type="reset" class="btn btn-warning btn-sm">
            <i class="fa fa-retweet"></i> Reset
          </button>
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa fa-save"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>

    <!-- Footer -->
    <div class="card-footer text-center text-muted">
      <small>&copy; Sistem Peminjaman Buku</small>
    </div>
  </div>
</section>
