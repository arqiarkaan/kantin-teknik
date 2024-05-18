<?php

include_once 'connectdb.php';
session_start();

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "Admin") {

  header('location:index.php');
}

include_once 'headeruser.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User Dashboard
      <small></small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">
    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Produk Terlaris</h3>
        </div>
        <div class="box-body">
          <div style="overflow-x:auto;">
            <table id="bestsellingproductlist" class="table table-striped">
              <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Nama Produk</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $select = $pdo->prepare("select product_id,product_name,price,sum(qty) as q , sum(qty*price) as total from tbl_invoice_details group by product_id order by sum(qty) DESC LIMIT 15");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                  echo '
                    <tr>
                      <td>' . $row->product_id . '</td>
                      <td>' . $row->product_name . '</td>
                      <td><span class="label label-info">' . $row->q . '</span></td>
                      <td><span class="label label-success">' . "Rp" . $row->price . '</span></td>
                      <td><span class="label label-danger">' . "Rp" . $row->total . '</span></td>
                    </tr>
                    ';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


    <div class="col-md-6">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Order Terbaru</h3>
        </div>
        <div class="box-body">
          <div style="overflow-x:auto;">
            <table id="orderlisttable" class="table table-striped">
              <thead>
                <tr>
                  <th>Invoice ID</th>
                  <th>Nama Customer</th>
                  <th>Tgl Order</th>
                  <th>Total</th>
                  <th>Metode Pembayaran</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $select = $pdo->prepare("select * from tbl_invoice  order by invoice_id desc LIMIT 15");
                $select->execute();
                while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                  echo '
                      <tr>
                        <td><a href="editorder.php?id=' . $row->invoice_id . '">' . $row->invoice_id . '</a></td>
                        <td>' . $row->customer_name . '</td>
                        <td>' . $row->order_date . '</td>
                        <td><span class="label label-danger">' . "Rp" . $row->total . '</span></td>';
                  if ($row->payment_type == "Cash") {
                    echo '<td><span class="label label-warning">' . $row->payment_type . '</span></td>';
                  } elseif ($row->payment_type == "Card") {
                    echo '<td><span class="label label-success">' . $row->payment_type . '</span></td>';
                  } else {
                    echo '<td><span class="label label-primary">' . $row->payment_type . '</span></td>';
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>



  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

include_once 'footer.php';

?>