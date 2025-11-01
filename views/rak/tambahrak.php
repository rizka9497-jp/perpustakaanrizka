<?php


// Query untuk mengambil data rak
$query = mysqli_query($koneksi, "SELECT * FROM rak ORDER BY Namarak ASC");

if (!$query) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<section class="content">

    <div class="card text-xs">
        <div class="card-header bg-primary">
            <h2 class="card-title">Tambah Rak</h2>
        </div>

        <div class="card-body">
            <div class="card card-warning">

                <form action="db/dbrak.php?proses=tambah" method="POST">
                    <div class="card-body-sm ml-2">
                        <div class="form-group">
                            <label for="Namarak">Nama Rak</label>
                            <input type="text" class="form-control" id="Namarak" name="Namarak"
                                placeholder="Masukkan nama rak" required>
                        </div>
                    </div>

                    <div class="card-footer-sm float-right">
                        <button type="reset" class="btn-sm btn-warning"><i class="fa fa-retweet"></i> Reset</button>
                        <button type="submit" class="btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-footer"></div>
    </div>

</section>