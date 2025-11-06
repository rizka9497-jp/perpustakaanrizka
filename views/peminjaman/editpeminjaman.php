<?php
include "../koneksi.php";
session_start();

// Pastikan ada ID peminjaman yang dikirim
if (!isset($_GET['idpeminjaman'])) {
    echo "<script>alert('ID peminjaman tidak ditemukan!'); window.location='../index.php?halaman=daftarpeminjaman';</script>";
    exit;
}

$idpeminjaman = intval($_GET['idpeminjaman']);

// Ambil data peminjaman utama
$qPeminjaman = mysqli_query($koneksi, "
    SELECT * FROM peminjaman WHERE idpeminjaman='$idpeminjaman'
");
$data = mysqli_fetch_assoc($qPeminjaman);

// Ambil data peminjam dan buku untuk dropdown
$peminjam = mysqli_query($koneksi, "SELECT * FROM peminjam ORDER BY namapeminjam ASC");
$buku = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY judulbuku ASC");

// Ambil detail buku yang dipinjam
$detail = mysqli_query($koneksi, "
    SELECT dp.*, b.judulbuku 
    FROM detailpeminjaman dp
    JOIN buku b ON dp.idbuku = b.idbuku
    WHERE dp.idpeminjaman='$idpeminjaman'
");
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Peminjaman</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
          <li class="breadcrumb-item"><a href="../index.php?halaman=daftarpeminjaman">Daftar Peminjaman</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
<div class="container-fluid">
  <form action="../db/dbpeminjaman.php?proses=update" method="POST">
    <input type="hidden" name="idpeminjaman" value="<?= $data['idpeminjaman'] ?>">

    <div class="card">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title">Informasi Peminjaman</h3>
      </div>
      <div class="card-body">

        <div class="form-group">
          <label>Nama Peminjam</label>
          <select name="idpeminjam" class="form-control" required>
            <option value="">-- Pilih Peminjam --</option>
            <?php while ($pm = mysqli_fetch_assoc($peminjam)) { ?>
              <option value="<?= $pm['idpeminjam'] ?>" 
                <?= ($pm['idpeminjam'] == $data['idpeminjam']) ? 'selected' : '' ?>>
                <?= $pm['namapeminjam'] ?>
              </option>
            <?php } ?>
          </select>
        </div>

        <div class="form-group">
          <label>Tanggal Pinjam</label>
          <input type="date" name="tanggalpinjam" class="form-control" value="<?= $data['tanggalpinjam'] ?>" required>
        </div>

        <div class="form-group">
          <label>Tanggal Harus Kembali</label>
          <input type="date" name="tanggalharuskembali" class="form-control" value="<?= $data['tanggalharuskembali'] ?>" required>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header bg-success text-white">
        <h3 class="card-title">Daftar Buku yang Dipinjam</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered" id="tabelBuku">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Buku</th>
              <th>Jumlah</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; while ($d = mysqli_fetch_assoc($detail)) { ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <select name="idbuku[]" class="form-control" required>
                  <option value="">-- Pilih Buku --</option>
                  <?php 
                  mysqli_data_seek($buku, 0); // reset pointer
                  while ($bk = mysqli_fetch_assoc($buku)) { ?>
                    <option value="<?= $bk['idbuku'] ?>" 
                      <?= ($bk['idbuku'] == $d['idbuku']) ? 'selected' : '' ?>>
                      <?= $bk['judulbuku'] ?>
                    </option>
                  <?php } ?>
                </select>
              </td>
              <td><input type="number" name="jumlah[]" class="form-control" min="1" value="<?= $d['total'] ?>" required></td>
              <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">Hapus</button></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <button type="button" class="btn btn-info" onclick="tambahBaris()">+ Tambah Buku</button>
      </div>
    </div>

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="../index.php?halaman=daftarpeminjaman" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
</section>

<script>
function tambahBaris() {
  const table = document.getElementById("tabelBuku").getElementsByTagName('tbody')[0];
  const row = table.insertRow();
  row.innerHTML = `
    <td>#</td>
    <td>
      <select name="idbuku[]" class="form-control" required>
        <option value="">-- Pilih Buku --</option>
        <?php 
        $buku_reset = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY judulbuku ASC");
        while ($bk = mysqli_fetch_assoc($buku_reset)) { ?>
          <option value="<?= $bk['idbuku'] ?>"><?= $bk['judulbuku'] ?></option>
        <?php } ?>
      </select>
    </td>
    <td><input type="number" name="jumlah[]" class="form-control" min="1" required></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">Hapus</button></td>
  `;
}

function hapusBaris(btn) {
  btn.closest('tr').remove();
}
</script>
