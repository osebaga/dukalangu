<?php
include 'layouts/header.php';
include 'layouts/sidebar.php';
include 'includes/connection.php';
?>
<div id="wrapper">

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="page-header">Purchasing Order</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       Purchasing Orders
                    </div>
                    <?php if (isset($_POST['savedata'])) {
                        $code = $_POST['product'];
                        $qty = $_POST['qty'];
                        $unit = $_POST['unit'];
                        $supplier = $_POST['supplier'];
                        // $selling = $_POST['sellingprice'];
                        $orderdate = $_POST['stockin'];
                        // $actual_amount = $qty * $cost;
                        $order_no = $_POST['orderno'];

                        // $check = mysqli_query(
                        //     $conn,
                        //     "SELECT * FROM purching_order WHERE order_number='$order_no'"
                        // );
                            $insert = 
                            mysqli_query(
                                $conn,
                                "INSERT INTO purchasing_order(order_number,productcode,supplier_id,quantity,unit,order_date) VALUES('$order_no','$code','$supplier','$qty','$unit','$orderdate')"
                        
                            );
                            if ($insert) {
                                echo '<div class="alert alert-success" role="alert">
                            Data Saved Successfully!!
                          </div>';
                            } else {
                                echo '<div class="alert alert-warning" role="alert">
                            No Data Saved!!
                          </div>' . mysqli_error($conn);
                            }
                        }
                    ?>
                    <div class="panel-body">
                        <div class="row">
                                <form action="<?php echo htmlentities(
                                    $_SERVER['PHP_SELF']
                                ); ?>" method="POST">
                          <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Order Number</label>
                                            <input type="text" name="orderno" value="<?php echo date('Yd').rand(11,99); ?>"  class="form-control"/>
                                        </div>
                                </div>
                          <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Product</label>
                                            <select type="text" name="product" required class="form-control" placeholder="GSM">
                                            <option value="">select product</option>
                                            <?php
                                            $query = mysqli_query(
                                                $conn,
                                                'SELECT * FROM product'
                                            );

                                            while (
                                                $row = mysqli_fetch_assoc(
                                                    $query
                                                )
                                            ) { ?>
                                                <option value="<?php echo $row[
                                                    'code'
                                                ]; ?>"><?php echo $row[
                                                    'pname'
                                                ]; ?></option>
                                           <?php }
                                            ?>
                                        </select>
                                        </div>
                                </div> 

                                <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Supplier</label>
                                            <select type="text" name="supplier" required class="form-control" placeholder="GSM">
                                            <option value="">select supplier</option>
                                            <?php
                                            $query = mysqli_query(
                                                $conn,
                                                'SELECT * FROM supplier'
                                            );

                                            while (
                                                $row = mysqli_fetch_assoc(
                                                    $query
                                                )
                                            ) { ?>
                                                <option value="<?php echo $row[
                                                    'supplier_id'
                                                ]; ?>"><?php echo $row[
                                                    'company_name'
                                                ]; ?></option>
                                           <?php }
                                            ?>
                                        </select>
                                        </div>
                                </div> 
                                <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Quantity</label>
                                            <input type="text" name="qty" class="form-control" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"/>
                                        </div>
                                </div>
                           
                                    <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Units</label>
                                        <select type="text" name="unit" class="form-control" required>
                                            <option value="">select units</option>
                                            <option value="Kg">kilogram</option>
                                            <option value="Dozen">Dozen</option>
                                            <option value="Grams">Grams</option>
                                            <option value="m">meter</option>
                                            <option value="Box">Boxes</option>
                                            <option value="crates">Crates</option>

                                        </select>
                                    </div>
                                    </div>
                                    <!-- <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Purchasing Price</label>
                                            <input type="text" name="costprice" class="form-control" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" placeholder="500"/>
                                        </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Selling Price</label>
                                            <input type="text" name="sellingprice" class="form-control" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" placeholder="1000"/>
                                        </div>
                                </div> -->
                                <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Order Date</label>
                                            <input type="date" name="stockin" class="form-control" required/>
                                        </div>
                                </div>
                            </div>
                            <div class="text-center">
                                    <button type="submit" name="savedata" class="btn btn-primary pull-right">Submit Order</button>
                    </div>
                                </form>
                                <br>
                        <hr>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>S/No</th>
                                                    <th>Oder Number</th>
                                                    <th>Product Name</th>
                                                    <th>Category</th>
                                                    <th>Supplier</th>
                                                    <th>Quantity</th>
                                                    <th>Units</th>
                                                    <th>Action</th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sn = 1;
                                                $query = mysqli_query(
                                                    $conn,
                                                    'SELECT * FROM purchasing_order join supplier 
                                                    ON supplier.supplier_id=purchasing_order.supplier_id join product on product.code=purchasing_order.productcode');
                                                while (
                                                    $row_data = mysqli_fetch_assoc(
                                                        $query
                                                    )
                                                ) { 
                                                   $categ = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM product_category WHERE category_id='$row_data[category_id]'"));
                                                    ?>
                                                <tr class="odd gradeX">
                                                <td><?php
                                                echo $sn;
                                                $sn++;
                                                ?></td>
                                                    <td><?php echo $row_data[
                                                        'order_number'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'pname'
                                                    ]; ?></td>
                                                    <td><?php echo 
                                                        $categ['cname']
                                                    ; ?></td>
                                                    <td><?php echo $row_data[
                                                        'company_name'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'quantity'
                                                    ]; ?></td>
                                                
                                                       <td><?php echo $row_data[
                                                           'unit'
                                                       ]; ?></td>
                                                   <td><i class="fa fa-edit" style="color: green;"></i><i class="fa fa-trash" style="color: red; margin-left: 6%" ></i></td>


                                                </tr>
                                           
                                     <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <p class="pull-right"><b>Total Amount: <?php 
                                    $amt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sum(actual_amount) as sum FROM product"));
                                    echo $amt["sum"]; ?></b></p> -->
                    </div>
                </div>

            </div>
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->



<?php include 'layouts/footer.php'; ?>
  <!-- DataTables JavaScript -->
<!-- <script src="../js/dataTables/jquery.dataTables.min.js"></script>
<script src="../js/dataTables/dataTables.bootstrap.min.js"></script> -->

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
        // window.location = 'lecturerProgrammecourselist.php';

      });
    }, 4000);

</script>