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
                    <h2 class="page-header">Account Category</h2>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Account Category
                        </div>
                        <?php if (isset($_POST['savedata'])) {
                            $cname = $_POST['categoryname'];
                            $short_name = $_POST['shortname'];

                            $check = mysqli_query(
                                $conn,
                                "SELECT * FROM account_category WHERE short_name='$short_name'"
                            );
                            if (mysqli_num_rows($check) > 0) {
                                echo '<div class="alert alert-danger" role="alert">
                            This account category already exists!
                          </div>';
                            } else {
                                $insert = mysqli_query(
                                    $conn,
                                    "INSERT INTO account_category(name,short_name) VALUES('$cname','$short_name')"
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
                            <form action="<?php echo htmlentities(
                                $_SERVER['PHP_SELF']
                            ); ?>" method="POST">
                                <div class="form-row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Category Name</label>
                                            <input class="form-control" name="categoryname">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Short Name(Abbreviation)</label>
                                            <input class="form-control" name="shortname" placeholder="Eg NMB">
                                        </div>
                                    </div>

                                    <button type="submit" name="savedata" style="margin: 2.6% 0 0 4%;" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
<hr>
                        <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>S/No</th>
                                                    <th>Category Name</th>
                                                    <th>Short Name</th>
                                                    <th colspan="2">Action</th>
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $sn = 1;
                                                $query = mysqli_query($conn, "SELECT * FROM account_category");
                                                while ($row_data = mysqli_fetch_assoc($query)) {?>
                                                <tr class="odd gradeX">
                                                <td><?php echo $sn;$sn++; ?></td>
                                                    <td><?php echo $row_data['name']; ?></td>
                                                    <td><?php echo $row_data['short_name']; ?></td>
                                                    <td class="btn btn-success">Edit</td>
                                                    <td class="btn btn-danger">Delete</td>

                                                </tr>
                                           
                                     <?php  }  ?>
                                            </tbody>
                                        </table>
                                    </div>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
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


<?php include 'layouts/footer.php'; ?>
  <!-- DataTables JavaScript -->
<script src="../js/dataTables/jquery.dataTables.min.js"></script>
<script src="../js/dataTables/dataTables.bootstrap.min.js"></script>

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