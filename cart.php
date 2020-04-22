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
<div class="cart">
<div class="container-fluid col-10">
  <br>
  <br>
  <div class="card">
    <div class="card-header bg-secondary">
      <h4 class="text-white" align="center">Keranjang Belanja Anda</h4>
    </div>
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; ?>
          <?php foreach ($_SESSION["cart"] as $cart): ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php echo $cart["judul"]; ?></td>
              <td>Rp <?php echo $cart["harga"]; ?></td>
              <td><?php echo $cart["jumlah_beli"]; ?></td>
              <td>Rp <?php echo $cart["jumlah_beli"]*$cart["harga"]; ?></td>
              <td>
              <a href="proses_cart.php?hapus=true&kode_buku=<?php echo $cart["kode_buku"] ?>">
                <button type="button" class="btn btn-sm btn-danger">Hapus</button>
              </a>
            </td>
            </tr>
            <?php $no++; endforeach; ?>

        </tbody>
        <tfoot>

        </tfoot>
      </table>
      <a href="proses_cart.php?checkout=true">
      <button type="button" class="btn btn-success"> Checkout</button>
    </a>
    </div>
  </div>
</div>
</div>
<div class="col-12 footer bg-light">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
  </body>
</html>
