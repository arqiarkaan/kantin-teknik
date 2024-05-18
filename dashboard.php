<?php

include_once 'connectdb.php';
session_start();

if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "User") {
  header('location:index.php');
}

$select = $pdo->prepare("select sum(total) as t , count(invoice_id) as inv from tbl_invoice");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);
$total_order = $row->inv;
$net_total = $row->t;
$select = $pdo->prepare("select order_date, total from tbl_invoice  group by order_date LIMIT 30");
$select->execute();
$ttl = [];
$date = [];
while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
  extract($row);
  $ttl[] = $total;
  $date[] = $order_date;
}
// echo json_encode($total);  
include_once 'header.php';
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Admin Dashboard
      <small></small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">

    <div class="box-body">
      <div class="row">
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $total_order; ?></h3>
              <p>Total Order</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-12 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo "Rp" . number_format($net_total, 2); ?><sup style="font-size: 20px"></sup></h3>
              <p>Pendapatan Kotor</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
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
                      <th>Nama Pelanggan</th>
                      <th>Tanggal Order</th>
                      <th>Total</th>
                      <th>Tipe Pembayaran</th>
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
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  var ctx = document.getElementById('earningbydate').getContext('2d');
  var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
      labels: <?php echo json_encode($date); ?>,
      datasets: [{
        label: 'Total Earning',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',

        data: <?php echo json_encode($ttl); ?>
      }]
    },

    // Configuration options go here
    options: {}
  });
</script>

<!--
    <script>
  $(document).ready( function () {
    $('#bestsellingproductlist').DataTable({
         "order":[[0,"asc"]] 
        
     });
} );  
    
</script>
 
  <script>
  $(document).ready( function () {
    $('#orderlisttable').DataTable({
        "order":[[0,"desc"]]    
     });
} );  
</script>
-->

<?php
include_once 'footer.php';
?>