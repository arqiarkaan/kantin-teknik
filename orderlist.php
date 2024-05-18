<?php
include_once 'connectdb.php';
session_start();
if ($_SESSION['useremail'] == "" or $_SESSION['role'] == "") {
  header('location:index.php');
}

if ($_SESSION['role'] == "Admin") {
  include_once 'header.php';
} else {
  include_once 'headeruser.php';
}
?>


<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Daftar Order
      <small></small>
    </h1>
  </section>

  <section class="content container-fluid">
    <div class="box box-solid box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Order</h3>
      </div>

      <div class="box-body">
        <div style="overflow-x:auto;">
          <table id="orderlisttable" class="table table-striped">
            <thead>
              <tr>
                <th>Invoice ID</th>
                <th>Nama Pelanggan</th>
                <th>Tgl Order</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kurang/Lebih</th>
                <th>Tipe Pembayaran</th>
                <th>Print</th>
                <th>View</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $select = $pdo->prepare("select * from tbl_invoice  order by invoice_id desc");
              $select->execute();
              while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                echo '
                  <tr>
                    <td>' . $row->invoice_id . '</td>
                    <td>' . $row->customer_name . '</td>
                    <td>' . $row->order_date . '</td>
                    <td>' . $row->total . '</td>
                    <td>' . $row->paid . '</td>
                    <td>' . $row->due . '</td>
                    <td>' . $row->payment_type . '</td>
                    <td>
                      <a href="invoice_80mm.php?id=' . $row->invoice_id . '" class="btn btn-warning" role="button" target="_blank"><span class="glyphicon glyphicon-print"  style="color:#ffffff" data-toggle="tooltip"  title="Print Invoice"></span></a>   
                    </td>
                    <td>
                      <button id="viewBtn' . $row->invoice_id . '" class="btn btn-primary btnView" data-toggle="modal" data-target="#invoiceModal' . $row->invoice_id . '"><span class="glyphicon glyphicon-eye-open" style="color:#ffffff" data-toggle="tooltip" title="View Invoice"></span></button>
                      
                      <!-- Modal -->
                      <div class="modal fade" id="invoiceModal' . $row->invoice_id . '" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel' . $row->invoice_id . '">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="invoiceModalLabel' . $row->invoice_id . '">Invoice Details</h4>
                            </div>
                            <div class="modal-body">
                              <!-- Invoice details here -->
                              <p>Invoice ID: ' . $row->invoice_id . '</p>
                              <p>Customer Name: ' . $row->customer_name . '</p>
                              <p>Order Date: ' . $row->order_date . '</p>
                              <p>Total: ' . $row->total . '</p>
                              <p>Paid: ' . $row->paid . '</p>
                              <p>Due: ' . $row->due . '</p>
                              <p>Payment Type: ' . $row->payment_type . '</p>
                              <!-- Add more details as needed -->
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <a href="editorder.php?id=' . $row->invoice_id . '" class="btn btn-info"role="button"><span class="glyphicon glyphicon-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Order"></span></a>   
                    </td>
                    <td>
                      <button id=' . $row->invoice_id . ' class="btn btn-danger btndelete" ><span class="glyphicon glyphicon-trash" style="color:#ffffff" data-toggle="tooltip"  title="Delete Order"></span></button>  
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
  </section>
</div>


<script>
  $(document).ready(function() {
    $('#orderlisttable').DataTable({
      "order": [
        [0, "desc"]
      ]
    });
  });

  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $(document).ready(function() {
    $('.btndelete').click(function() {
      var tdh = $(this);
      var id = $(this).attr("id");
      swal({
          title: "Do you want to delete Order?",
          text: "Once Order is deleted, you can not recover it!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: 'orderdelete.php',
              type: 'post',
              data: {
                pidd: id
              },
              success: function(data) {
                tdh.parents('tr').hide();
              }
            });
            swal("Your Order has been deleted!", {
              icon: "success",
            });
          } else {
            swal("Your Order is safe!");
          }
        });
    });
  });
</script>

<?php
include_once 'footer.php';
?>