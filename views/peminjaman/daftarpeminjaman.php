<?php
// =======================================================================
// PENGATURAN ERROR DAN KONEKSI
// =======================================================================
// Pastikan koneksi database ($koneksi) sudah di-include/didefinisikan sebelum file ini.
// Contoh: include '../../koneksi.php'; 

// Jika $koneksi belum ada, tambahkan baris berikut (sesuaikan path)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// =======================================================================
// FUNGSI BANTUAN
// =======================================================================
// Fungsi untuk format Rupiah (optional, tapi bagus untuk tampilan)
if (!function_exists('formatRupiah')) {
    function formatRupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}
$no = 1;

// =======================================================================
// 1. KUERI DATA UTAMA (Peminjaman, Peminjam, Admin)
// =======================================================================

$query = mysqli_query($koneksi, "
    SELECT 
        p.idpeminjaman,
        pm.namapeminjam,
        a.nama AS namaadmin, -- Menggunakan 'nama' dari tabel admin
        MIN(dp.tanggalpinjam) AS tanggalpinjam,
        MAX(dp.tanggalkembali) AS tanggalkembali,
        -- Menghitung total denda yang terkait dengan peminjaman ini
        COALESCE(SUM(d.jumlahdenda), 0) AS total_denda
    FROM peminjaman p
    JOIN peminjam pm ON p.idpeminjam = pm.idpeminjam
    JOIN admin a ON p.idadmin = a.idadmin
    JOIN detailpeminjaman dp ON p.idpeminjaman = dp.idpeminjaman
    LEFT JOIN denda d ON dp.iddenda = d.iddenda -- LEFT JOIN ke denda untuk menghitung total
    GROUP BY p.idpeminjaman, pm.namapeminjam, a.nama
    ORDER BY p.idpeminjaman DESC
");

// Periksa jika query gagal, untuk menghindari error PHP
if (!$query) {
    echo "<div class='alert alert-danger'>Kesalahan Query Data Utama: " . mysqli_error($koneksi) . "</div>";
    // Hentikan eksekusi script agar tidak menampilkan tabel kosong
    // exit;
}
?>

<!-- Daftar Peminjaman -->
<div class="card card-solid">
    <div class="card-header">
        <h3 class="card-title">Daftar Peminjaman buku</h3>
        <a href="index.php?halaman=tambahpeminjaman" class="btn btn-primary btn-sm float-right">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Peminjam</th>
                        <!-- Kolom Asal dihapus karena tidak ada di ERD Peminjam -->
                        <th>Admin</th>
                        <th>buku yang Dipinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Total Denda</th>
                        <th>Tunggakan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Pastikan $query berhasil sebelum melakukan perulangan
                    if (isset($query) && mysqli_num_rows($query) > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                            $idpeminjaman = $data['idpeminjaman'];
                            $total_denda = (float)$data['total_denda'];
                            // Asumsi sederhana: Tunggakan = Total Denda (belum ada tabel Pembayaran Denda)
                            $tunggakan = $total_denda; 

                            // =======================================================================
                            // 2. KUERI NESTED: Ambil daftar Alat yang Dipinjam
                            // =======================================================================
                            $alatList = [];
                            $qAlat = mysqli_query($koneksi, "
                                SELECT b.judul 
                                FROM detailpeminjaman dp
                                JOIN buku b ON dp.idbuku = b.idbuku -- Ganti 'buku' dengan 'alat' jika Anda punya tabel 'alat'
                                WHERE dp.idpeminjaman = '$idpeminjaman'
                            ");
                            
                            // Periksa apakah query alat gagal
                            if (!$qAlat) {
                                $alatList[] = "Error Query Alat: " . mysqli_error($koneksi);
                            } else {
                                while ($rowAlat = mysqli_fetch_assoc($qAlat)) {
                                    // Menggunakan 'judul' (dari tabel buku) sebagai representasi nama alat/barang
                                    $alatList[] = htmlspecialchars($rowAlat['judul']);
                                }
                            }
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($data['namapeminjam']) ?></td>
                                <td><?= htmlspecialchars($data['namaadmin']) ?></td>
                                <td><?= implode(", ", $alatList) ?></td>
                                <td><?= date('d-m-Y', strtotime($data['tanggalpinjam'])) ?></td>
                                <td><?= date('d-m-Y', strtotime($data['tanggalkembali'])) ?></td>
                                
                                <td class="<?php echo ($total_denda > 0) ? 'text-danger font-weight-bold' : ''; ?>">
                                    <?= formatRupiah($total_denda) ?>
                                </td>
                                
                                <td>
                                    <?php if ($tunggakan > 0): ?>
                                        <span class="badge badge-danger"><?= formatRupiah($tunggakan) ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Rp 0</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-nowrap">
                                    <!-- Detail -->
                                    <a href="index.php?halaman=detilpeminjaman&idpeminjaman=<?= $idpeminjaman ?>" class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Proses Pengembalian -->
                                    <a href="index.php?halaman=prosespengembalian&idpeminjaman=<?= $idpeminjaman ?>" class="btn btn-success btn-sm" title="Kembali">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                    <!-- Edit -->
                                    <a href="index.php?halaman=editpeminjaman&idpeminjaman=<?= $idpeminjaman ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Lunasi Denda (Hanya Tampilkan jika ada tunggakan) -->
                                    <?php if ($tunggakan > 0): ?>
                                    <a href="index.php?halaman=lunasi_denda&idpeminjaman=<?= $idpeminjaman ?>" class="btn btn-danger btn-sm" title="Lunasi">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data peminjaman yang ditemukan.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>