<?php
// PERHATIAN: Sesuaikan path include "../koneksi.php" berdasarkan lokasi file ini.
// Karena file ini ada di 'views/admin/buku/editbuku.php' (asumsi), maka path yang benar adalah:
include __DIR__. '/../../koneksi.php'; 

// Ambil ID buku dari URL secara aman
// Perhatikan, link dari halaman buku.php menggunakan parameter 'idbuku'
$idbuku = $_GET['idbuku'] ?? null;

// Jika idbuku tidak ada di URL, hentikan dengan pesan
if (!$idbuku) {
    echo "<p style='color:red;'>ID Buku tidak ditemukan di URL.</p>";
    exit;
}

// 1. Ambil data BUKU dari database
$queryBuku = "SELECT * FROM buku WHERE idbuku = '$idbuku'";
$resultBuku = mysqli_query($koneksi, $queryBuku);
$buku = mysqli_fetch_assoc($resultBuku);

// Jika data buku tidak ditemukan
if (!$buku) {
    echo "<p style='color:red;'>Data buku dengan ID $idbuku tidak ditemukan di database.</p>";
    exit;
}

// 2. Ambil data KATEGORI untuk dropdown
$queryKategori = "SELECT idkategori, namakategori FROM kategori ORDER BY namakategori ASC";
$resultKategori = mysqli_query($koneksi, $queryKategori);

// 3. Ambil data RAK untuk dropdown
$queryRak = "SELECT Idrak, Namarak FROM rak ORDER BY Namarak ASC";
$resultRak = mysqli_query($koneksi, $queryRak);
?>

<section class="content">

    <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary">
            <h3 class="card-title text-white">Edit Data Buku: <?= htmlspecialchars($buku['judul'] ?? 'N/A') ?></h3>
        </div>

        <form action="db/dbbuku.php?proses=edit" method="post" enctype="multipart/form-data">
            <div class="card-body">

                <input type="hidden" name="idbuku" value="<?= htmlspecialchars($buku['idbuku'] ?? '') ?>">

                <div class="form-group mb-3">
                    <label for="judul" class="font-weight-bold">Judul Buku</label>
                    <input type="text" class="form-control" id="judul" name="judul"
                        value="<?= htmlspecialchars($buku['judul'] ?? '') ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="pengarang" class="font-weight-bold">Pengarang</label>
                    <input type="text" class="form-control" id="pengarang" name="pengarang"
                        value="<?= htmlspecialchars($buku['pengarang'] ?? '') ?>" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="tahun_terbit" class="font-weight-bold">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit"
                            value="<?= htmlspecialchars($buku['tahun_terbit'] ?? '') ?>" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="stok" class="font-weight-bold">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok"
                            value="<?= htmlspecialchars($buku['stok'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="idkategori" class="font-weight-bold">Kategori</label>
                        <select class="form-control" id="idkategori" name="idkategori" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php while ($kategori = mysqli_fetch_assoc($resultKategori)): ?>
                                <option value="<?= $kategori['idkategori'] ?>" 
                                    <?= ($kategori['idkategori'] == $buku['idkategori']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($kategori['namakategori']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="idrak" class="font-weight-bold">Rak (Opsional)</label>
                        <select class="form-control" id="idrak" name="idrak">
                            <option value="">-- Pilih Rak --</option>
                            <?php while ($rak = mysqli_fetch_assoc($resultRak)): ?>
                                <option value="<?= $rak['Idrak'] ?>" 
                                    <?= ($rak['Idrak'] == $buku['idrak']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($rak['Namarak']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group mb-4">
                    <label for="foto" class="font-weight-bold">Ganti Foto Buku (Opsional)</label>
                    <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*">
                </div>

                <?php if (!empty($buku['foto'])): ?>
                    <div class="mb-3">
                        <label class="font-weight-bold">Foto lama:</label>
                        <img src="foto/buku/<?= htmlspecialchars($buku['foto']) ?>"
                            width="150" height="150" class="img-thumbnail" alt="Foto Buku Lama">
                    </div>
                <?php endif; ?>

            </div>

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="index.php?halaman=buku" class="btn btn-secondary ml-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>

    </div>
</section>