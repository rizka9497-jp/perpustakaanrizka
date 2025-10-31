<?php
?>

<!-- ====== HEADER HALAMAN ====== -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Form Tambah Peminjaman</h1>
      </div>
    </div>
  </div>
</section>

<!-- ====== FORM TAMBAH PEMINJAMAN ====== -->
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header bg-primary">
        <h3 class="card-title text-white">Form Tambah Peminjaman</h3>
      </div>

      <form action="../../db/dbpeminjaman.php?proses=tambah" method="POST" id="formPeminjaman">
        <div class="card-body">

          <!-- === PILIH PEMINJAM === -->
          <div class="form-group">
            <label><strong>Nama Peminjam</strong></label>
            <table class="table table-bordered table-striped">
              <thead class="bg-light">
                <tr>
                  <th>Nama</th>
                  <th>Pilih</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $peminjam = mysqli_query($koneksi, "SELECT * FROM peminjam");
                while ($row = mysqli_fetch_assoc($peminjam)) {
                  echo "
                    <tr>
                      <td>{$row['namapeminjam']}</td>
                      <td class='text-center'>
                        <input type='radio' name='idpeminjam' value='{$row['idpeminjam']}' required>
                      </td>
                    </tr>
                  ";
                }
                ?>
              </tbody>
            </table>
          </div>

          <hr>

          <!-- === TANGGAL DAN DENDA === -->
          <div class="row">
            <div class="col-md-3">
              <label><strong>Tanggal Pinjam</strong></label>
              <input type="text" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" readonly>
            </div>
            <div class="col-md-3">
              <label><strong>Tanggal Kembali (Perkiraan)</strong></label>
              <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label><strong>Durasi Peminjaman</strong></label>
              <input type="text" id="durasi" class="form-control" readonly>
            </div>
            <div class="col-md-3">
              <label><strong>Denda jika terlambat</strong></label>
              <input type="text" id="denda" value="Rp 1000 / hari" class="form-control" readonly>
            </div>
          </div>

          <hr>

          <!-- === DAFTAR BUKU YANG TERSEDIA === -->
          <div class="form-group">
            <label><strong>Daftar Buku Yang Tersedia</strong></label>
            <div id="daftarBuku">
              <div class="row buku-item mb-2">
                <div class="col-md-8">
                  <select name="idbuku[]" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php
                    $buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE stok > 0");
                    while ($row = mysqli_fetch_assoc($buku)) {
                      echo "<option value='{$row['idbuku']}'>{$row['judul']} (Stok: {$row['stok']})</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="number" name="jumlah[]" class="form-control" min="1" placeholder="Jumlah" required>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-danger btnHapusBuku">Hapus</button>
                </div>
              </div>
            </div>
            <button type="button" id="btnTambahBuku" class="btn btn-primary mt-2">+ Tambah Buku</button>
          </div>

        </div>

        <div class="card-footer text-right">
          <button type="reset" class="btn btn-warning">Reset</button>
          <button type="submit" class="btn btn-success">Simpan</button>
          <a href="?halaman=peminjaman" class="btn btn-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- ====== SCRIPT PERHITUNGAN OTOMATIS ====== -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // === Tanggal pinjam otomatis hari ini ===
    const today = new Date();
    const tglPinjamInput = document.getElementById('tanggal_pinjam');
    const tglKembaliInput = document.getElementById('tanggal_kembali');
    const durasiInput = document.getElementById('durasi');

    // Format YYYY-MM-DD
    const todayStr = today.toISOString().split('T')[0];
    tglPinjamInput.value = todayStr;

    // === Hitung tanggal kembali otomatis (misal +7 hari) ===
    const durasiHari = 7;
    const tglKembali = new Date(today);
    tglKembali.setDate(tglKembali.getDate() + durasiHari);
    const tglKembaliStr = tglKembali.toISOString().split('T')[0];
    tglKembaliInput.value = tglKembaliStr;
    durasiInput.value = durasiHari + " hari";

    // Jika user ubah tanggal kembali, hitung ulang durasi
    tglKembaliInput.addEventListener('change', function() {
      const tglKembaliBaru = new Date(this.value);
      const selisih = (tglKembaliBaru - today) / (1000 * 60 * 60 * 24);
      durasiInput.value = selisih > 0 ? selisih + " hari" : "Tanggal tidak valid";
    });

    // === Tambah dan hapus buku ===
    document.getElementById('btnTambahBuku').addEventListener('click', function() {
      const daftar = document.getElementById('daftarBuku');
      const newItem = daftar.querySelector('.buku-item').cloneNode(true);
      newItem.querySelectorAll('input').forEach(i => i.value = '');
      daftar.appendChild(newItem);
    });

    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('btnHapusBuku')) {
        const allBuku = document.querySelectorAll('.buku-item');
        if (allBuku.length > 1) {
          e.target.closest('.buku-item').remove();
        } else {
          alert('Minimal satu buku harus dipinjam.');
        }
      }
    });
  });
</script>
