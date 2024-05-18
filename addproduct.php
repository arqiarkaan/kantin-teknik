<?php
include_once 'connectdb.php';

session_start();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:index.php');
}

include_once 'header.php';

if (isset($_POST['btnaddproduct'])) {
  $productname = $_POST['txtpname'];
  $category = $_POST['txtselect_option'];  // $_POST[''];  
  $purchaseprice =  $_POST['txtpprice'];
  $saleprice =  $_POST['txtsaleprice'];
  $stock = $_POST['txtstock'];
  $description = $_POST['txtdescription'];
  $f_name = $_FILES['myfile']['name'];
  $f_tmp = $_FILES['myfile']['tmp_name'];
  $f_size =  $_FILES['myfile']['size'];
  $f_extension = explode('.', $f_name);
  $f_extension = strtolower(end($f_extension));
  $f_newfile =  uniqid() . '.' . $f_extension;
  $store = "productimages/" . $f_newfile;
  if ($f_extension == 'jpg' || $f_extension == 'jpeg' ||  $f_extension == 'png' || $f_extension == 'gif') {

    if ($f_size >= 1000000) {
      $error = '<script type="text/javascript">
      jQuery(function validation(){
      swal({
        title: "Error!",
        text: "Max file should be 1MB!",
        icon: "warning",
        button: "Ok",
      });
});
</script>';

      echo $error;
    } else {
      if (move_uploaded_file($f_tmp, $store)) {

        $productimage = $f_newfile;
        if (!isset($errorr)) {

          $insert = $pdo->prepare("insert into tbl_product(pname,catid,purchaseprice,saleprice,pstock,pdescription,pimage) values(:pname,:catid,:purchaseprice,:saleprice,:pstock,:pdescription,:pimage)");

          $insert->bindParam(':pname', $productname);
          $insert->bindParam(':catid', $category);
          $insert->bindParam(':purchaseprice', $purchaseprice);
          $insert->bindParam(':saleprice', $saleprice);
          $insert->bindParam(':pstock', $stock);
          $insert->bindParam(':pdescription', $description);
          $insert->bindParam(':pimage', $productimage);

          if ($insert->execute()) {
            echo '<script type="text/javascript">
            jQuery(function validation(){
            swal({
              title: "Add product Successfull!",
              text: "Product Added",
              icon: "success",
              button: "Ok",
            });
            });
            </script>';
          } else {
            echo '<script type="text/javascript">
            jQuery(function validation(){
            swal({
              title: "ERROR!",
              text: "Add product Fail",
              icon: "error",
              button: "Ok",
            });
            });

            </script>';
          }
        }
      }
    }
  } else {
    $error = '<script type="text/javascript">
      jQuery(function validation(){
      swal({
        title: "Warning!",
        text: "only jpg ,jpeg, png and gif can be upload!",
        icon: "error",
        button: "Ok",
      });
    });
    </script>';

    echo $error;
  }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tambah Produk
      <small></small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">

    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> <a href="productlist.php" class="btn btn-primary" role="button">Kembali ke Daftar Produk</a></h3>
      </div>
      <!-- /.box-header -->
      <!-- form start -->

      <form action="" method="post" name="formproduct" enctype="multipart/form-data">


        <div class="box-body">
          <div class="col-md-6">

            <div class="form-group">
              <label>Nama Produk</label>
              <input type="text" class="form-control" name="txtpname" placeholder="Enter..." required>
            </div>

            <div class="form-group">
              <label>Kategori</label>
              <select class="form-control" name="txtselect_option" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <?php
                $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid DESC");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                ?>
                  <option value="<?php echo $catid; ?>"><?php echo $category; ?></option>
                <?php
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <label>Harga Jual</label>
              <input type="number" min="1" step="1" class="form-control" name="txtpprice" placeholder="Enter..." required>
            </div>

            <div class="form-group">
              <label>Harga Beli</label>
              <input type="number" min="1" step="1" class="form-control" name="txtsaleprice" placeholder="Enter..." required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Stok</label>
              <input type="number" min="1" step="1" class="form-control" name="txtstock" placeholder="Enter..." required>
            </div>
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea class="form-control" name="txtdescription" placeholder="Enter..." rows="4"></textarea>
            </div>
            <div class="form-group">
              <label>Gambar Produk</label>
              <input type="file" class="input-group" name="myfile" required>
              <p>Upload Gambar</p>
            </div>
          </div>
        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-info" name="btnaddproduct">Tambah Produk</button>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once 'footer.php';
?>