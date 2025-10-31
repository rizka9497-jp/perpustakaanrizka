<?php
?>

<!-- ====== HEADER HALAMAN ====== -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Peminjam</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Data Peminjam</li>
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
        <h5 class="m-0"><i class="fas fa-users me-2"></i> Daftar Peminjam</h5>
        <a href="index.php?halaman=tambahpeminjam" class="btn btn-light btn-sm">
          <i class="fas fa-plus"></i> Tambah Peminjam
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
              <th>Nama Peminjam</th>
              <th>Alamat</th>
              <th>No. Telepon</th>
              <th>Foto</th>
              <th style="width: 100px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            $sql = mysqli_query($koneksi, "SELECT * FROM peminjam ORDER BY idpeminjam DESC");

            while ($data = mysqli_fetch_assoc($sql)) {
              $idpeminjam = $data['idpeminjam'];

              // Ambil data aman
              $nama   = $data['namapeminjam'] ?? $data['nama'] ?? '<i>Tidak ada</i>';
              $alamat = $data['alamat'] ?? '<i>Tidak ada</i>';
              $nohp   = $data['notelpon'] ?? $data['nohp'] ?? '<i>Tidak ada</i>';

              // Cek foto
              $fotoPath = 'foto/fotopeminjam/' . ($data['foto'] ?? '');
              $foto = (!empty($data['foto']) && file_exists($fotoPath))
                ? "<img src='$fotoPath' width='60' height='60' class='rounded border'>"
                : "<span class='text-muted'>Tidak ada</span>";

              echo "
              <tr>
                <td class='text-center'>$no</td>
                <td>$nama</td>
                <td>$alamat</td>
                <td class='text-center'>$nohp</td>
                <td class='text-center'>$foto</td>
                <td class='text-center'>
                  <a href='index.php?halaman=editpeminjam&idpeminjam=$idpeminjam' class='btn btn-sm btn-warning'>
                    <i class='fa fa-edit'></i>
                  </a>
                  <a href='db/dbpeminjam.php?proses=hapus&idpeminjam=$idpeminjam' 
                     class='btn btn-sm btn-danger' 
                     onclick=\"return confirm('Yakin ingin menghapus data peminjam ini?');\">
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
      <i class="fas fa-info-circle me-1"></i> Pastikan data peminjam sudah lengkap dan benar.
    </div>
  </div>
</section>
