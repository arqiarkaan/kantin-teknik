<?php

include_once 'connectdb.php';
session_start();

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:index.php');
}


include_once 'header.php';

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Detail Produk
      <small></small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Kembali ke Daftar Produk</a></h3>
      </div>

      <div class="box-body">
        <?php
          $id = $_GET['id'];

          $select = $pdo->prepare("select * from tbl_product where pid=$id");

          $select->execute();

          while ($row = $select->fetch(PDO::FETCH_OBJ)) {
            echo '
            <div class="col-md-6">
              <ul class="list-group">
              <center><p class="list-group-item list-group-item-success"><b>Product image</b></p></center>
                <img src = "productimages/' . $row->pimage . '" class="img-responsive"/> 
              </ul>
            </div>
            <div class="col-md-6">
              <ul class="list-group">
              <center><p class="list-group-item list-group-item-success"><b>Product Detail</b></p></center>
                <li class="list-group-item"><b>ID</b> <span class="badge">' . $row->pid . '</span></li>
                <li class="list-group-item"><b>Nama Produk</b> <span class="label label-info pull-right">' . $row->pname . '</span></li>
                <li class="list-group-item"><b>Kategori</b> <span class="label label-primary pull-right">' . getCategoryName($pdo, $row->catid) . '</span></li>
                <li class="list-group-item"><b>Harga Beli</b> <span class="label label-warning pull-right">' . $row->purchaseprice . '</span></li>
                <li class="list-group-item"><b>Harga Jual</b> <span class="label label-warning pull-right">' . $row->saleprice . '</span></li>
                <li class="list-group-item"><b>Untung</b><span class="label label-success pull-right">' . ($row->saleprice - $row->purchaseprice) . '</span></li>
                <li class="list-group-item"><b>Stok </b><span class="label label-danger pull-right">' . $row->pstock . '</span></li>
                <li class="list-group-item"><b>Deskripsi:- </b><span class="">' . $row->pdescription . '</span></li>
              </ul>
            </div>
            ';}

            function getCategoryName($pdo, $catid){
              $selectCategory = $pdo->prepare("SELECT category FROM tbl_category WHERE catid = :catid");
              $selectCategory->bindParam(':catid', $catid);
              $selectCategory->execute();
              $category = $selectCategory->fetch(PDO::FETCH_OBJ);
              return $category->category;
            }
        ?>
      </div>
    </div>
  </section>
</div>

<?php
include_once 'footer.php';
?>