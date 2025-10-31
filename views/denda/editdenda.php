<?php
include "../../koneksi.php";

// Ambil ID denda dari URL
$iddenda = isset($_GET['iddenda']) ? $_GET['iddenda'] : '';
$iddenda = mysqli_real_escape_string($koneksi, $iddenda);

// Ambil data denda dari database
$query = mysqli_query($koneksi, "SELECT * FROM denda WHERE iddenda = '$iddenda'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>
            alert('Data denda tidak ditemukan!');
            window.location.href='denda.php';
          </script>";
    exit;
}
?>

<!-- ===========================
🟡 FORM EDIT DENDA
=========================== -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Denda</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="../../index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="denda.php">Denda</a></li>
          <li class="breadcrumb-item active">Edit Denda</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ===========================
📋 FORM EDIT DATA DENDA
=========================== -->
<section class="content">
  <div class="card">
    <div class="card-header bg-warning">
      <h3 class="card-title"><i class="fas fa-edit"></i> Form Edit Denda</h3>
    </div>

    <form action="../../db/dbdenda.php?proses=editdenda" method="POST">
      <div class="card-body">
        <!-- ID denda -->
        <input type="hidden" name="iddenda" value="<?= $data['iddenda']; ?>">

        <!-- Jumlah Denda -->
        <div class="form-group">
          <label>Jumlah Denda</label>
          <input type="number" name="jumlahdenda" class="form-control" 
                 value="<?= $data['jumlahdenda']; ?>" required>
        </div>

        <!-- Status Pembayaran -->
        <div class="form-group">
          <label>Status Pembayaran</label>
          <select name="statuspembayaran" class="form-control" required>
            <option value="Lunas" <?= ($data['statuspembayaran'] == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
            <option value="Belum Lunas" <?= ($data['statuspembayaran'] == 'Belum Lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
          </select>
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Simpan Perubahan</button>
        <a href="denda.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
      </div>
    </form>
  </div>
</section>
