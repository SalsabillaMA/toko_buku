<?php
session_start();
if (!isset($_SESSION["id_customer"])) {
  header("location:login_customer.php");
}
// memanggil file config.php agar tidak perlu membuat koneksi baru
include("config.php");
 ?>
 <!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width-device-width, initial-scale=1">
  <title>Toko Buku</title>
  <!-- Load bootstrap css -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="css-admin.css">
  <!-- load jquery and bootstrap js -->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script type="text/javascript">
    Detail = (item) => {
      document.getElementById('kode_buku').value = item.kode_buku;
      document.getElementById('judul').innerHTML = item.judul;
      document.getElementById('penulis').innerHTML = "Penulis : " + item.penulis;
      document.getElementById('tahun').innerHTML = "Tahun : " + item.tahun;
      document.getElementById('harga').innerHTML = "Harga : " + item.harga;
      document.getElementById('stok').innerHTML = "Stok : " +item.stok;
      document.getElementById("jumlah_beli").value = "1";
      document.getElementById("jumlah_beli").max = item.stok;

      document.getElementById("image").src = "image/" + item.image;
    }
  </script>

</head>
<body>
  <nav class="navbar-expand-md bg-light navbar-light fixed-top">
  <a href="#">
    <img src="b.png" width="100" align="left" alt="">
  </a>

<!-- pemanggilan icon menu saat menubar disembunyikan -->
<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#menu">
  <span class="navbar navbar-toggler-icon"></span>
</button>

<!-- daftar menu pada navbar -->
<div class="collapse navbar-collapse" id="menu">
  <ul class="navbar-nav">
    <li class="nav-item"><a href="tampilancustomer.php" class="nav-link h5 mt-1">Beranda</a></li>
    <li class="nav-item">
      <a href="cart.php" class="nav-link h5 mt-1">
        <img src="cart.png" width="30" align="left" alt="">
        (<?php echo count($_SESSION["cart"]); ?>)
      </a>
    </li>
    <li class="nav-item"><a href="transaksi.php" class="nav-link h5 mt-1">
      <img src="history.png" width="30" align="left" alt="">Transaksi</a></li>
      <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle h5 mt-1" data-toggle="dropdown">Contact</a>
        <div class="dropdown-menu">
          <a target="_blank" href="https://www.facebook.com/thebookshopwigtown/" class="dropdown-item"><img src="fb.png" width="45" align="left" alt=""></a>
          <a target="_blank"href="https://www.instagram.com/coconutbooks/?hl=id" class="dropdown-item"><img src="ig.png" width="45" align="left" alt=""></a>
          <a target="_blank"href="https://twitter.com/twitterbooks" class="dropdown-item"><img src="tw.png" width="45" align="left" alt=""></a>
          <a target="_blank"href="https://www.youtube.com/watch?v=SKVcQnyEIT8" class="dropdown-item"><img src="yt.png" width="45" align="left" alt=""></a>
      </div>
    </li>
  </ul>
    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <a href="proses_login_admin.php?logout=true" class="nav-link h5 mt-2" ><?php echo $_SESSION["nama"]; ?> <img src="logout.png" width="30" align="left" alt=""> </a>
    </li>
    </ul>
</div>
</nav>
<div class="container-fluid">
  <div class="row">
    <div class="headers col-12" id="#a">
      <h1>Book Store</h1>
      <h3>"Online Bookstore Web"</h3>
      <div class="row justify-content-center">

        <form class="col-sm-6" action="tampilancustomer.php" method="post">
          <input type="text" name="cari" class="form-control" style="opacity:0.7" placeholder="Pencarian...">
        </form>

      </div>
    </div>
  </div>
  <div class="tittle bg-light" align="center">
    <h2 style="color:#C98A6D;">Our Bookstore Menu</h2>
  </div>
  <div class="row my-3">
    <?php
    // membuat perintah sql utk menampilkan data siswa
    if (isset($_POST["cari"])) {
      // query jikka pencarian
      $cari = $_POST["cari"];
      $sql = " select * from buku where kode_buku like '%$cari%' or judul like '%$cari%'
      or penulis like '%$cari%' or tahun like '%$cari%' or harga like '%$cari%' or stok like '%$cari%'";
    }else {
      // query jika tidak mencari
      $sql = " select * from buku";
    }
    // eksekusi perintah sql nya
    $query = mysqli_query($connect, $sql);
  ?>

     <?php foreach ($query as $buku): ?>
       <!-- start card 1 -->
      <div class="card col-md-2  mb-2 bg-light" align="center">
        <img src="image/<?php echo $buku["image"]; ?>" class="card-img-top" height="250px">
        <div class="card-header bg-light" bg-info text-white>
          <!-- ini tempat judulnya -->
          <h4 class="text-dark"><?php echo $buku["judul"]; ?></h4>
        </div>
        <div class="card-body" align="center">
          <h5 class="text-success"><?php echo "Rp ".$buku["harga"]; ?></h5>
          <br>
          <h6 class="text-secondary"><?php echo "Penulis: ".$buku["penulis"]; ?></h6>
        </div>
        <div class="card-footer">
          <button type="button" class="btn btn-sm btn-secondary"
          onclick='Detail(<?php echo json_encode($buku); ?>)'
          data-toggle="modal" data-target="#modal_detail">Detail</button>
        </div>
      </div>
    <!-- end card 1 -->
     <?php endforeach; ?>
     <!-- modal1 -->
    <div class="modal fade" id="modal_detail">
      <div class="modal-dialog">
        <div class="modal-content">
           <div class="modal-header bg-dark">
             <h4 class="text-white">Detail Buku</h4>
           </div>
           <div class="modal-body">
             <div class="row">
               <div class="col-6" >
                 <!-- buat gb -->
                 <img id="image" style="width:100%; height: auto;">
               </div>
               <div class="col-6">
                 <!-- deskripsi -->
                 <h4 id="judul"></h4>
                 <h4 id="penulis"></h4>
                 <h4 id="tahun"></h4>
                 <h4 id="harga"></h4>
                 <h4 id="stok"></h4>

                 <form action="proses_cart.php" method="post">
                   <input type="hidden" name="kode_buku" id="kode_buku">
                   Jumlah beli
                   <input type="number" name="jumlah_beli" id="jumlah_beli"
                   class="form-control" min="1">
                   <br>
                   <button type="submit" name="add_to_cart" class="btn btn-success">
                   Tambah Ke Keranjang</button>
                 </form>
               </div>
             </div>
           </div>
        </div>
      </div>
    </div>
    <!-- end modal 1 -->
  </div>
</div>
<div class="col-12 footer bg-secondary text-white">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
  </body>
</html>
