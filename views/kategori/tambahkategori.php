<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card text-xs">
    <div class="card-header bg-primary">
      <h2 class="card-title">Tambah Kategori</h2>
    </div>

    <div class="card-body">

      <!-- general form elements -->
      <div class="card card-warning">

        <!-- form start -->
        <form action="db/dbkategori.php?proses=tambah" method="POST" enctype="multipart/form-data">
          <div class="card-body-sm ml-2">
            <div class="form-group">
              <label for="namakategori">Nama Kategori</label>
              <input type="text" class="form-control" id="namakategori" name="namakategori" placeholder="Masukkan nama kategori" required>
            </div>
          </div>
          <!-- /.card-body -->

          <div class="card-footer-sm float-right">
            <button type="reset" class="btn-sm btn-warning"><i class="fa fa-retweet"></i> Reset</button>
            <button type="submit" class="btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
          </div>
        </form>
      </div>
      <!-- /.card -->

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
    </div>

  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
