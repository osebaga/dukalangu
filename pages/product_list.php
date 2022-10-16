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
                    <h2 class="page-header">Product/Items</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       Product List
                    </div>
                    <?php if (isset($_POST['savedata'])) {
                        $code = $_POST['pcode'];
                        $pname = $_POST['pname'];
                        $desc = $_POST['description'];
                        // $unit = $_POST['unit'];
                        $type = $_POST['type'];
                        $cat = $_POST['category'];
                        $supplier = $_POST['supplier'];
                        $level = $_POST['level'];

                        $check = mysqli_query(
                            $conn,
                            "SELECT * FROM product WHERE code='$code'"
                        );
                        if (mysqli_num_rows($check) > 0) {
                            echo '<div class="alert alert-danger" role="alert">
                        This account category already exists!
                      </div>';
                        } else {
                            $insert = mysqli_query(
                                $conn,
                                "INSERT INTO product(code,pname,description,product_type,category_id,supplier_id,reorder_level) VALUES('$code','$pname','$desc','$type','$cat','$supplier','$level')"
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
                    } ?>

                    <div class="panel-body">
                        <div class="row">
                                <form action="<?php echo htmlentities(
                                    $_SERVER['PHP_SELF']
                                ); ?>" method="POST">
                                   <div class="col-lg-4">
                                <div class="form-group">
                                        <label>Product Code</label>
                                        <input class="form-control" name="pcode"  placeholder="E.g D1.40500.B" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                <div class="form-group">
                                        <label>Product Name</label>
                                        <input class="form-control" name="pname"  placeholder="E.g Coca-Cola,Pepsi" required>
                                    </div>
                                </div>   
                                <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Supplier Name</label>
                                            <select type="text" name="supplier" required class="form-control" placeholder="GSM">
                                            <option value="">select Supplier</option>
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
                                        <label>Product Category</label>
                                        <select class="form-control"  id="dynamic_select" name="category" required>
                                        <option value="">select category</option>
                                            <?php
                                            $query = mysqli_query(
                                                $conn,
                                                'SELECT * FROM product_category'
                                            );

                                            while (
                                                $row = mysqli_fetch_assoc(
                                                    $query
                                                )
                                            ) { ?>
                                                <option value="<?php echo $row[
                                                    'category_id'
                                                ]; ?>"><?php echo $row[
    'cname'
]; ?></option>
                                           <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                <div class="form-group">
                                        <label>Product Type</label>
                                        <select class="form-control" name="type" required>
                                            <option value="">select type</option>
                                            <option value="Stock">Stock</option>
                                            <option value="Service">Service</option>
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Reorder Level</label>
                                            <input type="text" name="level" class="form-control" required onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"/>
                                        </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea type="text" name="description" class="form-control"></textarea>
                                    </div>
                                    </div>
                                    <!-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Units</label>
                                        <select type="text" name="unit" class="form-control">
                                            <option value="">select units</option>
                                            <option value="Kg">kilogram</option>
                                            <option value="Dozen">Dozen</option>
                                            <option value="Grams">Grams</option>
                                            <option value="m">meter</option>
                                            <option value="Box">Boxes</option>
                                            <option value="crates">Crates</option>

                                        </select>
                                    </div>
                                    </div> -->
                                    <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Expire Date</label>
                                        <input type="date" name="expiredate" required class="form-control"/>
                                    </div>
                                    </div>
                            </div>
                            <div class="text-center">
                                    <button type="submit" name="savedata" class="btn btn-primary">Submit Button</button>
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
                                                    <th>Reorder Level</th>
                                                    <th>Purchasing Price</th>
                                                    <th>Selling Price</th>
                                                    <th>Units</th>

                                                    <th>Action</th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sn = 1;
                                                $query = mysqli_query(
                                                    $conn,
                                                    'SELECT * FROM product'
                                                );
                                                while (
                                                    $row_data = mysqli_fetch_assoc(
                                                        $query
                                                    )
                                                ) { ?>
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
                                                        'category_id'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'supplier_id'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'reorder_level'
                                                    ]; ?></td>
                                                      <td><?php echo $row_data[
                                                          'purchasing_price'
                                                      ]; ?></td>
                                                       <td><?php echo $row_data[
                                                           'price'
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
                    </div>
                </div>

                <!-- /.row (nested) -->
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