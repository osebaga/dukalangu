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
                    <?php
                    $query_item = mysqli_query($conn, 'SELECT * FROM product');

                    if (isset($_POST['addInvoice'])) {
                        $customer = $_POST['customerid'];
                        $transid = $_POST['trans_code'];
                        $pname = $_POST['pname'];
                        $qty = $_POST['quantity'];
                        $selprice = $_POST['selling_price'];
                        $actualamt = $_POST['actual_amount'];
                        $vatamt = $_POST['vat_amount'];
                        $sumamt = $_POST['sum_amount'];
                        $date = date('Y-m-d');

                        $actualamt1 = array_sum($actualamt);
                        $sumamt1 = array_sum($sumamt);
                        $vatamt1 = array_sum($vatamt);
                        $qty1 = array_sum($qty);

                        ($inser_transaction = mysqli_query(
                            $conn,
                            "INSERT INTO transaction(CUST_ID,NUMOFITEMS,SUBTOTAL,GRANDTOTAL,NETVAT,CASH,DATE,TRANS_D_ID) 
                      VALUES('$customer','$qty1','$actualamt1','$sumamt1','$vatamt1','paid','$date','$transid')"
                        )) or die(mysqli_error($conn));

                        foreach ($pname as $key => $value) {
                            $selprice2 = $qty[$key] * $selprice[$key];
                            $qty2 = $qty[$key];
                            $pname = $value;

                            $inser_details = mysqli_query(
                                $conn,
                                "INSERT INTO transaction_details(TRANS_D_ID,PRODUCTS,QTY,PRICE) VALUES('$transid','$pname','$qty2','$selprice2')"
                            );
                        }

                        if ($inser_details) {
                            echo 'Data Saved';
                        } else {
                            echo 'Data Not Saved' . mysqli_error($conn);
                        }
                    }
                    ?>
                    <div class="panel-body">
                        <form action="<?php echo htmlentities(
                            $_SERVER['PHP_SELF']
                        ); ?>" method="POST">
                        <input type="text" name="customerid" class="form-control" style='width: 150px' value="<?php echo date(
                            'Y'
                        ) .
                            rand(
                                11,
                                99
                            ); ?>" placeholder="Enter customer name" required>
                        <input type="hidden" name="trans_code" value="<?php echo 'TRAS-' .
                            rand(11, 99); ?>"  class="form-control"/>

                            <br><br>
                                    <!-- <a href="#" id="item1">click</a> -->
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                       <thead>
                                        <tr>
                                            <th>S/No</th>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>units</th>
                                            <th>Selling Price</th>
                                            <th>Actual Amount</th>
                                            <th>VAT Amount</th>
                                            <th>GrandTotal</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                            <tbody id="tbody">
                                            <?php
                                              
                                              $query = mysqli_query($conn,'SELECT * FROM product');
                                            
                                                  ?>
                                              <tr>
                                                    <td>1</td>
                                                  <td>
                                                      <select name="pname[]" id="item0" class="form-control"  style="width: 150px">
                                                          <option value=""></option>
                                                          <?php while($row_data = mysqli_fetch_assoc($query)){?>
                                                          <option value="<?php echo  $row_data['code']; ?>"><?php echo  $row_data['pname']; ?></option>
                                                      <?php } ?>
                                                        </select>
                                                  </td>
                                                  <td>
                                                      <input type="text" name="quantity[]" id="qty0" class="form-control" style="width: 60px" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" >
                                                  </td>
                                                  <td>
                                                  <select type="text" name="units[]" class="form-control" required>
                                                  <option value="">select units</option>
                                                  <option value="Kg">kilogram</option>
                                                  <option value="Dozen">Dozen</option>
                                                  <option value="Grams">Grams</option>
                                                  <option value="m">meter</option>
                                                  <option value="Box">Boxes</option>
                                                  <option value="crates">Crates</option>

                                              </select>
                                                  </td>
                                                  <td>
                                                  <input type="text" name="selling_price[]" id="price0" style="width: 90px" value="<?php echo $row_data[''] ?>" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                                                  </td>
                                                  <td>
                                                  <input type="text" name="actual_amount[]" id="actual_amount0" style="width: 90px" value="<?php echo $row_data[''] ?>" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                                                  </td>
                                                    <td>
                                                   
                                                    <input type="text" name="vat_amount[]" id="vat0" class="form-control" style="width: 90px" value="<?php echo $row_data[''] ?>" >
                                                    <input type="hidden" name="vat_value" id="vat_value0" value="<?php echo $row_data[''] ?>" >
                                                    <input type="hidden" name="vatcheck" id="vatcheck0" value="<?php echo $row_data[''] ?>" >

                                                    </td>
                                                    <td>
                                                    <input type="text" name="sum_amount[]" id="sum0" value="<?php echo $row_data[''] ?>" style="width: 90px" class="form-control" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">

                                                    </td>
                                                    
                                                     <td><i class='fa fa-plus-circle' onclick="addItem();"></1></td>


                                              </tr>
                                  
                                            </tbody>
                                        </table>

                                        <!-- <button type="button" onclick="addItem();">Add Item</button> -->
                                        <input type="submit" class="btn btn-primary pull-right" name="addInvoice" value="Add Invoice">
                                        </form>
                                                                
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




