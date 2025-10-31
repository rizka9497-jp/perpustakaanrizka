<?php
// PASTIKAN BARIS INI ADALAH BARIS PERTAMA.
// TIDAK ADA SPASI ATAU BARIS KOSONG DI ATASNYA.

// =======================================================
// 1. Inisialisasi Sesi dan Koneksi
// =======================================================
if (session_status() == PHP_SESSION_NONE) {
   
}

// Ambil ID Peminjaman dari POST
$idpeminjaman = $_POST['idpeminjaman'] ?? '';

if (empty($idpeminjaman)) {
    $_SESSION['pesan_error'] = "ID Peminjaman tidak ditemukan untuk diedit.";
    header("Location: index.php?halaman=peminjaman");
    exit;
}

// Koneksi ke database
$koneksiPath = __DIR__ . '/../../koneksi.php'; 
if (!file_exists($koneksiPath)) {
    die("Koneksi database tidak ditemukan: " . $koneksiPath);
}
require_once $koneksiPath;

// Pastikan variabel $koneksi tersedia
if (!isset($koneksi) || !$koneksi || $koneksi->connect_error) {
     die("Koneksi database gagal setelah require: " . mysqli_connect_error());
}


// =======================================================
// 2. Ambil Data Peminjaman saat ini
// =======================================================
try {
    $stmt_data = $koneksi->prepare("
        SELECT p.*, pm.namapeminjam, a.nama AS namaadmin
        FROM peminjaman p
        LEFT JOIN peminjam pm ON p.idpeminjam = pm.idpeminjam
        LEFT JOIN admin a ON p.idadmin = a.idadmin
        WHERE p.idpeminjaman = ?
    ");
    $stmt_data->bind_param("s", $idpeminjaman);
    $stmt_data->execute();
    $result_data = $stmt_data->get_result();

    if ($result_data->num_rows === 0) {
        $_SESSION['pesan_error'] = "Data peminjaman dengan ID " . htmlspecialchars($idpeminjaman) . " tidak ditemukan.";
        header("Location: index.php?halaman=datapeminjaman");
        exit;
    }
    $data = $result_data->fetch_assoc();
    $stmt_data->close();
} catch (Exception $e) {
    $_SESSION['pesan_error'] = "Error mengambil data: " . $e->getMessage();
    header("Location: index.php?halaman=datapeminjaman");
    exit;
}


// =======================================================
// 3. Ambil List Peminjam dan Admin untuk Dropdown (SELECT)
// =======================================================
// Menggunakan mysqli_query biasa (tidak memerlukan prepared statement karena tidak ada input user)
$sql_peminjam = "SELECT idpeminjam, namapeminjam FROM peminjam ORDER BY namapeminjam";
$res_peminjam = mysqli_query($koneksi, $sql_peminjam);

$sql_admin = "SELECT idadmin, nama FROM admin ORDER BY nama";
$res_admin = mysqli_query($koneksi, $sql_admin);

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1><?php echo htmlspecialchars($idpeminjaman); ?>)</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card card-warning shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Formulir Edit Data</h3>
        </div>
        
        <form action="db/dbpeminjaman.php?proses=edit" method="POST">
            <div class="card-body">
                
                <input type="hidden" name="idpeminjaman" value="<?php echo htmlspecialchars($data['idpeminjaman']); ?>">

                <div class="form-group">
                    <label for="idpeminjam">Nama Peminjam</label>
                    <select class="form-control" id="idpeminjam" name="idpeminjam" required>
                        <?php 
                        if ($res_peminjam) {
                            while ($peminjam = mysqli_fetch_assoc($res_peminjam)) {
                                $selected = ($peminjam['idpeminjam'] == $data['idpeminjam']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($peminjam['idpeminjam']) . '" ' . $selected . '>' . htmlspecialchars($peminjam['namapeminjam']) . '</option>';
                            }
                        } else {
                            echo '<option value="" disabled>Gagal memuat data Peminjam</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="idadmin">Nama Admin</label>
                    <select class="form-control" id="idadmin" name="idadmin" required>
                        <?php 
                        if ($res_admin) {
                            while ($admin = mysqli_fetch_assoc($res_admin)) {
                                $selected = ($admin['idadmin'] == $data['idadmin']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($admin['idadmin']) . '" ' . $selected . '>' . htmlspecialchars($admin['nama']) . '</option>';
                            }
                        } else {
                             echo '<option value="" disabled>Gagal memuat data Admin</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tanggalpinjam">Tanggal Pinjam</label>
                    <input type="date" class="form-control" id="tanggalpinjam" name="tanggalpinjam" 
                           value="<?php echo htmlspecialchars($data['tanggalpinjam']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="tanggalkembali">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggalkembali" name="tanggalkembali" 
                           value="<?php echo htmlspecialchars($data['tanggalkembali']); ?>">
                    <small class="form-text text-muted">Kosongkan jika buku belum dikembalikan.</small>
                </div>

                <div class="form-group">
                    <label for="statuspeminjaman">Status Peminjaman</label>
                    <select class="form-control" id="statuspeminjaman" name="statuspeminjaman" required>
                        <?php 
                        $status_options = ['Dipinjam', 'Selesai'];
                        foreach ($status_options as $status) {
                            $selected = ($status == $data['statuspeminjaman']) ? 'selected' : '';
                            echo '<option value="' . $status . '" ' . $selected . '>' . $status . '</option>';
                        }
                        ?>
                    </select>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-1"></i> Simpan Perubahan
                </button>
                <a href="index.php?halaman=datapeminjaman" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
</section>