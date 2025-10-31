<?php
// Pastikan koneksi.php sudah terinclude

// ===================================================
// 💡 LOGIKA PEMROSESAN DATA FORM DENDA
// ===================================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil data dari $_POST
    $jumlahdenda = $_POST['jumlahdenda'];
    $statuspembayaran = $_POST['statuspembayaran'];
    
    // 2. Query SQL untuk menyimpan data
    // ASUMSI: Nama tabel denda adalah 'denda' dan kolomnya adalah 'jumlah_denda' dan 'status_pembayaran'
    $sql = "INSERT INTO denda (jumlah_denda, status_pembayaran) VALUES ('$jumlahdenda', '$statuspembayaran')";
    
    // 3. Eksekusi Query
    if (mysqli_query($koneksi, $sql)) {
        // Setelah sukses, redirect ke halaman denda (menggunakan router index.php)
        // Pemberitahuan sukses bisa ditambahkan melalui session sebelum redirect
        header("Location: ../../index.php?halaman=tambahdenda&pesan=sukses_tambah");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error atau redirect dengan pesan gagal
        // echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        header("Location: ../../index.php?halaman=tambahdenda&pesan=gagal_tambah");
        exit();
    }
}

// Catatan: Pastikan variabel $koneksi tersedia dari file koneksi.php
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Tambah Denda</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="../../index.php?halaman=tamabahdenda">Denda</a></li>
          <li class="breadcrumb-item active">Tambah Denda</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<form action="" method="POST"> 
  <div class="card-body">

    <div class="form-group">
      <label for="jumlahdenda">Jumlah Denda (Rp)</label>
      <input type="number" class="form-control" name="jumlahdenda" id="jumlahdenda" required>
    </div>

    <div class="form-group">
      <label for="statuspembayaran">Status Pembayaran</label>
      <select class="form-control" name="statuspembayaran" id="statuspembayaran" required>
        <option value="">-- Pilih Status --</option>
        <option value="Belum Lunas">Belum Lunas</option>
        <option value="Lunas">Lunas</option>
      </select>
    </div>

  </div>

  <div class="card-footer">
    <button type="submit" class="btn btn-success">
      <i class="fas fa-save"></i> Simpan
    </button>
        <a href="../../index.php?halaman=tambahdenda" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>
</form>