<?php
include_once 'connectdb.php';

session_start();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:index.php');
}
include_once 'header.php';
error_reporting(0);

$id = $_GET['id'];
$delete = $pdo->prepare("delete from tbl_user where userid=" . $id);

if ($delete->execute()) {
  echo '<script type="text/javascript">
      jQuery(function validation(){
      swal({
        title: "Successful!",
        text: "Account is deleted !!",
        icon: "success",
        button: "Ok",
      });
    });
    </script>';
}

if (isset($_POST['btnsave'])) {
  $username = $_POST['txtname'];
  $useremail = $_POST['txtemail'];
  $password = $_POST['txtpassword'];
  $userrole = $_POST['txtselect_option'];

  if (isset($_POST['txtemail'])) {
    $select = $pdo->prepare("SELECT useremail FROM tbl_user WHERE useremail=:useremail");
    $select->bindValue(':useremail', $useremail);
    $select->execute();

    if ($select->rowCount() > 0) {
      echo '<script type="text/javascript">
        jQuery(function validation(){
          swal({
            title: "Warning!",
            text: "Email Already Exist : Please try from different Email!",
            icon: "warning",
            button: "Ok",
          });
        });
        </script>';
    } else {
      // Enkripsi password
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Upload gambar profil
      $f_name = $_FILES['profile_image']['name'];
      $f_tmp = $_FILES['profile_image']['tmp_name'];
      $f_size = $_FILES['profile_image']['size'];
      $f_extension = explode('.', $f_name);
      $f_extension = strtolower(end($f_extension));
      $f_newfile = uniqid() . '.' . $f_extension;
      $store = "profileimages/" . $f_newfile;

      if ($f_extension == 'jpg' || $f_extension == 'jpeg' || $f_extension == 'png' || $f_extension == 'gif') {
        if ($f_size >= 1000000) {
          echo '<script type="text/javascript">
            jQuery(function validation(){
              swal({
                title: "Error!",
                text: "Max file size should be 1MB!",
                icon: "warning",
                button: "Ok",
              });
            });
          </script>';
        } else {
          if (move_uploaded_file($f_tmp, $store)) {
            $userimage = $f_newfile;

            $insert = $pdo->prepare("INSERT INTO tbl_user (username, useremail, password, role, profile_image) VALUES (:name, :email, :pass, :role, :profile_image)");
            $insert->bindParam(':name', $username);
            $insert->bindParam(':email', $useremail);
            $insert->bindParam(':pass', $hashedPassword);
            $insert->bindParam(':role', $userrole);
            $insert->bindParam(':profile_image', $userimage);

            if ($insert->execute()) {
              echo '<script type="text/javascript">
                jQuery(function validation(){
                  swal({
                    title: "Good Job!",
                    text: "Your Registration is Successful",
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
                    text: "Registration Failed!",
                    icon: "error",
                    button: "Ok",
                  });
                });
              </script>';
            }
          }
        }
      } else {
        echo '<script type="text/javascript">
          jQuery(function validation(){
            swal({
              title: "Warning!",
              text: "Only jpg, jpeg, png, and gif files can be uploaded!",
              icon: "error",
              button: "Ok",
            });
          });
        </script>';
      }
    }
  }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Registrasi
      <small></small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
    <div class="box box-solid box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Form Registrasi</h3>
      </div>

      <form role="form" action="" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="col-md-3">

            <div class="form-group">
              <label>Nama</label>
              <input type="text" class="form-control" name="txtname" placeholder="Masukkan Nama" required>
            </div>
            <div class="form-group">
              <label>Alamat Email</label>
              <input type="email" class="form-control" name="txtemail" placeholder="Masukkan Email" required>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" name="txtpassword" placeholder="Password" required>
            </div>
            <div class="form-group">
              <label>Role</label>
              <select class="form-control" name="txtselect_option" required>
                <option value="" disabled selected>Pilih Role</option>
                <option>User</option>
                <option>Admin</option>
              </select>
            </div>
            <div class="form-group">
              <label>Foto Profile</label>
              <input type="file" class="form-control" name="profile_image" required>
            </div>
            <button type="submit" class="btn btn-info" style="padding-bottom: 10px !important; " name="btnsave">Simpan</button>
          </div>

          <div class="col-md-9">
            <div style="overflow-x:auto;">
              <table class="table table-striped" id="regtable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Foto Profil</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $select = $pdo->prepare("SELECT * FROM tbl_user ORDER BY userid DESC");
                  $select->execute();
                  while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                    echo '
                      <tr>
                      <td>' . $row->userid . '</td>
                      <td>' . $row->username . '</td>
                      <td>' . $row->useremail . '</td>
                      <td>' . $row->password . '</td>
                      <td>' . $row->role . '</td>
                      <td><img src="profileimages/' . $row->profile_image . '" class="img-rounded" width="50px" height="50px"/></td>
                      <td>
                        <a href="registration.php?id=' . $row->userid . '" class="btn btn-danger" role="button"><span class="glyphicon glyphicon-trash" title="delete"></span></a>    
                      </td>
                      </tr>
                      ';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="box-footer">
        </div>

      </form>
    </div>
  </section>
</div>

<script>
  $(document).ready(function() {
    $('#regtable').DataTable({
      "order": [
        [0, "desc"]
      ]
    });
  });
</script>


<?php
include_once 'footer.php';
?>