<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
    // $(document).ready(function() {
    //     $('#dataTables-example').DataTable({
    //             responsive: true
    //     });
    // });
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function() {
        $(this).remove();
        // window.location = 'lecturerProgrammecourselist.php';

      });
    }, 4000);


   $("input#number").each((i,ele)=>{
    let clone=$(ele).clone(false)
    clone.attr("type","text")
    let ele1=$(ele)
    clone.val(Number(ele1.val()).toLocaleString("en"))
    $(ele).after(clone)
    $(ele).hide()
    clone.mouseenter(()=>{

      ele1.show()
      clone.hide()
    })
    setInterval(()=>{
      let newv=Number(ele1.val()).toLocaleString("en")
      if(clone.val()!=newv){
        clone.val(newv)
      }
    },10)

    $(ele).mouseleave(()=>{
      $(clone).show()
      $(ele1).hide()
    })
    

  })


var items = 0;
var item =0;
    function addItem() {
        items++;
        if(items==1){
             items = 2;
        }else{
           items =items;
        }
        var html = "<tr>";
            html += "<td>" + items + "</td>";
            html += "<td><select type='text'  name='pname[]' id='item"+items+"' class='form-control' style='width: 150px' ><option value=''>select item</option> <?php while (
                $row_data = mysqli_fetch_assoc($query_item)
            ) { ?><option value='<?php echo $row_data[
    'code'
]; ?>'><?php echo $row_data['pname']; ?></option><?php } ?></select></td>";
            html += "<td><input type='text' name='quantity[]' id='qty"+items+"' onkeypress='return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))' class='form-control' style='width: 60px'></td>";
            html += "<td><select type='text' name='units[]' class='form-control' style='width: 100px'><option value='kg'>Kilogram</option><option value='dozen'>Dozen</option><option value='gram'>Gram</option><option value='m'>Meter</option><option value='crate'>crates</option><option value='box'>Box</option><option value='cm'>centimeter</option></select></td>";
            html += "<td><input type='text' name='selling_price[]' id='price"+items+"' onkeypress='return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))' class='form-control' style='width: 90px'></td>";
            html += "<td><input type='text' name='actual_amount[]' id='actual_amount"+items+"' onkeypress='return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))' class='form-control' style='width: 90px'></td>";
            html += "<td><input type='text' name='vat_amount[]' id='vat"+items+"' onkeypress='return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))' class='form-control' style='width: 90px'><input type='hidden' name='vatcheck' id='vatcheck"+items+"'><input type='hidden' name='vat_value' id='vat_value"+items+"'></td>";
           
            html += "<td><input type='text' name='sum_amount[]' id='sum"+items+"' onkeypress='return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))' class='form-control' style='width: 90px'></td>";
            html += "<td><i onclick='deleteRow(this);'class='fa fa-trash-o' style='color:red'></i> | <i class='fa fa-plus-circle' style='color:yellowish' onclick='addItem();'></i></td>"

        html += "</tr>";
 
        var row = document.getElementById("tbody").insertRow();
        var qty = $('#qty'+item+'').val();
       
        row.innerHTML = html;
         item =items;
         console.log(item);

         if(item == 0){
     item = item + 1;
}else{
    item = item;
}

console.log(item);
$(document).on('change','#item'+item+'',function(){
var itm = $(this).val();
// alert(itm);

$.ajax({
     url:'ajax.php/?itm='+itm,
     type:'GET',
     success:function(response){
        var data = JSON.parse(response);
        $('#price'+item+'').val(data.price);
        $('#vatcheck'+item+'').val(data.vat);
        $('#vat_value'+item+'').val(data.vat_value);
     }
});
   
});
$(document).on('paste keyup','#qty'+item+'',function(){
 var amount = 0;
 var grandtotal = 0;
 var vat_amount=0;

 var qty = $('#qty'+item+'').val();
 var price = $('#price'+item+'').val();
 var vatcheck = $('#vatcheck'+item+'').val();
 var vat_value = $('#vat_value'+item+'').val();

 console.log(vatcheck);

    amount  = parseInt(qty) * parseInt(price);
    $('#actual_amount'+item+'').val(amount);
   
    if(vatcheck==1){
        vat_amount= parseFloat(vat_value) * parseInt(amount);
    }
    console.log(vat_amount);
     $('#vat'+item+'').val(vat_amount);
     grandtotal = parseInt(vat_amount)+ parseInt(amount);
     $('#sum'+item+'').val(grandtotal);

    console.log(grandtotal);
});
    }
 
function deleteRow(button) {
    items--
    button.parentElement.parentElement.remove();
    // first parentElement will be td and second will be tr.
}

</script>

<script>
    $(document).on('change','#item0',function(){
var itm = $(this).val();
// alert(itm);


$.ajax({
     url:'ajax.php/?itm='+itm,
     type:'GET',
     success:function(response){
        var data = JSON.parse(response);
        $('#price0').val(data.price);
        $('#vatcheck0').val(data.vat);
        $('#vat_value0').val(data.vat_value);

        console.log(data);
     }
});
   
});
$(document).on('paste keyup','#qty0',function(){
 var amount = 0;
 var grandtotal = 0;
 var vat_amount=0;

 var qty = $('#qty0').val();
 var price = $('#price0').val();
 var vatcheck = $('#vatcheck0').val();
 var vat_value = $('#vat_value0').val();
 
 console.log(vatcheck);
 amount  = parseInt(qty) * parseInt(price);
    $('#actual_amount0').val(amount);
    if(vatcheck==1){
        vat_amount= parseFloat(vat_value) * parseInt(amount);
    }
     $('#vat0').val(vat_amount);
     grandtotal = parseInt(vat_amount)+ parseInt(amount);
     $('#sum0').val(grandtotal);

    console.log(grandtotal);
});

</script>

<?php include 'layouts/footer.php'; ?>
