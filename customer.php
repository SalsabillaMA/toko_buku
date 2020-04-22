<?php
session_start();
if (!isset($_SESSION["id_admin"])) {
  header("location:login_admin.php");
}
// memanggil file config.php agar tidak perlu membuat koneksi baru
include("config.php");
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Data Customer</title>
     <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="css-admin.css">
     <script src="assets/js/jquery.min.js"></script>
     <script src="assets/js/popper.min.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
     <script type="text/javascript">
       Add = () => {
         document.getElementById('action').value = "insert";
         document.getElementById('id_customer').value = "";
         document.getElementById('nama').value = "";
         document.getElementById('alamat').value = "";
         document.getElementById('kontak').value = "";
         document.getElementById('username').value = "";
         document.getElementById('password').value = "";
       }

       Edit = (item) => {
         document.getElementById('action').value = "update";
         document.getElementById('id_customer').value = item.id_customer;
         document.getElementById('nama').value = item.nama;
         document.getElementById('alamat').value = item.alamat;
         document.getElementById('kontak').value = item.kontak;
         document.getElementById('username').value = item.username;
         document.getElementById('password').value = item.password;
       }
     </script>
   </head>
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
     <li class="nav-item"><a href="buku.php" class="nav-link h5 mt-1">Buku</a></li>
     <li class="nav-item"><a href="admin.php" class="nav-link h5 mt-1">Admin</a></li>
     <li class="nav-item"><a href="customer.php" class="nav-link h5 mt-1">Customer</a></li>
     <li class="nav-item"><a href="riwayat.php" class="nav-link h5 mt-1">Riwayat</a></li>
  </ul>
  <ul class="navbar-nav ml-auto">
  <li class="nav-item">
    <a href="proses_login_admin.php?logout=true" class="nav-link h5 mt-2" ><?php echo $_SESSION["nama"]; ?> <img src="logout.png" width="30" align="left" alt=""> </a>
  </li>
  </ul>
 </div>
 </nav>
   <body>

     <?php
     if (isset($_POST["cari"])) {
       // query jikka pencarian
       $cari = $_POST["cari"];
       $sql = " select * from customer where id_customer like '%$cari%' or nama like '%$cari%'
       or alamat like '%$cari%' or kontak like '%$cari%' or username like '%$cari%' or password like '%$cari%'";
     }else {
       // query jika tidak mencari
       $sql = " select * from customer";
     }
     // eksekusi perintah sql nya
     $query = mysqli_query($connect, $sql);
   ?>
   <div class="customer">
<div class="container">
  <br>
  <br>
  <br>
  <!-- start card -->
  <div class="card">
    <div class="card-header bg-secondary text-white">
      <h3 align="center">Data Customer</h3>
    </div>
    <div class="card-body">
      <form action="customer.php" method="post">
        <input type="text" name="cari" class="form-control" placeholder="Pencarian...">
      </form>
      <table class="table" border="2">
        <thead>
            <tr>
              <th>ID ADMIN</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Kontak</th>
              <th>Username</th>
              <th>Password</th>
              <th>Option</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($query as $customer): ?>
             <tr>
              <td><?php echo $customer["id_customer"];
              ?></td>
              <td><?php echo $customer["nama"]; ?></td>
              <td><?php echo $customer["alamat"]; ?></td>
              <td><?php echo $customer["kontak"]; ?></td>
              <td><?php echo $customer["username"]; ?></td>
              <td><?php echo $customer["password"]; ?></td>
              <td>
                <button data-toggle="modal" data-target="#modal_customer" type="button"
                class="btn btn-sm btn-info" onclick='Edit(<?php echo json_encode($customer);?>)'>
                Edit </button>
                <a href="crud_customer.php?hapus=true&id_customer=<?php echo $customer ["id_customer"];?>"
                  onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                  <button type="button" class="btn btn-sm btn-danger"> Hapus </button> </a>
              </td>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>
      <button data-toggle="modal" data-target="#modal_customer"
      type="button" class="btn btn-sm btn-success" onclick="Add()">
      Tambah Data
    </button>
    </div>
  </div>
  <!-- end card -->

  <!-- form modal -->
  <div class="modal fade" id="modal_customer">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="crud_customer.php" method="post" enctype="multipart/form-data">
        <div class="modal-header bg-danger text-white">
          <h4>Form Customer</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" id="action">
          ID Customer
          <input type="number" name="id_customer" id="id_customer"
          class="form-control" required />
          Nama
          <input type="text" name="nama" id="nama"
          class="form-control" required />
          Alamat
          <input type="text" name="alamat" id="alamat"
          class="form-control" required />
          Kontak
          <input type="text" name="kontak" id="kontak"
          class="form-control" required />
          Username
          <input type="text" name="username" id="username"
          class="form-control" required />
          Password
          <input type="password" name="password" id="password"
          class="form-control" required />
        <!-- upload file yng akan di upload -->
      </div>
      <div class="modal-footer">
        <button type="submit" name="save_customer" class="btn btn-primary">
          Simpan</button>
      </div>
      </form>
    </div>
 <!-- apalagi pak -->
  </div>
  </div>
  <!-- end form modal -->
</div>
</div>
<div class="col-12 footer bg-dark text-white">
  <h5 align="center" >&copy; Copyright by Sall2020</h5>
</div>
   </body>
 </html>
