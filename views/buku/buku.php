<?php
include "koneksi.php";
?>

<!-- ====== HEADER HALAMAN ====== -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Buku</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Data Buku</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ====== ISI HALAMAN ====== -->
<section class="content">
  <div class="card shadow-sm border-0">

    <!-- Header -->
    <div class="card-header bg-gradient-primary text-white">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="m-0"><i class="fas fa-book me-2"></i> Daftar Buku</h5>
        <a href="index.php?halaman=tambahbuku" class="btn btn-light btn-sm">
          <i class="fas fa-plus"></i> Tambah Buku
        </a>
      </div>
    </div>

    <!-- Tabel -->
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover text-sm align-middle mb-0">
          <thead class="table-primary text-center">
            <tr>
              <th style="width: 40px;">No</th>
              <th>Judul</th>
              <th>Pengarang</th>
              <th>Tahun Terbit</th>
              <th>Stok</th>
              <th>Kategori</th>
              <th>Rak</th>
              <th>Foto</th>
              <th style="width: 100px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = mysqli_query($koneksi, "
              SELECT b.*, k.namakategori, r.Namarak
              FROM buku b
              LEFT JOIN kategori k ON b.idkategori = k.idkategori
              LEFT JOIN rak r ON b.idrak = r.idrak
              ORDER BY b.idbuku DESC
            ");

            while ($data = mysqli_fetch_array($sql)) {
              // Cek foto buku
              $fotoPath = 'foto/fotobuku/' . $data['foto'];
              $foto = (!empty($data['foto']) && file_exists($fotoPath))
                ? "<img src='$fotoPath' width='60' height='60' class='rounded border'>"
                : "<span class='text-muted'>Tidak ada</span>";

              echo "
              <tr>
                <td class='text-center'>$no</td>
                <td>{$data['judul']}</td>
                <td>{$data['pengarang']}</td>
                <td class='text-center'>{$data['tahun_terbit']}</td>
                <td class='text-center'>{$data['stok']}</td>
                <td>{$data['namakategori']}</td>
                <td>{$data['Namarak']}</td>
                <td class='text-center'>$foto</td>
                <td class='text-center'>
                  <a href='index.php?halaman=editbuku&idbuku={$data['idbuku']}' class='btn btn-sm btn-warning'>
                    <i class='fa fa-edit'></i>
                  </a>
                  <a href='db/dbbuku.php?proses=hapus&idbuku={$data['idbuku']}' 
                     class='btn btn-sm btn-danger' 
                     onclick=\"return confirm('Yakin ingin menghapus buku ini?');\">
                    <i class='fa fa-trash'></i>
                  </a>
                </td>
              </tr>";
              $no++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Footer -->
    <div class="card-footer text-muted text-sm text-center">
      <i class="fas fa-info-circle me-1"></i> Daftar semua buku yang tersimpan di sistem.
    </div>
  </div>
</section>
