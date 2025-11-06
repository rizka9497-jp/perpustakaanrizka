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

      <form action="db/dbpeminjaman.php?proses=tambah" method="POST" id="formPeminjaman">
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

          <!-- === TANGGAL DAN DENDA (hanya tampilan, tidak dikirim ke DB) === -->
          <div class="row">
            <div class="col-md-3">
              <label><strong>Tanggal Pinjam</strong></label>
              <input type="text" id="tanggal_pinjam" class="form-control" readonly>
            </div>
            <div class="col-md-3">
              <label><strong>Tanggal Kembali (Batas)</strong></label>
              <input type="text" id="tanggal_kembali" class="form-control" readonly>
            </div>
            <div class="col-md-3">
              <label><strong>Durasi Peminjaman</strong></label>
              <input type="text" id="durasi" class="form-control" readonly>
            </div>
            <div class="col-md-3">
              <label><strong>Denda jika terlambat</strong></label>
              <input type="text" id="denda" value="Rp 0" class="form-control" readonly>
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

<!-- ====== SCRIPT PERHITUNGAN OTOMATIS & TAMBAH/HAPUS BUKU ====== -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const today = new Date();
  const tglPinjamInput = document.getElementById('tanggal_pinjam');
  const tglKembaliInput = document.getElementById('tanggal_kembali');
  const durasiInput = document.getElementById('durasi');
  const dendaInput = document.getElementById('denda');

  // Set tanggal pinjam hari ini
  const todayStr = today.toISOString().split('T')[0];
  tglPinjamInput.value = todayStr;

  // Durasi 6 hari
  const durasiHari = 6;
  const tglKembali = new Date(today);
  tglKembali.setDate(tglKembali.getDate() + durasiHari);
  tglKembaliInput.value = tglKembali.toISOString().split('T')[0];
  durasiInput.value = durasiHari + " hari";

  // Simulasi perhitungan denda
  const inputTanggalAktual = document.createElement("input");
  inputTanggalAktual.type = "date";
  inputTanggalAktual.id = "tanggal_pengembalian_aktual";
  inputTanggalAktual.classList.add("form-control", "mt-2");
  inputTanggalAktual.placeholder = "Masukkan tanggal pengembalian aktual (simulasi)";
  tglKembaliInput.parentNode.appendChild(inputTanggalAktual);

  inputTanggalAktual.addEventListener("change", function() {
    const tglAktual = new Date(this.value);
    const tglBatas = new Date(tglKembaliInput.value);
    const selisihHari = Math.ceil((tglAktual - tglBatas) / (1000 * 60 * 60 * 24));
    dendaInput.value = selisihHari > 0 ? "Rp " + (selisihHari * 1000).toLocaleString("id-ID") : "Rp 0";
  });

  // Tambah & hapus buku
  document.getElementById('btnTambahBuku').addEventListener('click', function() {
    const daftar = document.getElementById('daftarBuku');
    const newItem = daftar.querySelector('.buku-item').cloneNode(true);
    newItem.querySelectorAll('input').forEach(i => i.value = '');
    newItem.querySelector('select').selectedIndex = 0;
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