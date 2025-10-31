<?php
?>
<!-- ===========================
📘 HALAMAN DATA DENDA
=========================== -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Denda</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="../../index.php">Home</a></li>
          <li class="breadcrumb-item active">Denda</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ===========================
📋 TABEL DATA DENDA
=========================== -->
<section class="content">
  <div class="card">
    <div class="card-header bg-primary">
      <h3 class="card-title">Daftar Denda</h3>
      <div class="card-tools">
        <button type="button" class="btn btn-light btn-sm" data-toggle="modal" data-target="#tambahDendaModal">
          <i class="fas fa-plus"></i> Tambah Denda
        </button>
      </div>
    </div>

    <div class="card-body">
      <table class="table table-bordered table-striped text-sm">
        <thead class="thead-dark">
          <tr class="text-center">
            <th width="10%">No</th>
            <th>Jumlah Denda</th>
            <th>Status Pembayaran</th>
            <th width="20%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          $query = mysqli_query($koneksi, "SELECT * FROM denda ORDER BY iddenda DESC");
          while ($row = mysqli_fetch_assoc($query)) :
          ?>
            <tr class="text-center">
              <td><?= $no++; ?></td>
              <td>Rp<?= number_format($row['jumlahdenda'], 0, ',', '.'); ?></td>
              <td>
                <?php if ($row['statuspembayaran'] == 'Lunas') : ?>
                  <span class="badge badge-success">Lunas</span>
                <?php else : ?>
                  <span class="badge badge-warning">Belum Lunas</span>
                <?php endif; ?>
              </td>
              <td>
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editDendaModal<?= $row['iddenda']; ?>">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <a href="../../db/dbdenda.php?proses=hapus&iddenda=<?= $row['iddenda']; ?>" 
                   class="btn btn-danger btn-sm" 
                   onclick="return confirm('Yakin ingin menghapus data ini?')">
                  <i class="fas fa-trash"></i> Hapus
                </a>
              </td>
            </tr>

            <!-- ===========================
            🔧 MODAL EDIT DENDA
            =========================== -->
            <div class="modal fade" id="editDendaModal<?= $row['iddenda']; ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="="index.php?halaman=editdenda" method="POST">
                    <div class="modal-header bg-warning">
                      <h5 class="modal-title">Edit Denda</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="iddenda" value="<?= $row['iddenda']; ?>">
                      <div class="form-group">
                        <label>Jumlah Denda</label>
                        <input type="number" name="jumlahdenda" value="<?= $row['jumlahdenda']; ?>" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <label>Status Pembayaran</label>
                        <select name="statuspembayaran" class="form-control" required>
                          <option value="Lunas" <?= ($row['statuspembayaran'] == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
                          <option value="Belum Lunas" <?= ($row['statuspembayaran'] == 'Belum Lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
                        </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- ===========================
🟢 MODAL TAMBAH DENDA
=========================== -->
<div class="modal fade" id="tambahDendaModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="http://localhost/rizkaaulia/11pertemuan29/index.php?halaman=tambahdenda" method="POST">
        <div class="modal-header bg-primary">
          <h5 class="modal-title">Tambah Denda</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Jumlah Denda</label>
            <input type="number" name="jumlahdenda" class="form-control" placeholder="Masukkan jumlah denda" required>
          </div>
          <div class="form-group">
            <label>Status Pembayaran</label>
            <select name="statuspembayaran" class="form-control" required>
              <option value="">-- Pilih Status --</option>
              <option value="Lunas">Lunas</option>
              <option value="Belum Lunas">Belum Lunas</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
