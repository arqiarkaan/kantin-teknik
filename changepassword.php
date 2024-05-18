<?php
include_once 'connectdb.php';
session_start();

if ($_SESSION['useremail'] == "") {
  header('location:index.php');
}

if ($_SESSION['role'] == "Admin") {
  include_once 'header.php';
} else {
  include_once 'headeruser.php';
}

if (isset($_POST['btnupdate'])) {

  $oldpassword_txt = $_POST['txtoldpass'];
  $newpassword_txt = $_POST['txtnewpass'];
  $confpassword_txt = $_POST['txtconfpass'];

  $email = $_SESSION['useremail'];

  $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail=:email");
  $select->bindParam(':email', $email);
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  $useremail_db = $row['useremail'];
  $password_db = $row['password'];

  if (password_verify($oldpassword_txt, $password_db)) {

    if ($newpassword_txt == $confpassword_txt) {
      $hashed_password = password_hash($newpassword_txt, PASSWORD_DEFAULT);
      $update = $pdo->prepare("UPDATE tbl_user SET password=:pass WHERE useremail=:email");
      $update->bindParam(':pass', $hashed_password);
      $update->bindParam(':email', $email);

      if ($update->execute()) {
        echo '<script type="text/javascript">
          jQuery(function validation(){
          swal({
            title: "Good Job!",
            text: "Your Password Is Updated Successfully",
            icon: "success",
            button: "Ok",
          });
        });
        </script>';
      } else {
        echo '<script type="text/javascript">
          jQuery(function validation(){
          swal({
            title: "Error !!",
            text: "Query Failed",
            icon: "error",
            button: "Ok",
          });
        });
        </script>';
      }
    } else {
      echo '<script type="text/javascript">
        jQuery(function validation(){
        swal({
          title: "Oops!!!",
          text: "Your New Password And Confirm Password Do Not Match",
          icon: "warning",
          button: "Ok",
        });
      });
      </script>';
    }
  } else {
    echo '<script type="text/javascript">
      jQuery(function validation(){
        swal({
          title: "Warning !!",
          text: "Your Password Is Incorrect. Please Enter The Correct Password",
          icon: "warning",
          button: "Ok",
        });
      });
      </script>';
  }
}
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Change Password
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
      <li class="active">Here</li>
    </ol>
  </section>

  <section class="content container-fluid">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Change password form</h3>
      </div>
      <form role="form" action="" method="post">
        <div class="box-body">

          <div class="form-group">
            <label for="exampleInputPassword1">Old Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtoldpass" required>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">New Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtnewpass" required>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="txtconfpass" required>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" name="btnupdate">Update</button>
        </div>
      </form>
    </div>
  </section>
</div>

<?php
include_once 'footer.php';
?>