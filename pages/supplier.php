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
                <h1 class="page-header">Suppliers</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       Register Product Supplier
                    </div>
                    <?php if (isset($_POST['savedata'])) {
                        $cname = $_POST['cname'];
                        $email = $_POST['email'];
                        $person = $_POST['contactperson'];
                        $phone = $_POST['mobile'];
                        $location = $_POST['location'];

                        $check = mysqli_query(
                            $conn,
                            "SELECT * FROM supplier WHERE company_email='$email'"
                        );
                        if (mysqli_num_rows($check) > 0) {
                            echo '<div class="alert alert-danger" role="alert">
                        This account category already exists!
                      </div>';
                        } else {
                            $insert = mysqli_query(
                                $conn,
                                "INSERT INTO supplier(company_name,contact_name,company_email,location_id,mobile) VALUES('$cname','$person','$email','$location','$phone')"
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
                                <div class="col-lg-6">
                                <div class="form-group">
                                        <label>Company Name</label>
                                        <input class="form-control" name="cname"  placeholder="E.g Oseboy Technologies Limited" required>
                                    </div>
                                </div>   
                                <div class="col-lg-6">
                                    <div class="form-group">
                                            <label for="disabledSelect">Company Email</label>
                                            <input type="email" name="email" required class="form-control" placeholder="oseboy@gmail.com"/>
                                        </div>
                                </div>

                                <div class="col-lg-4">
                                <div class="form-group">
                                        <label>Contact Person</label>
                                        <input class="form-control" name="contactperson" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                            <label for="disabledSelect">Contact Mobile</label>
                                            <input type="text" name="mobile" required class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" maxlength="10" placeholder="07....."/>
                                        </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select class="form-control" name="location" required>
                                            <option value="">select location</option>
                                            <?php
                                            $query = mysqli_query(
                                                $conn,
                                                'SELECT * FROM location'
                                            );

                                            while (
                                                $row = mysqli_fetch_assoc(
                                                    $query
                                                )
                                            ) { ?>
                                                <option value="<?php echo $row[
                                                    'location_id'
                                                ]; ?>"><?php echo $row[
    'city'
]; ?></option>
                                           <?php }
                                            ?>
                                        </select>
                                    </div>
                                    </div>
                            </div>
                                    <button type="submit" name="savedata" class="btn btn-primary pull-right">Submit Button</button>
                                </form>
                        </div>
<hr>
                        <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>S/No</th>
                                                    <th>Company Name</th>
                                                    <th>Company Email</th>
                                                    <th>Contact Person</th>
                                                    <th>Contact Mobile</th>
                                                    <th>Location</th>
                                                    <th colspan="2">Action</th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sn = 1;
                                                $query = mysqli_query(
                                                    $conn,
                                                    'SELECT * FROM supplier'
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
                                                        'company_name'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'company_email'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'contact_name'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'mobile'
                                                    ]; ?></td>
                                                    <td><?php echo $row_data[
                                                        'location_id'
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

<!-- <script src="../js/dataTables/jquery.dataTables.min.js"></script>
<script src="../js/dataTables/dataTables.bootstrap.min.js"></script> -->

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