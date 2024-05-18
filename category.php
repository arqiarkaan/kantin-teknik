<?php

include_once 'connectdb.php';
session_start();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:index.php');
}
include_once 'header.php';


////

if (isset($_POST['btnsave'])) {
  $category = $_POST['txtcategory'];
  $type = $_POST['txtselect_option'];

  if (empty($category || $type)) {
    $error = '<script type="text/javascript">
      jQuery(function validation(){
      swal({
        title: "Feild is Empty!",
        text: "Please Fill Feild!!",
        icon: "error",
        button: "Ok",
      });
    });
    </script>';
    echo $error;
  }

  if (!isset($error)) {
    $insert = $pdo->prepare("insert into tbl_category(category, type) values(:category, :type)");
    $insert->bindParam(':category', $category);
    $insert->bindParam(':type', $type);

    if ($insert->execute()) {
      echo '<script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Added!",
          text: "Your Category is Added!",
          icon: "success",
          button: "Ok",
        });
      });
      </script>';
    } else {
      echo '<script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Error",
          text: "Query Fail!",
          icon: "error",
          button: "Ok",
        });
      });
      </script>';
    }
  }
}

////


if (isset($_POST['btnupdate'])) {
  $category = $_POST['txtcategory'];
  $type = $_POST['txtselect_option'];
  $id = $_POST['txtid'];
  if (empty($category || $type)) {
    $errorupdate = '<script type="text/javascript">
      jQuery(function validation(){
      swal({
        title: "Error",
        text: "Field is empty : please enter category!",
        icon: "error",
        button: "Ok",
      });
    });
    </script>';
    echo $errorupdate;
  }

  if (!isset($errorupdate)) {
    $update = $pdo->prepare("UPDATE tbl_category SET category=:category, type=:type WHERE catid=:id");
    $update->bindParam(':category', $category);
    $update->bindParam(':type', $type);
    $update->bindParam(':id', $id);

    if ($update->execute()) {
      echo '<script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Updated!",
          text: "Your Category is Updated!",
          icon: "success",
          button: "Ok",
        });
      });
      </script>';
    } else {
      echo '<script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Error!",
          text: "Your Category is  Not Updated!",
          icon: "error",
          button: "Ok",
        });
      });
      </script>';
    }
  }
}

////

if (isset($_POST['btndelete'])) {
  $delete = $pdo->prepare("delete from tbl_category where catid=" . $_POST['btndelete']);
  if ($delete->execute()) {
    echo '<script type="text/javascript">
      jQuery(function validation(){
      swal({
        title: "Deleted!",
        text: "Your Category is Deleted!",
        icon: "success",
        button: "Ok",
      });
    });
    </script>';
  } else {
    echo '<script type="text/javascript">
      jQuery(function validation(){
      swal({
        title: "Error!",
        text: "Your Category is Not Deleted!",
        icon: "success",
        button: "Ok",
      });
    });
</script>';
  }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Produk -> Kategori
      <small></small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-solid box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Tambah Kategori</h3>
          </div>

          <div class="box-body">
            <form role="form" action="" method="post">
              <?php
              if (isset($_POST['btnedit'])) {
                $select = $pdo->prepare("select * from tbl_category where catid=" . $_POST['btnedit']);
                $select->execute();
                if ($select) {
                  $row = $select->fetch(PDO::FETCH_OBJ);
                  echo '
                      <div class="form-group">
                        <label>Kategpri</label>
                        <input type="hidden" class="form-control" value="' . $row->catid . '" name="txtid" placeholder="Masukan Kategori">
                        <input type="text" class="form-control" value="' . $row->category . '" name="txtcategory" placeholder="Masukkan Kategori">
                        <br>
                        <select class="form-control" name="txtselect_option" required>
                          <option value="" disabled>Pilih Tipe</option>
                          <option value="Makanan" ' . ($row->type == "Makanan" ? "selected" : "") . '>Makanan</option>
                          <option value="Minuman" ' . ($row->type == "Minuman" ? "selected" : "") . '>Minuman</option>
                        </select>
                      </div>           
                    <button type="submit" class="btn btn-info" name="btnupdate">Update</button>';
                }
              } else {
                echo '<div class="form-group">
                      <label>Kategori</label>
                      <input type="text" class="form-control" name="txtcategory" placeholder="Masukkan kategori">
                      <br>
                      <select class="form-control" name="txtselect_option" required>
                          <option value="" disabled selected>Pilih Tipe</option>
                          <option value="Makanan">Makanan</option>
                          <option value="Minuman">Minuman</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-warning" name="btnsave">Save</button>';
              }
              ?>
            </form>
          </div>
          <!-- /.box-body -->
        </div>
      </div>

      <div class="col-md-12">
        <div class="box box-solid box-success">
          <div class="box-header with-border">
            <h3 class="box-title">List Kategori</h3>
          </div>

          <div class="box-body">
            <form role="form" action="" method="post">
              <table id="tablecategory" class="table table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $select = $pdo->prepare("select * from tbl_category order by catid desc");
                  $select->execute();
                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                    echo '<tr>
                        <td>' . $row->catid . '</td>
                        <td>' . $row->category . '</td>  
                        <td>' . $row->type . '</td>                   
                        <td>
                          <button type="submit" value="' . $row->catid . '" class="btn btn-success" name="btnedit">Edit</button>
                        </td>                    
                        <td>
                            <button type="submit" value="' . $row->catid . '" class="btn btn-danger" name="btndelete">Delete</button>
                        </td>                  
                      </tr>';
                  }

                  ?>
                </tbody>
              </table>
            </form>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </section>
</div>
<!-- /.box-body -->
</div>
</div>
</div>
</section>
</div>


<script>
  $(document).ready(function() {
    $('#tablecategory').DataTable();
  });
</script>

<?php
include_once 'footer.php';
?>