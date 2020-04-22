<?php
// load file config.php
include("config.php");
// full php
if (isset($_POST["save_buku"])) {
  // issets digunakan untuk mengecek apakah ketika mengakses file ini,
  // dikirimkan data dengan nama "save_buku" dg method post


   // tampung data yg dikirimkan
   $action = $_POST["action"];
   $kode_buku = $_POST["kode_buku"];
   $judul = $_POST["judul"];
   $penulis = $_POST["penulis"];
   $tahun = $_POST["tahun"];
   $harga = $_POST["harga"];
   $stok = $_POST["stok"];
   // menampung file image
   if (!empty($_FILES["image"]["name"])) {
     // mendapatkan deskripsi info gambar
     $path = pathinfo($_FILES["image"]["name"]);
     // mengambil ekstensi gambar
     $extension = $path["extension"];

     // rangkai file name-aksinya
     $filename = $kode_buku."-".rand(1,1000).".".$extension;
     // general nama file
     // exp: 111-989.JPG
     // rand() random nilai dari 1 - 1000
   }



   // cek aksinya
   if ($action == "insert") {
     // sintak untuk insert
     $sql = "insert into buku values('$kode_buku','$judul','$penulis','$tahun','$harga','$stok','$filename')";

     // proses upload file
     move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");
     //  image itu nama folder yg dibuat
     // eksekusi perintah SQL-nya
     mysqli_query($connect, $sql);
   } elseif ($action == "update") {
     if (!empty($_FILES["image"]["name"])) {
       // mendapatkan deskripsi info gambar
       $path = pathinfo($_FILES["image"]["name"]);
       // mengambil ekstensi gambar
       $extension = $path["extension"];

       // rangkai file name-aksinya
       $filename = $kode_buku."-".rand(1,1000).".".$extension;
       // general nama file
       // exp: 111-989.JPG
       // rand() random nilai dari 1 - 1000

       //  ambil data yang akan diedit
       $sql = "select * from buku where kode_buku='$kode_buku'";
       $query = mysqli_query($connect,$sql);
       $hasil = mysqli_fetch_array($query);

       if (file_exists("image/".$hasil["image"])) {
         unlink("image/".$hasil["image"]);
         // menghapus gambar yang terdahulu
       }

       // upload gambar
       move_uploaded_file($_FILES["image"]["tmp_name"],"image/$filename");

       // sintak untuk update
       $sql = "update buku set judul='$judul',
       penulis='$penulis',tahun='$tahun',harga='$harga',stok='$stok',image='$filename' where kode_buku='$kode_buku'";
     } else {
       // sintak untuk update
       $sql = "update buku set judul='$judul',
       penulis='$penulis',tahun='$tahun',harga='$harga',stok='$stok' where kode_buku='$kode_buku'";
     }

     // eksekusi perintah SQL-aksinya
     mysqli_query($connect, $sql);
   }
   // redirect ke halaman siswa.php
   header("location:buku.php");
}

if (isset($_GET["hapus"])) {
  include("config.php");
  $kode_buku = $_GET["kode_buku"];
  $sql = "select * from buku where kode_buku='$kode_buku'";
  $query = mysqli_query($connect,$sql);
  $hasil = mysqli_fetch_array($query);
  if (file_exists("image/".$hasil["image"])) {
    unlink("image/".$hasil["image"]);
  }
  $sql = "delete from buku where kode_buku='$kode_buku'";

  mysqli_query($connect, $sql);

  // direct ke halaman data Siswa
  header("location:buku.php");
}
 ?>
