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

<div class="transaksi">
<div class="container col-10">
  <br>
  <br>
  <div class="card mt-3">
    <div class="card header bg-secondary">
      <h4 class="text-white" align="center">Riwayat Transaksi</h4>
    </div>
    <div class="card-body">
      <?php
      $sql = "select * from transaksi t inner join customer c on t.id_customer = c.id_customer
      where t.id_customer = '".$_SESSION["id_customer"]."' order by t.tgl desc";
      // pake customer biar namanya muncul ada titiknya krn buat menyambungkan string
      // dan string lain
      $query = mysqli_query($connect, $sql);
       ?>


       <ul class="list-group">
         <?php foreach ($query as $transaksi): ?>
           <li class="list-group-item mb-4">
           <h6>ID Transaksi: <?php echo $transaksi["id_transaksi"]; ?></h6>
           <h6>Nama Pembeli: <?php echo $transaksi["nama"]; ?></h6>
           <h6>Tgl.Transaksi: <?php echo $transaksi["tgl"]; ?></h6>
           <h6>List Barang :</h6>

           <?php
           $sql2 = "select * from detail_transaksi d inner join buku b
           on d.kode_buku = b.kode_buku
           where d.id_transaksi='".$transaksi["id_transaksi"]."'";
           $query2 = mysqli_query($connect, $sql2);
           ?>

           <table class="table table-borderless">
             <thead>
               <tr>
                 <th>Judul</th>
                 <th>Jumlah</th>
                 <th>Harga</th>
                 <th>Total</th>
               </tr>
             </thead>
             <tbody>
               <?php $total = 0; foreach ($query2 as $detail): ?>
                 <tr>
                   <td><?php echo $detail["judul"]; ?></td>
                   <td><?php echo $detail["jumlah"]; ?></td>
                   <td>Rp <?php echo number_format($detail["harga_beli"]); ?></td>
                   <td>
                     Rp <?php echo number_format($detail["harga_beli"]*$detail["jumlah"]); ?>
                   </td>
                 </tr>
               <?php
               $total += ($detail["harga_beli"]*$detail["jumlah"]);
             endforeach; ?>
             </tbody>
           </table>
           <h6 class="text-danger">Total: Rp <?php echo number_format($total); ?></h6>
           </li>
         <?php endforeach; ?>
       </ul>
    </div>
  </div>
</div>
</div>
<div class="col-12 footer bg-light">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
  </body>
</html>
