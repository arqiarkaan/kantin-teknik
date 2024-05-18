<?php
include_once 'connectdb.php';
session_start();
date_default_timezone_set("Asia/jakarta");
if (isset($_POST['btn_login'])) {
  $useremail = $_POST['txt_email'];
  $password = $_POST['txt_password'];

  $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail=:useremail");
  $select->bindValue(':useremail', $useremail);
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  if ($row && password_verify($password, $row['password']) && $row['role'] == "Admin") {
    $_SESSION['userid'] = $row['userid'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['useremail'] = $row['useremail'];
    $_SESSION['role'] = $row['role'];
    $message = 'success';
    header('refresh:2;dashboard.php');
  } else if ($row && password_verify($password, $row['password']) && $row['role'] == "User") {
    $_SESSION['userid'] = $row['userid'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['useremail'] = $row['useremail'];
    $_SESSION['role'] = $row['role'];
    $message = 'success';
    header('refresh:3;user.php');
  } else {
    $errormsg = 'error';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sign In - KantinTeknik</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <script src="bower_components/sweetalert/sweetalert.js"></script>


  <link rel="stylesheet" href="loginstyle/login.css">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

</head>

<body>
  <div class="container">
    <div class="container-2">
      <div class="login-header">
        <p class="top-header">Kantin<span class="teknik">Teknik</span></p>
      </div>
      <div class="login form">
        <form action="" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="txt_email" required>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="txt_password" required>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <a href="#" onclick="swal('Untuk Mendapatkan Password','Tolong Hubungi Kontak Admin di: 081138829','loginstyle/question.gif');">Lupa Password?</a><br>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn_login">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
          <?php
          if (!empty($message)) {
            echo '<script type="text/javascript">
            jQuery(function validation(){
            swal({
              title: "Login Berhasil! Halo ' . $_SESSION['username'] . '",
              text: "Silahkan Tunggu Sebentar",
              icon: "success",
              button: "loading...",
              });
            });
            </script>';
          } else {
          }

          if (empty($errormsg)) {
          } else {
            echo '<script type="text/javascript">
            jQuery(function validation(){
            swal({
              title: "Email atau Password yang Anda Masukkan Salah!",
              text: "Tolong cek lagi dengan lebih teliti.",
              icon: "error",
              button: "Ok",
            });
          });
          </script>';
          }
          ?>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
  </script>
</body>

</html>