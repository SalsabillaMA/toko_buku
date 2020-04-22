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
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Data Buku</title>
     <link rel="stylesheet" href="assets/css/bootstrap.min.css">
     <link rel="stylesheet" href="css-admin.css">
     <script src="assets/js/jquery.min.js"></script>
     <script src="assets/js/popper.min.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
     <script type="text/javascript">
       Add = () => {
         document.getElementById('action').value = "insert";
         document.getElementById('kode_buku').value = "";
         document.getElementById('judul').value = "";
         document.getElementById('penulis').value = "";
         document.getElementById('tahun').value = "";
         document.getElementById('harga').value = "";
         document.getElementById('stok').value = "";
       }

       Edit = (item) => {
         document.getElementById('action').value = "update";
         document.getElementById('kode_buku').value = item.kode_buku;
         document.getElementById('judul').value = item.judul;
         document.getElementById('penulis').value = item.penulis;
         document.getElementById('tahun').value = item.tahun;
         document.getElementById('harga').value = item.harga;
         document.getElementById('stok').value = item.stok;

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
<div class="buku">
<div class="container" id="#a">
  <br>
  <br>
  <br>

  <!-- start card -->
  <div class="card">
    <div class="card-header bg-secondary text-white">
      <h3 align="center" >Data Buku</h3>
    </div>
    <div class="card-body">
      <form action="buku.php" method="post">
        <input type="text" name="cari" class="form-control" placeholder="Pencarian...">
      </form>
      <table class="table" border="2">
        <thead>
            <tr>
              <th>Kode Buku</th>
              <th>Judul</th>
              <th>Penulis</th>
              <th>Tahun</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Image</th>
              <th>Option</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($query as $buku): ?>
             <tr>
              <td><?php echo $buku["kode_buku"];
              //nama "siswa" harus sama yg di database
              ?></td>
              <td><?php echo $buku["judul"]; ?></td>
              <td><?php echo $buku["penulis"]; ?></td>
              <td><?php echo $buku["tahun"]; ?></td>
              <td><?php echo $buku["harga"]; ?></td>
              <td><?php echo $buku["stok"]; ?></td>
              <td>
                <img src="<?php echo 'image/'.$buku['image']; ?>" alt="Foto Buku"
                width="200" />
              </td>
              <td>
                <button data-toggle="modal" data-target="#modal_buku" type="button"
                class="btn btn-sm btn-info" onclick='Edit(<?php echo json_encode($buku);?>)'>
                Edit </button>
                <a href="crud_buku.php?hapus=true&kode_buku=<?php echo $buku ["kode_buku"];?>"
                  onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                  <button type="button" class="btn btn-sm btn-danger"> Hapus </button> </a>
              </td>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>
      <button data-toggle="modal" data-target="#modal_buku"
      type="button" class="btn btn-sm btn-success" onclick="Add()">
      Tambah Data
    </button>
    </div>
  </div>
  <!-- end card -->

  <!-- form modal -->
  <div class="modal fade" id="modal_buku">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="crud_buku.php" method="post" enctype="multipart/form-data">
        <div class="modal-header bg-danger text-white">
          <h4>Form Buku</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" id="action">
          Kode Buku
          <input type="number" name="kode_buku" id="kode_buku"
          class="form-control" required />
          Judul
          <input type="text" name="judul" id="judul"
          class="form-control" required />
          Penulis
          <input type="text" name="penulis" id="penulis"
          class="form-control" required />
          Tahun
          <input type="text" name="tahun" id="tahun"
          class="form-control" required />
          Harga
          <input type="text" name="harga" id="harga"
          class="form-control" required />
          Stok
          <input type="text" name="stok" id="stok"
          class="form-control" required />
          Image
        <input type="file" name="image" id="image" class="form-control">
        <!-- upload file yng akan di upload -->
      </div>
      <div class="modal-footer">
        <button type="submit" name="save_buku" class="btn btn-primary">
          Simpan</button>
      </div>
      </form>
    </div>

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
