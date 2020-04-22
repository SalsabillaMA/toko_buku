<?php
// full php
include("config.php");
if (isset($_POST["save_customer"])) {
  // issets digunakan untuk mengecek apakah ketika mengakses file ini,
  // dikirimkan data dengan nama "save_customer" dg method post


   // tampung data yg dikirimkan
   $action = $_POST["action"];
   $id_customer = $_POST["id_customer"];
   $nama = $_POST["nama"];
   $alamat = $_POST["alamat"];
   $kontak = $_POST["kontak"];
   $username = $_POST["username"];
   $password = $_POST["password"];

   // load file config.php


   // cek aksinya
   if ($action == "insert") {
     // sintak untuk insert
     $sql = "insert into customer values('$id_customer','$nama','$alamat','$kontak','$username','$password')";

     // proses upload file
     // eksekusi perintah SQL-nya
     mysqli_query($connect, $sql);
   } elseif ($action == "update") {
       // sintak untuk update
       $sql = "update customer set nama='$nama', alamat='$alamat',
       kontak='$kontak', username='$username', password='$password' where id_customer='$id_customer'";

     // eksekusi perintah SQL-aksinya
     mysqli_query($connect, $sql);
   }
   // redirect ke halaman customer.php
   header("location:customer.php");
}

if (isset($_GET["hapus"])) {

  $id_customer = $_GET["id_customer"];
  $sql = "select * from customer where id_customer='$id_customer'";
  $query = mysqli_query($connect,$sql);
  $hasil = mysqli_fetch_array($query);
  $sql = "delete from customer where id_customer='$id_customer'";

  mysqli_query($connect, $sql);

  // direct ke halaman data Siswa
  header("location:customer.php");
}
 ?>
