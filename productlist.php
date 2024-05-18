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
      Daftar Produk
      <small></small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content container-fluid">

    <div class="box box-solid box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Produk</h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn bg-navy btn-smmargin"><a href="addproduct.php" style="color: #fff !important;"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah Produk</button></a>
      </div>

      <div class="box-body">
        <div style="overflow-x:auto;">
          <table id="producttable" class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Lihat</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $select = $pdo->prepare("SELECT * FROM tbl_product ORDER BY pid DESC");
              $select->execute();

              while ($row = $select->fetch(PDO::FETCH_OBJ)) {
                echo '
                  <tr>
                    <td>' . $row->pid . '</td>
                    <td>' . $row->pname . '</td>
                    <td>' . getCategoryName($pdo, $row->catid) . '</td>
                    <td>' . $row->purchaseprice . '</td>
                    <td>' . $row->saleprice . '</td>
                    <td>' . $row->pstock . '</td>
                    <td>' . $row->pdescription . '</td>
                    <td><img src="productimages/' . $row->pimage . '" class="img-rounded" width="40px" height="40px"/></td>
                    <td>
                      <a href="viewproduct.php?id=' . $row->pid . '" class="btn btn-success" role="button" data-toggle="tooltip" title="View Product">
                        <span class="glyphicon glyphicon-eye-open" style="color: #ffffff"></span>
                      </a>
                    </td>
                    <td>
                      <a href="editproduct.php?id=' . $row->pid . '" class="btn btn-info" role="button" data-toggle="tooltip" title="Edit Product">
                        <span class="glyphicon glyphicon-edit" style="color: #ffffff"></span>
                      </a>
                    </td>
                    <td>
                      <button id="' . $row->pid . '" class="btn btn-danger btndelete" data-toggle="tooltip" title="Delete Product">
                        <span class="glyphicon glyphicon-trash" style="color: #ffffff"></span>
                      </button>
                    </td>
                  </tr>
                  ';
              }

              function getCategoryName($pdo, $catid)
              {
                $selectCategory = $pdo->prepare("SELECT category FROM tbl_category WHERE catid = :catid");
                $selectCategory->bindParam(':catid', $catid);
                $selectCategory->execute();
                $category = $selectCategory->fetch(PDO::FETCH_OBJ);
                return $category->category;
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
    $('#producttable').DataTable({
      "order": [
        [0, "desc"]
      ]
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<script>
  $(document).ready(function() {
    $('.btndelete').click(function() {
      var tdh = $(this);
      var id = $(this).attr("id");
      swal({
          title: "Do you want to delete product?",
          text: "Once Product is deleted, you can not recover it!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {

            $.ajax({
              url: 'productdelete.php',
              type: 'post',
              data: {
                pidd: id
              },
              success: function(data) {
                tdh.parents('tr').hide();
              }
            });
            swal("Your Product has been deleted!", {
              icon: "success",
            });
          } else {
            swal("Your Product is safe!");
          }
        });
    });
  });
</script>

<?php
include_once 'footer.php';
?>