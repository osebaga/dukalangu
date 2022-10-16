<?php
include 'layouts/header.php';
include 'layouts/sidebar.php';
include 'includes/connection.php';
?>
<div id="wrapper">
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Accounts</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       Account Register Form
                    </div>
                    <?php
                    $query = mysqli_query(
                        $conn,
                        'SELECT * FROM account_category'
                    );

                    if (isset($_POST['saveaccount'])) {
                        $code = $_POST['code'];
                        $name = $_POST['account_name'];
                        $type = $_POST['type'];
                        $category = $_POST['category'];
                        $balance = $_POST['balance'];
                        $date = $_POST['startdate'];
                        $status = $_POST['status'];

                        $check = mysqli_query(
                            $conn,
                            "SELECT * FROM accounts WHERE code='$code'"
                        );
                        if (mysqli_num_rows($check) > 0) {
                            echo '<div class="alert alert-danger" role="alert">
                        This account category already exists!
                      </div>';
                        } else {
                            $insert = mysqli_query(
                                $conn,
                                "INSERT INTO accounts(code,name,account_type,account_category,opening_balance,start_date,account_status) VALUES('$code','$name','$type','$category','$balance','$date','$status')"
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
                    }
                    ?>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form action="<?php echo htmlentities(
                                    $_SERVER['PHP_SELF']
                                ); ?>" method="POST">
                                <div class="form-group">
                                        <label>Account Code</label>
                                        <input class="form-control" name="code" pattern="(?=.*\d)(?=.*[A-Z]).{5,}" maxlength="5" placeholder="E.g ACC01,ACC02,ACC020" title="Must start with caps letter ACC and atleast two number" required>
                                    </div>
                                <div class="form-group">
                                        <label>Account Name</label>
                                        <input class="form-control" name="account_name" required>
                                    </div>
                                    <div class="form-group">
                                    <div class="col-lg-6">
                                        <label>Account Type</label>
                                        <select  class="form-control" id="" name="type" required>
                                        <option value="">select account type</option>    
                                        <option value="1">Bank</option>
                                        <option value="2">Money Agent</option>
                                        </select>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                    <div class="col-lg-6">
                                        <label>Account Category</label>
                                        <select class="form-control" name="category" required>
                                            <option value="">select category</option>
                                            <?php while (
                                                $row = mysqli_fetch_assoc(
                                                    $query
                                                )
                                            ) { ?>
                                                <option value="<?php echo $row[
                                                    'id'
                                                ]; ?>"><?php echo $row[
                                                    'short_name'
                                                ]; ?></option>
                                           <?php } ?>
                                        </select>
                                    </div>
                                    </div>
                                 
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                            <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="disabledSelect">Opening Balance</label>
                                            <input type="text" name="balance" required class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" placeholder="10000,100000 etc"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="disabledSelect">AS of Date</label>
                                            <input class="form-control" type="date" name="startdate" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="disabledSelect">Status</label>
                                            <select class="form-control" name="status" required>
                                            <option value="">select account status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>

                                            </select>
                                        </div>
                            </div>
     
                            <button type="submit" name="saveaccount" style="margin-right: 5%;" class="btn btn-primary pull-right">Submit Button</button>
                             </form>
                        </div>
                        <hr>
                        <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>S/No</th>
                                                    <th>Account Code</th>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Category</th>
                                                    <th>Opening Balance</th>
                                                    <th>As of date</th>
                                                    <th>Status</th>
                                                    <th colspan="2">Action</th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sn = 1;
                                                $query = mysqli_query(
                                                    $conn,
                                                    'SELECT * FROM accounts'
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
                                                        'name'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'account_type'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'account_category'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'opening_balance'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'start_date'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'account_status'
                                                    ]; ?></td>

                                                    <td class="btn btn-success">Edit</td>
                                                    <td class="btn btn-danger">Delete</td>

                                                </tr>
                                           
                                     <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                    </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<script src="../js/dataTables/jquery.dataTables.min.js"></script>
<script src="../js/dataTables/dataTables.bootstrap.min.js"></script>

<?php include 'layouts/footer.php'; ?>
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