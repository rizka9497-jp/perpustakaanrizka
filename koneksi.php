<?php
$server = "localhost";
$user   = "root";
$pass   = "";
$db     = "perpustakaanrizka";

// Membuat koneksi
$koneksi = mysqli_connect($server, $user, $pass, $db);

// Mengecek koneksi
if (!$koneksi) {
  
}
// else {
//     echo "Koneksi berhasil!";
// }
?>