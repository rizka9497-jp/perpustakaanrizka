

<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    include 'koneksi.php'; // Pastikan koneksi database aktif di awal
    include 'pages/header.php';
?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <?php include 'pages/navbar.php'; ?>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <?php include 'pages/sidebar.php'; ?>
    </aside>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">dashboard v1</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <?php
        // Pastikan Anda memanggil koneksi di suatu tempat, idealnya di luar file ini atau di header/sidebar.
        // include 'koneksi.php'; 

        if (isset($_GET["halaman"])) {
          switch ($_GET["halaman"]) {
            // Bagian admin
            case "admin":
              include("views/admin/admin.php");
              break;
            case "tambahadmin":
              include("views/admin/tambahadmin.php");
              break;
            case "editadmin":
              include("views/admin/editadmin.php");
              break;

            // Bagian peminjam
            case "peminjam":
              include("views/peminjam/peminjam.php");
              break;
            case "tambahpeminjam":
              include("views/peminjam/tambahpeminjam.php");
              break;
            case "editpeminjam":
              include("views/peminjam/editpeminjam.php");
              break;
            // Bagian buku
            case "buku":
              include("views/buku/buku.php");
              break;
            case "tambahbuku":
              include("views/buku/tambahbuku.php"); 
              break;
            case "editbuku":
              include("views/buku/editbuku.php");
              break;
            case "editbuku":
              include("views/buku/koneksi.php");
              break;
            // Halaman Umum 
            case "home":
            case "dashboard":
              include("views/dashboard.php");
              break;

            // Default
            case "default":
              include("views/notfound.php");
              break;
            default:
              include("views/notfound.php"); // Menambahkan default case yang lebih aman
          }
        } else {
          // Jika tidak ada parameter halaman, tampilkan dashboard sebagai default
          include("views/dashboard.php");
        }
        ?>
      </section>
    </div>
    <footer class="main-footer">
      <?php include 'pages/footer.php'; ?>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/chart.js/Chart.min.js"></script>
  <script src="plugins/sparklines/sparkline.js"></script>
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/adminlte.js"></script>
  <script src="dist/js/demo.js"></script>
  <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>