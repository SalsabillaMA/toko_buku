<?php
// koneksi ke SQLiteDatabase
$host = "localhost"; // server local
$username = "root";
$password = "";
$db = "toko_buku";
$connect = mysqli_connect($host,$username,$password,$db);
// create utk membuat koneksi ke my sql


// cek koneksi SQLiteDatabase
if (mysqli_connect_errno()) {
  // menampilkan pesan error ketika koneksi gagal
  echo mysqli_connect_error();
}else {
  echo "Koneksi Berhasil";
}
 ?>
