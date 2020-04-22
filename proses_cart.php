<?php
session_start();
include("config.php");
// menambah barang ke cart
if (isset($_POST["add_to_cart"])) {
  // tampung kode_buku dan jumlah jumlah_beli
  $kode_buku = $_POST["kode_buku"];
  $jumlah_beli = $_POST["jumlah_beli"];

  // kita ambil data buku dari database sesuai dengan kode buku yg dipilih
  $sql = "select * from buku where kode_buku='$kode_buku'";
  $query = mysqli_query($connect, $sql); // eksekusi sintak sqlnya
  $buku = mysqli_fetch_array($query); // menampung data dari database ke array

  $item = [
    "kode_buku" => $buku["kode_buku"],
    "judul" => $buku["judul"],
    "image" => $buku["image"],
    "harga" => $buku["harga"],
    "jumlah_beli" => $jumlah_beli
  ];

  // memasukkan item kr keranjang Cart
  array_push($_SESSION["cart"], $item);

  header("location:tampilancustomer.php");
}
// menghapus item pada Cart
if (isset($_GET["hapus"])) {
  // tampung data kode_buku yg dihapus
  $kode_buku = $_GET["kode_buku"];

  // cari index cart sesuai dg kode_buku yg dihapus
  $index = array_search(
    $kode_buku, array_column(
      $_SESSION["cart"],"kode_buku"
      )
  );
  // hapus item pada Cart
  array_splice($_SESSION["cart"], $index, 1);
  header("location:cart.php");
}

// checkout
if (isset($_GET["checkout"])) {
  // memasukkan data pada cart ke database (tabel transaksi dan detail transaksi)
  // transaksi => id_transaksi, tgl, id_customer
  //  detail => id_transaksi, kode_buku, jumlah, harga_beli

  $id_transaksi = "ID".rand(1,10000); // rand itu buat ngerandom 1 - 10000
  $tgl = date("Y-m-d H:i:s"); // current time
  // Y = year, m = month, d = day, H= hours, i = minute, s = second
  $id_customer = $_SESSION["id_customer"];

  // buat $query
  $sql = "insert into transaksi values ('$id_transaksi','$tgl',$id_customer)";
  mysqli_query($connect, $sql); // eksekusi query

  foreach ($_SESSION["cart"] as $cart) {
    $kode_buku = $cart["kode_buku"];
    $jumlah = $cart["jumlah_beli"];
    $harga = $cart["harga"];

    // buat query insert ke tabel detail
    $sql = "insert into detail_transaksi values (
      '$id_transaksi','$kode_buku','$jumlah','$harga'
      )";
      mysqli_query($connect, $sql);

      $sql2 = "update buku set stok = stok - $jumlah where kode_buku='$kode_buku'";
      mysqli_query($connect, $sql2);
  }
  // kosongkan cart nya
  $_SESSION["cart"] = array();
  header("location:transaksi.php");
}
 ?>
