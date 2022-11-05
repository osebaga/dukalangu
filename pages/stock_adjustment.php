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
                    <h2 class="page-header">Inventory</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       Stock Recording
                    </div>
                    <?php if(isset($_POST['savedata'])) {
                        $code = $_POST['product'];
                        $qty = $_POST['qty'];
                        $unit = $_POST['unit'];
                        $cost = $_POST['costprice'];
                        $selling = $_POST['sellingprice'];
                        $orderdate = $_POST['stockin'];
                        $actual_amount = $qty * $cost;
                        $check = mysqli_query(
                            $conn,
                            "SELECT * FROM product WHERE code='$code'"
                        );
                        if (mysqli_num_rows($check) > 0) {
                            $insert = mysqli_query(
                                $conn,
                                "UPDATE product set qty_stock='$qty',on_hand='$qty',price='$selling',unit='$unit',date_stock_in='$orderdate',purchasing_price='$cost',actual_amount='$actual_amount' WHERE code='$code'"
                            );
                            if ($insert) {
                                echo '<div class="alert alert-success" role="alert">
                            Data Updated Successfully!!
                          </div>';
                            } else {
                                echo '<div class="alert alert-warning" role="alert">
                            No Data Updated!!
                          </div>' . mysqli_error($conn);
                            }
                        }
                    } ?>

                    <div class="panel-body">
                        <div class="row">
                                <form action="<?php echo htmlentities(
                                    $_SERVER['PHP_SELF']
                                ); ?>" method="POST">
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
                                    <div class="col-lg-4">
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
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Stock in Date</label>
                                            <input type="date" name="stockin" class="form-control" required/>
                                        </div>
                                </div>
                            </div>
                            <div class="text-center">
                                    <button type="submit" name="savedata" class="btn btn-primary">Submit</button>
                    </div>
                                </form>
                        <hr>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>S/No</th>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Category</th>
                                                    <th>Supplier</th>
                                                    <th>Quantity</th>
                                                    <th>Purchasing Price</th>
                                                    <th>Selling Price</th>
                                                    <th>Actual Amt</th>
                                                    <th>Units</th>

                                                    <th>Action</th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sn = 1;
                                                $query = mysqli_query(
                                                    $conn,
                                                    'SELECT * FROM product join supplier 
                                                    ON supplier.supplier_id=product.supplier_id 
                                                    join product_category ON product_category.category_id=product.category_id'
                                                );
                                                while (
                                                    $row_data = mysqli_fetch_assoc(
                                                        $query
                                                    )
                                                ) { 
                                                   
                                                    ?>
                                                <tr class="odd gradeX">
                                                <td><?php
                                                echo $sn;
                                                $sn++;
                                                ?></td>
                                                    <td><?php echo $row_data[
                                                        'code'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'pname'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'cname'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'company_name'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'qty_stock'
                                                    ]; ?></td>
                                                      <td><?php echo $row_data[
                                                          'purchasing_price'
                                                      ]; ?></td>
                                                       <td><?php echo $row_data[
                                                           'price'
                                                       ]; ?></td>
                                                        <td><?php echo $row_data[
                                                           'actual_amount'
                                                       ]; ; ?></td>
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
                                    <p class="pull-right"><b>Total Amount: <?php 
                                    $amt = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sum(actual_amount) as sum FROM product"));
                                    echo $amt["sum"]; ?></b></p>
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